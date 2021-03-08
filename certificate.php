<?php 
	session_start();
	require('fpdf17/fpdf.php');
	require_once('connection.php');

	class PDF extends FPDF
	{
	// Page header
		function Footer()
		{
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetTextColor(211,211,211);
			$this->Cell(97.5, 4, 'NOTE: SHOULD YOU ENCOUNTED ANY ISSUES', 0,1);
			$this->Cell(97.5, 4, 'OR CONCERNS, YOU MAY CONTACT: ', 0,1);
			$this->Cell(97.5, 4, '7791-8545/ 09231337019/ 09065131440', 0,1);
		}

		function Header()
		{
			$this->Image('majesty-images/LTO.png',50,15,20,'PNG');
			$this->Image('majesty-images/majesty-logo.png',70,10,80,'PNG');
			$this->Image('majesty-images/DOTR.png',150,15,20,'PNG');
		}

	}

	$pdf = new PDF('P','mm','A4');

	$pdf->SetTitle('Majesty Driving School');

	$pdf->AddPage();

	$idx = urlDecoding();

 	$haha = explode("+", $idx);

	if(isset($haha[0])){
		$id = $haha[0];
		
		if(isset($haha[1])){
			writeLogs("Reprinting certificate - ".$id);
		} 
	
	$sql = "SELECT * FROM tbl_studentInfo INNER JOIN tbl_trainingInfo ON studID = trainStudentID WHERE studID = $id";

	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
	    $certFirstname  = strtoupper($row["studFirstname"]);
	    $certMiddlename  = strtoupper($row["studMiddlename"]);
	    $certLastname  = strtoupper($row["studLastname"]);
	    $certAddress  = strtoupper($row["studAddress"]);
	    
	    $certDOB  = $row["studDOB"];
	    $certNationality  = $row["studNationality"];
	    $certGender  = $row["studGender"];
	    $certMaritalStatus  = $row["studMaritalStatus"];
	    $certCapture  = $row["studCapture"];
	    $certInstructor = $row["studInstructorID"];
	    $certDate = $row["studDateCertified"];

	    $certCourse  = $row["trainCourse"];
	    $certProgram  = $row["trainProgram"];
	    $certDLNo  = $row["trainDLNo"];
	    $certPurpose  = $row["trainPurpose"];
	    $certMV  = "";//$row["trainMV"];
	    $certDL  = $row["trainDL"];
	    $certStarted  = $row["trainStarted"];
	    $certCompleted  = $row["trainCompleted"];
	    $certHours  = $row["trainHours"];
	    $certAssessment  = $row["trainAssessment"];
	    $certOverall  = $row["trainOverall"];
	    $certRemarks  = strtoupper($row["trainRemarks"]);
	  }
	} 

	
		//DL data
		$DL1 = str_replace("[","",$certDL);
		$DL2 = str_replace("]","",$DL1);
		$DL3 = explode(",", $DL2);


		$DLcount = count($DL3);

	

	$DLCodesX = array (
	  array("","","",""), 
	  array("","","",""), 
	  array("","","",""), 
	  array("","","",""), 
	  array("","","","")  
	);

	$x = 0;
	$y = 1;
	sort($DL3);
	for ($j=1; $j < $DLcount ; $j++) { 

		$dlcodes = explode("/", $DL3[$j]);

		$DLCodesX[$j-$y][$x] = $dlcodes[0].'-'.$dlcodes[1];

		if($j == 5 ){
			$x++;
			$y=6;
		}else if($j == 10 ){
			$x++;
			$y=12;
		}else if($j == 15 ){
			$x++;
			$y=18;
		}

	}
		
	$pdf->SetFont('Times');

	$pdf->Cell(190, 30, '', 0,1);
	
	$pdf->SetFontSize(9);
	
	$pdf->Cell(190, 4, 'DEPARTMENT OF TRANSPORTATION', 0, 1,'C'); //
	$pdf->Cell(190, 4, 'LAND TRANSPORTATION OFFICE', 0, 1,'C');

	$pdf->SetFont('Times','B',15);

	$pdf->Cell(190, 10, 'CERTIFICATE OF DRIVING COURSE COMPLETION', 0, 1,'C');

	$pdf->SetFont('Arial','B',9);
	$pdf->SetFillColor(255, 230, 155);
	$pdf->Cell(70, 6, 'STUDENT DRIVER INFORMATION', 1, 1, 'C',true);

	if(strlen($certCapture) > 1371){
		$pdf->Image('data://text/plain;base64,'.base64_decode($certCapture),155,59,45,50,'JPG');
	}else{
		$pdf->Image('majesty-images/unknown.jpg',155,59,45,45,'JPG');
	}

	//Name Line
	$pdf->SetFont('Times','',9);
	$pdf->Cell(190, 5, '', 0,1);
	$pdf->Cell(48, 5, $certFirstname, 0, 0, 'C');	$pdf->Cell(48, 5, $certMiddlename, 0, 0, 'C');	$pdf->Cell(48, 5, $certLastname, 0, 1, 'C');
	$pdf->Cell(2.5, 0.1, '', 0, 0);
		$pdf->Cell(43, 0.1, '', 1, 0);	
	$pdf->Cell(5, 0.1, '', 0, 0);
		$pdf->Cell(43, 0.1, '', 1, 0);	
	$pdf->Cell(5, 0.1, '', 0, 0);
		$pdf->Cell(43, 0.1, '', 1, 1);
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(48, 5, 'FIRST NAME', 0, 0, 'C');	$pdf->Cell(48, 5, 'MIDDLE NAME', 0, 0, 'C');	$pdf->Cell(48, 5, 'LAST NAME', 0, 1, 'C');

	//Address Line
	$pdf->Cell(190, 2, '', 0,1);
	$pdf->Cell(18, 5, 'ADDRESS: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->MultiCell(124, 5, $certAddress, 0, 1); 
	$countAddressHeight = $pdf->GetY(); 
	$pdf->Cell(18, 0.1, '', 0, 0);
	$pdf->Cell(124, 0.1, '', 1, 1);
	

	//Extra's Line
	$pdf->Cell(190, 2, '', 0,1);
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(47, 5, 'DRIVERS LICENCE NUMBER:', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(43, 5, $certDLNo, 0, 0);
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(28, 5, 'DATE OF BIRTH:', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(24, 5, $newDate = date("m/d/Y", strtotime($certDOB)), 0, 1);

	$pdf->Cell(47, 0.1, '', 0, 0);
	$pdf->Cell(43, 0.1, '', 1, 0);
	$pdf->Cell(28, 0.1, '', 0, 0);
	$pdf->Cell(24, 0.1, '', 1, 1);

	$pdf->Cell(190, 2, '', 0,1);
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(25, 5, 'NATIONALITY: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(39, 5, strtoupper($certNationality), 0, 0); 
	

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(10, 5, 'AGE: ', 0, 0);
	$pdf->SetFont('Times','',9);
	

    function age($birthday){
	 list($month, $day, $year) = explode("/", $birthday);
	 $year_diff  = date("Y") - $year;
	 $month_diff = date("m") - $month;
	 $day_diff   = date("d") - $day;
	 if ($day_diff < 0 && $month_diff==0) $year_diff--;
	 if ($day_diff < 0 && $month_diff < 0) $year_diff--;
	 return $year_diff;
	}

	$pdf->Cell(7, 5, age($newDate) , 0, 0);

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(16, 5, 'GENDER: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(7, 5, $certGender, 0, 0);

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(31, 5, 'MARITAL STATUS: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(7, 5, $certMaritalStatus, 0, 1);

	$pdf->Cell(25, 0.1, '', 0, 0);
	$pdf->Cell(39, 0.1, '', 1, 0);

	$pdf->Cell(10, 0.1, '', 0, 0);
	$pdf->Cell(7, 0.1, '', 1, 0);

	$pdf->Cell(16, 0.1, '', 0, 0);
	$pdf->Cell(7, 0.1, '', 1, 0);

	$pdf->Cell(31, 0.1, '', 0, 0);
	$pdf->Cell(7, 0.1, '', 1, 1);

	$pdf->Cell(190, 5, '', 0,1);

	$pdf->SetFillColor(255, 230, 155);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(70, 6, 'DRIVING COURSE TRAINING INFORMATION', 1, 1, 'C',true);

	$pdf->Cell(190, 5, '', 0,1);

	
	if($certCourse == "TDC"){
		$certCourse = "THEORETICAL DRIVING COURSE";
	}else if($certCourse == "PDC"){
		$certCourse = "PRACTICAL DRIVING COURSE";
	}

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(42, 5, 'DRIVING COURSE NAME: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(148, 5, $certCourse, 0, 1);
	$pdf->Cell(42, 0.1, '', 0, 0);
	$pdf->Cell(148, 0.1, '', 1, 1);
	$pdf->Cell(190, 2, '', 0,1);

	if($certProgram == "TIT"){
		$certProgram = "THEORETICAL INSTRUCTION TRAINING";
	}else if($certProgram == "PDIT"){
		$certProgram = "PRACTICAL DRIVING INSTRUCTION TRAINING";
	}

	if($certPurpose == "SP"){
		$certPurpose = "STUDENT PERMIT";
	}else if($certPurpose == "NEW"){
		$certPurpose = "NEW DRIVER'S LICENCE"; 
	}else if($certPurpose == "ADD"){
		$certPurpose = "ADDING RESTRICTION CODE";
	}else if($certPurpose == "SEM"){
		$certPurpose = "SEMINAR";
	}

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(29, 5, 'PROGRAM TYPE: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(73, 5, $certProgram, 0, 0);
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(35, 5, 'TRAINING PURPOSE: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(53, 5, $certPurpose, 0, 1);

	$pdf->Cell(29, 0.1, '', 0, 0);
	$pdf->Cell(73, 0.1, '', 1, 0);
	$pdf->Cell(35, 0.1, '', 0, 0);
	$pdf->Cell(53, 0.1, '', 1, 1);
	$pdf->Cell(190, 2, '', 0,1);

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(27, 5, 'MV TYPE USED: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(163, 5, $certMV, 0, 1); 

	$pdf->Cell(27, 0.1, '', 0, 0);
	$pdf->Cell(163, 0.1, '', 1, 1);
	$pdf->Cell(190, 2, '', 0,1);

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(19, 5, 'DL CODES: ', 0, 0);
	$pdf->SetFont('Times','',9);


	for ($j=0; $j < 5 ; $j++) { 

		for($i = 0; $i < 4; $i++){
			$pdf->Cell(42.75,5, $DLCodesX[$j][$i],0,0,'C');

		}	

		$pdf->Cell(0.1,5,'',0,1);
		$pdf->Cell(19, 5, '', 0, 0);
	}
	

	$pdf->Cell(190, 2, '', 0, 1);
	

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(27, 5, 'DATE STARTED: ', 0, 0);
	$pdf->SetFont('Times','',9);

	$pdf->Cell(38, 5, $newDate2 = date("m/d/Y", strtotime($certStarted)), 0, 0); //strtotime($strDStarted
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(32, 5, 'DATE COMPLETED: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(33, 5, $newDate3 = date("m/d/Y", strtotime($certCompleted)), 0, 0); //strtotime($strDCompleted
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(46, 5, 'TOTAL NUMBER OF HOURS: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->Cell(14, 5, $certHours, 0, 1);
	

	$pdf->Cell(27, 0.1, '', 0, 0);
	$pdf->Cell(37, 0.1, '', 1, 0);
	$pdf->Cell(33, 0.1, '', 0, 0);
	$pdf->Cell(32, 0.1, '', 1, 0);
	$pdf->Cell(47, 0.1, '', 0, 0);
	$pdf->Cell(14, 0.1, '', 1, 1);

	$pdf->Cell(190, 5, '', 0,1);

	$pdf->SetFillColor(255, 230, 155);
	$pdf->SetFont('Arial','B',9);
	$pdf->Cell(70, 6, 'DRIVING COURSE TRAINING EVALUATION', 1, 1, 'C',true);

	$pdf->Cell(190, 5, '', 0,1);

	$pdf->SetFont('Times','',9);
	$pdf->Cell(32.5, 5, '', 0, 0);
	$pdf->Cell(32.5, 5, 'PASSED', 0, 0,'C');
	$pdf->Cell(32.5, 5, 'FAILED', 0, 1,'C');

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(32.5, 5, 'ASSESSMENT:', 0, 0);
	$pdf->Cell(15, 5, '',0, 0);
	$pdf->SetFont('Times','B',15);

	if($certAssessment == "P"){ 
		$pdf->Cell(2.5, 3, iconv("UTF-8", "ISO-8859-1", "×"), 1, 0,'C');
	}else{
		$pdf->Cell(2.5, 3, '', 1, 0,'C');
	}

	$pdf->Cell(15, 5, '',0, 0);
	$pdf->Cell(15, 5, '',0, 0);

	if($certAssessment == "F"){ 
		$pdf->Cell(2.5, 3, iconv("UTF-8", "ISO-8859-1", "×"), 1, 0,'C');
	}else{
		$pdf->Cell(2.5, 3, '', 1, 0,'C');
	}
	$pdf->Cell(15, 5, '',0, 1);
	

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(32.5, 5, 'OVERALL RATING:', 0, 0);
	$pdf->Cell(15, 5, '',0, 0);
	$pdf->SetFont('Times','B',15);

	if($certOverall == "P"){ 
		$pdf->Cell(2.5, 3, iconv("UTF-8", "ISO-8859-1", "×"), 1, 0,'C');
	}else{
		$pdf->Cell(2.5, 3, '', 1, 0,'C');
	}

	$pdf->Cell(15, 5, '',0, 0);
	$pdf->Cell(15, 5, '',0, 0);

	if($certOverall == "F"){ 
		$pdf->Cell(2.5, 3, iconv("UTF-8", "ISO-8859-1", "×"), 1, 0,'C');
	}else{
		$pdf->Cell(2.5, 3, '', 1, 0,'C');
	}

	$pdf->Cell(15, 5, '',0, 1);

	$pdf->SetFont('Times','B',9);
	$pdf->Cell(41, 5, 'ADDITIONAL REMARKS: ', 0, 0);
	$pdf->SetFont('Times','',9);
	$pdf->MultiCell(149,5, $certRemarks,0,1);  

	
	$countRemarksHeight = $pdf->GetY(); 

	$pdf->Cell(41, 0.1, '', 0, 0);
	$pdf->Cell(149,0.1,'',1,1);

	$sql2 = "SELECT * FROM tbl_instructorInfo WHERE instAccred = '".$certInstructor."'";

	$result2 = $conn->query($sql2);

	if ($result2->num_rows > 0) {
	  
	  while($row2 = $result2->fetch_assoc()) {
	    $instFirstname  = strtoupper($row2["instFirstname"]);
	    $instMiddlename  = strtoupper($row2["instMiddlename"]);
	    $instLastname  = strtoupper($row2["instLastname"]);
	    $instSignature  = $row2["instSignature"];

		}
	}
	
	$currentSignatureHeight = 245.5;
	if($countRemarksHeight <= 208.80125){
		$pdf->Cell(190, 5, '', 0,1);
		$pdf->Cell(190, 5, '', 0,1);

	}else if($countRemarksHeight <= 213.80125){
		$pdf->Cell(190, 5, '', 0,1);

		$currentSignatureHeight++;
	}else{
		$currentSignatureHeight++;
	}
	
		$pdf->Image('data://text/plain;base64,'.base64_decode($instSignature),85.5,$currentSignatureHeight,40,20,'PNG');
		
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(190, 4, 'THIS DRIVING COURSE COMPLETION CERTIFICATE WITH CONTROL NUMBER', 0,1,'C');date_default_timezone_set("Asia/Manila");
	
	$pdf->Cell(190, 4, 'MAJESTY-'.date('Y', strtotime($certDate)).'-'.substr(str_repeat(0, 10).$id, - 10).' HAS BEEN ISSUED ON '.strtoupper(date('F d, Y', strtotime($certDate))), 0,1,'C'); 
	$pdf->Cell(190, 5, '', 0,1);
	$pdf->Cell(190, 5, 'PREPARED AND ISSUED BY:', 0,1,'C');
	$pdf->SetFont('Times','B',13);
	$pdf->Cell(190, 5, 'MAJESTY DRIVING SCHOOL', 0,1,'C');
	$pdf->Cell(190, 5, 'DS-2020-00121-13', 0,1,'C');
	$pdf->Cell(60, 15, '', 0,0);
	$pdf->Cell(70, 15, '', 0,0);
	$pdf->Cell(60, 15, '', 0,1);
	$pdf->Cell(60, 0.1, '', 0,0);
	$pdf->Cell(70, 0.1, '', 1,0);
	$pdf->Cell(60, 0.1, '', 0,1);
	$pdf->Cell(190, 5, $instLastname.', '.$instFirstname.' '.$instMiddlename, 0,1,'C');
	$pdf->SetFont('Times','B',9);
	$pdf->Cell(190, 4, 'AUTORIZED INSTRUCTOR', 0,1,'C');
	$pdf->Cell(190, 4, 'ACCRED NUMBER: '.$certInstructor, 0,1,'C');

	$pdf->SetFont('Times','',9);
	$pdf->Cell(190, 2, '', 0,1,);
	$pdf->Cell(190, 2, '* This Certificate was authenticated on '.date('F d, Y', strtotime($certDate)).' at '.date('h:i:s A', strtotime($certDate)), 0,1,);
		

		$pdf->Output();
	}else{
		header("location:dashboard.php");
	}

	function urlDecoding(){
	 $url= $_SERVER['REQUEST_URI'];  

     $pieces = explode("?", $url);
     if(isset($pieces[1])) {

	 $sample = base64_decode( urldecode( $pieces[1] ));

     $new = explode("id=", $sample);
	 $and = explode("&", $new[1]);
	 $new2 = explode("print=", $sample);

	     if(isset($new2[1])){
			 return $and[0].'+'.$new2[1];
	     }else{
	     	return $new[1];
	     }
	 }else{
	 	return 0; 
	 }
	
	}

	function writeLogs($action) {

	    require('connection.php');

	    if($_SESSION["account"] == "Admin" || $_SESSION["account"] == "Super-Admin"){
	        $accountID = $_SESSION["account"]."-".substr(str_repeat(0, 3).$_SESSION['acctID'], - 3);
	    }else{
	        $accountID = $_SESSION["username"];
	    }

	    date_default_timezone_set("Asia/Manila");
	    $date = date("m/d/Y");
	    $time = date("H:i:s a");

	    $sqlx = "INSERT INTO tbl_activitylogs(actAccountID,actActions,actDate,actTime) VALUES ('$accountID','$action','$date','$time')";

	    $resultx = mysqli_query($conn, $sqlx);

	}
	
 ?>