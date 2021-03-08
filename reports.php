<?php 
	session_start();
	require ('fpdf17/fpdf.php');
	require_once('connection.php');

	class PDF extends FPDF
	{
		// Page footer
		function Footer()
		{
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Arial italic 8
		    $this->SetFont('Arial','I',8);
		    // Page number
		    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'R');
		}
	}


	$pdf = new PDF('P','mm','A4');

	$pdf->SetTitle('Majesty Driving School');

	$pdf->AddPage();
	$pdf->AliasNbPages();

	$type = urlDecoding();

	if(isset($type) && ($_SESSION["account"] == "Admin" || $_SESSION["account"] == "Super-Admin")){

	$pdf->SetFont('Times');

	$pdf->Image('majesty-images/LTO.png',50,15,20,'PNG');
	$pdf->Image('majesty-images/majesty-logo.png',70,10,80,'PNG');
	$pdf->Image('majesty-images/DOTR.png',150,15,20,'PNG');
	$pdf->Cell(190, 30, '', 0,1);

	
	$pdf->SetFontSize(9);

	$pdf->Cell(190, 4, 'DEPARTMENT OF TRANSPORTATION', 0, 1,'C');
	$pdf->Cell(190, 4, 'LAND TRANSPORTATION OFFICE', 0, 1,'C');

	$pdf->SetFont('Times','B',15);


	if($type == 1){

		writeLogs("Printing list of branch active");

		$pdf->Cell(190, 10, 'LIST OF BRANCHES', 0, 1,'C');

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(10,5,'#',1,0,'C');$pdf->Cell(160,5,'BRANCH NAME',1,0,'C');$pdf->Cell(20,5,'STATUS',1,1,'C');

		$pdf->SetFont('Arial','',9);

		$sql = "SELECT * FROM tbl_branches";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  
		  $no=0; 
		  while($row = $result->fetch_assoc()) {
		    $certBranchName  = $row["branchName"];
		    $certBranchStatus  = $row["branchStatus"];
		    $no++;
		    
		    $pdf->Cell(10,5,$no,1,0,'C');$pdf->Cell(160,5,$certBranchName,1,0);$pdf->Cell(20,5,$certBranchStatus,1,1,'C');

			}
		}
	}else if($type == 2){

		writeLogs("Printing list of student certified");

		$pdf->Cell(190, 10, 'LIST OF STUDENT CERTIFIED', 0, 1,'C');

		$pdf->SetFont('Arial','B',9); 
		$pdf->Cell(10,5,'#',1,0,'C');$pdf->Cell(107.5,5,'FULL NAME',1,0,'C');$pdf->Cell(38.75,5,'DATE CERTIFIED',1,0,'C');$pdf->Cell(33.75,5,'INSTRUCTOR',1,1,'C');

		$pdf->SetFont('Arial','',9);

		$sql = "SELECT * FROM tbl_studentInfo WHERE studStatus = 'Certified' ORDER BY studDateCertified,studLastname,studFirstname,studMiddlename ASC";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  
		  $no=0;
		  while($row = $result->fetch_assoc()) {
		    $certFirstname  = $row["studFirstname"];
		    $certMiddlename  = $row["studMiddlename"];
		    $certLastname  = $row["studLastname"];
		    $certInstructor  = $row["studInstructorID"];
		    $certDateCertified  = $row["studDateCertified"];
		    $no++;

		    $pdf->Cell(10,5,$no,1,0,'C');$pdf->Cell(107.5,5,$certLastname.', '.$certFirstname.' '.$certMiddlename,1,0);$pdf->Cell(38.75,5,$certDateCertified,1,0,'C');$pdf->Cell(33.75,5,$certInstructor,1,1,'C');
			}
		}
	}else if($type == 3){

		writeLogs("Printing list of insructor");

		$pdf->Cell(190, 10, 'LIST OF INSTRUCTOR', 0, 1,'C');

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(10,5,'#',1,0,'C');$pdf->Cell(33.75,5,'INSTRUCTOR ID',1,0,'C');$pdf->Cell(73.25,5,'FULL NAME',1,0,'C');$pdf->Cell(53,5,'EMAIL',1,0,'C');$pdf->Cell(20,5,'STATUS',1,1,'C');

		$pdf->SetFont('Arial','',9);

		$sql = "SELECT * FROM tbl_instructorInfo WHERE instAccountType = 'Instructor' ORDER BY instStatus,instLastname,instFirstname,instMiddlename ASC";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  
		  $no=0;
		  while($row = $result->fetch_assoc()) {
		    $certFirstname  = $row["instFirstname"];
		    $certMiddlename  = $row["instMiddlename"];
		    $certLastname  = $row["instLastname"];
		    $certInstructor  = $row["instAccred"];
		    $certEmail = $row["instEmail"];
		    $certStatus  = $row["instStatus"];
		    $no++;

		    $pdf->Cell(10,5,$no,1,0,'C');$pdf->Cell(33.75,5,$certInstructor,1,0,'C');$pdf->Cell(73.25,5,$certLastname.', '.$certFirstname.' '.$certMiddlename,1,0);$pdf->Cell(53,5,$certEmail,1,0,'C');$pdf->Cell(20,5,$certStatus,1,1,'C');
			}
		}
	}else if($type == 4){

		writeLogs("Printing list of administrator");

		$pdf->Cell(190, 10, 'LIST OF ADMINISTRATOR', 0, 1,'C');

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(10,5,'#',1,0,'C');$pdf->Cell(23.75,5,'ADMIN ID',1,0,'C');$pdf->Cell(83.25,5,'FULL NAME',1,0,'C');$pdf->Cell(53,5,'EMAIL',1,0,'C');$pdf->Cell(20,5,'STATUS',1,1,'C');

		$pdf->SetFont('Arial','',9);

		$sql = "SELECT * FROM tbl_instructorInfo WHERE instAccountType = 'Admin' ORDER BY instStatus,instLastname,instFirstname,instMiddlename ASC";

		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
		  
		  $no=0;
		  while($row = $result->fetch_assoc()) {
		    $certFirstname  = $row["instFirstname"];
		    $certMiddlename  = $row["instMiddlename"];
		    $certLastname  = $row["instLastname"];
		    $certInstructor  = "Admin - ".substr(str_repeat(0, 3).$row["instID"], - 3);

		    $certEmail = $row["instEmail"];
		    $certStatus  = $row["instStatus"];
		    $no++;

		    $pdf->Cell(10,5,$no,1,0,'C');$pdf->Cell(23.75,5,$certInstructor,1,0,'C');$pdf->Cell(83.25,5,$certLastname.', '.$certFirstname.' '.$certMiddlename,1,0);$pdf->Cell(53,5,$certEmail,1,0,'C');$pdf->Cell(20,5,$certStatus,1,1,'C');
			}
		}
	}else{
		header("location:dashboard.php");
	}
	}else{
		header("location:dashboard.php");
	}

	$pdf->Output();


	function urlDecoding(){
	 $url= $_SERVER['REQUEST_URI'];  

     $pieces = explode("?", $url);
	 $sample = base64_decode( urldecode( $pieces[1] ));

     $new = explode("type=", $sample);
		
		return $new[1];     
     
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