<?php
session_start();

require_once('connection.php');

//Login
if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = md5(mysqli_real_escape_string($conn, $_POST["password"]));

    $sql = "SELECT * FROM tbl_instructorInfo WHERE instEmail = '".$username."' AND instPassword='".$password."'";

    $result = mysqli_query($conn, $sql);

    $num_row = mysqli_num_rows($result);
    if($num_row > 0){
      $data = mysqli_fetch_array($result);

      $status = $data['instStatus'];

      if($status == "Active"){
        $defaultpass = "492934e888a749f772b6b70988d2c1c8";

        $changepass = $data['instPassword'];

        if($defaultpass == $changepass){
            echo 'CP';
        }else{
            echo 'OK';
        }

        $_SESSION['username'] = $data['instAccred'];
        $_SESSION['account'] = $data['instAccountType'];
        $_SESSION['acctID'] = $data['instID'];

        writeLogs("Log in successful");

      }else if($status == "Deactivate"){
        echo 'CA';
      }else{
        echo $conn->error;
      }
    }

  }

//change password
if(isset($_POST["accountID"]) && isset($_POST["oldPass"]) && isset($_POST["newPass"])){
    
    $id = $_POST['accountID'];
    $oldPass = md5(mysqli_real_escape_string($conn, $_POST["oldPass"]));
    $newPass = md5(mysqli_real_escape_string($conn, $_POST["newPass"]));

    $sql = "SELECT * FROM tbl_instructorInfo WHERE instPassword='".$oldPass."' AND instID='".$id."' ";

    $result = mysqli_query($conn, $sql);

    $num_row = mysqli_num_rows($result);
    if($num_row > 0){

        $sql2 = "UPDATE tbl_instructorInfo SET instPassword = '$newPass' WHERE instID = '$id'";
    
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';

            writeLogs("Password has been changed");
        }else{
            echo $conn->error;
        }
    }else{
      echo '2';
    }
}

//Add Student Driver Information
if(isset($_POST["primeeee"]) && isset($_POST["inputFirstname"]) && isset($_POST["inputMiddlename"]) && isset($_POST["inputLastname"]) && isset($_POST["inputAddress"]) && isset($_POST["inputNationality"]) && isset($_POST["inputDOB"]) && isset($_POST["inputGender"]) && isset($_POST["inputStatus"])){
	   
    $primeeee = $_POST['primeeee'];
	$instructor = $_SESSION['username'];
	$Firstname = $_POST['inputFirstname'];
    $Middlename = $_POST['inputMiddlename'];
    $Lastname = $_POST['inputLastname'];
    $DOB = $_POST['inputDOB'];

    $Address = $_POST['inputAddress'];
    $Nationality = $_POST['inputNationality'];
    $Gender = $_POST['inputGender'];
    $Status = $_POST['inputStatus'];
    
    $Active = "Active";

    $sql = "SELECT studID FROM tbl_studentInfo WHERE studID = '".$primeeee."'";

    $result = mysqli_query($conn, $sql);

    $num_row = mysqli_num_rows($result);

    if($num_row > 0){

        $sql3 = "UPDATE tbl_studentInfo SET studFirstname = '$Firstname', studMiddlename='$Middlename', studLastname='$Lastname', studAddress='$Address', studDOB='$DOB', studNationality='$Nationality', studGender='$Gender', studMaritalStatus='$Status', studStatus= '$Active', studInstructorID= '$instructor', studCount='1' WHERE studID = '$primeeee'";

        $result3 = mysqli_query($conn, $sql3);

        if($result3){
            echo '1,'.$primeeee;
            
            writeLogs("Student updated - ".$primeeee);
        }else{
            echo $conn->error;
        }

    }else{    
        $sql2 = "INSERT INTO tbl_studentinfo(studFirstname,studMiddlename,studLastname,studAddress,studDOB,studNationality,studGender,studMaritalStatus,studStatus,studInstructorID,studCount) VALUES ('$Firstname','$Middlename','$Lastname','$Address','$DOB','$Nationality','$Gender','$Status','$Active','$instructor','1')";
    	
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            $last_id = $conn->insert_id;
            echo '1,'.$last_id;
            
            writeLogs("Student added - ".$last_id);
        }else{
        	echo $conn->error;
        }
    }
      
}

//duplicate entry
if(isset($_POST["inputDuplicate"])){

    $dupID = $_POST['inputDuplicate'];

    $sql = "SELECT * FROM tbl_studentinfo WHERE studID = '$dupID'";

    $result = mysqli_query($conn, $sql);  
    $instructor = $_SESSION['username'];

    if(mysqli_num_rows($result) > 0){
        $data = mysqli_fetch_array($result);
        $fname = $data['studFirstname'];
        $mname = $data['studMiddlename'];
        $lname = $data['studLastname'];
        $address = $data['studAddress'];
        $dob = $data['studDOB'];
        $national = $data['studNationality'];
        $gender = $data['studGender'];
        $marital = $data['studMaritalStatus'];
        
        $count = $data['studCount'];

        $sql2 = "SELECT trainStudentID,trainDLNo FROM tbl_trainingInfo WHERE trainStudentID = $dupID";

        $result2 = $conn->query($sql2);

        $num_row = mysqli_num_rows($result2);
        if($num_row > 0){
            $data2 = mysqli_fetch_array($result2);

          $certDLNo  = $data2['trainDLNo'];
        }else{
          $certDLNo  = null;
        }

        $sql2 = "INSERT INTO tbl_studentinfo (studFirstname,studMiddlename,studLastname,studAddress,studDOB,studNationality,studGender,studMaritalStatus,studStatus,studInstructorID,studCount) VALUES ('$fname','$mname','$lname','$address','$dob','$national','$gender','$marital','Active','$instructor','1')";

        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo $last_id = $conn->insert_id."^".$certDLNo;
            writeLogs("Student added - ".$last_id);
        }else{
            echo $conn->error;
        }

    }else{
        echo $conn->error;
    }
}

//Training Info
$primaryKey = ""; 
if(isset($_POST["primeeee"]) && isset($_POST["inputCourseName"]) && isset($_POST["inputDriversLicenseNo"]) && isset($_POST["inputProgramType"]) && isset($_POST["inputTrainingPurpose"]) && isset($_POST["inputMV2"]) && isset($_POST["inputDL2"]) && isset($_POST["inputDateStarted"])  && isset($_POST["inputDateCompleted"]) && isset($_POST["inputHours"])){

	$instructor = $_SESSION['username'];
    $primeeee = $_POST['primeeee'];

    $Course = $_POST['inputCourseName'];
    $Program = $_POST['inputProgramType'];
    $DriversLicenseNo = $_POST['inputDriversLicenseNo'];
    $Training = $_POST['inputTrainingPurpose'];
    $MV = $_POST['inputMV2']; 
    $DL = $_POST['inputDL2'];
    $DateStarted = $_POST['inputDateStarted'];
    $DateCompleted = $_POST['inputDateCompleted'];
    $Hours = $_POST['inputHours']; 
    

    $sql = "SELECT * FROM tbl_traininginfo WHERE trainStudentID = '".$primeeee."' AND trainActive = 'Active'";

    $result = mysqli_query($conn, $sql);

    $num_row = mysqli_num_rows($result);

    if($num_row > 0){

      $sql3 = "UPDATE tbl_traininginfo SET trainCourse = '$Course', trainProgram='$Program', trainDLNo='$DriversLicenseNo', trainPurpose='$Training', trainMV='$MV', trainDL='$DL', trainStarted='$DateStarted', trainCompleted='$DateCompleted', trainHours= '$Hours', trainActive= 'Active', trainInstructorID='$instructor', trainCount='2' WHERE trainStudentID = '$primeeee'";

        $result3 = mysqli_query($conn, $sql3);

        if($result3){
            echo '1,'.$primeeee;
            writeLogs("Continuing updating - ".$primeeee);
        }else{
            echo $conn->error;
        }
    
    }else{
        $sql2 = "INSERT INTO tbl_traininginfo(trainCourse,trainProgram,trainDLNo,trainPurpose,trainMV,trainDL,trainStarted,trainCompleted,trainHours,trainActive,trainInstructorID,trainStudentID,trainCount) VALUES ('$Course','$Program','$DriversLicenseNo','$Training','$MV','$DL','$DateStarted','$DateCompleted','$Hours','Active','$instructor','$primeeee','2')";

        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1,'.$primeeee;
            writeLogs("Continuing encoding - ".$primeeee);
        }else{
            echo $conn->error;
        }
    }
}

//Training Info 2
if(isset($_POST["inputPrimaryKey"]) && isset($_POST["inputAssessment"]) && isset($_POST["inputOverallRating"]) && isset($_POST["inputRemarks"]) && isset($_POST["inputBranchX"])){

	$Assessment = $_POST['inputAssessment'];
    $OverallRating = $_POST['inputOverallRating'];
    $Remarks = $_POST['inputRemarks']; 
    $Branch = $_POST['inputBranchX'];
    $PrimaryKey = $_POST['inputPrimaryKey'];

    $sql = "UPDATE tbl_traininginfo SET trainAssessment = '$Assessment', trainOverall = '$OverallRating', trainRemarks = '$Remarks' , trainBranch = '$Branch', trainCount = '3' WHERE trainStudentID = '$PrimaryKey'";
	
    $result = mysqli_query($conn, $sql);

    if($result){
    	echo '1,'.$PrimaryKey;
        writeLogs("Continuing encoding - ".$PrimaryKey);
    }else{
    	echo $conn->error;
    }
}

//Check Student for Camera Capturing
if(isset($_POST["inputFirstname2"]) && isset($_POST["inputMiddlename2"]) && isset($_POST["inputLastname2"]) && isset($_POST["inputDOB2"])){

    $Firstname = $_POST['inputFirstname2'];
    $Middlename = $_POST['inputMiddlename2'];
    $Lastname = $_POST['inputLastname2'];
    $DOB = $_POST['inputDOB2'];

    $sql = "SELECT * FROM tbl_studentInfo WHERE studFirstname = '".$Firstname."' AND studMiddlename='".$Middlename."' AND studLastname='".$Lastname."' AND studDOB='".$DOB."' AND studStatus = 'Active'";

    $result = mysqli_query($conn, $sql);

    $num_row = mysqli_num_rows($result);

    if($num_row > 0){
      $data = mysqli_fetch_array($result);
      $primaryKey = $data['studID'];
      echo $primaryKey;
    }else{
      echo 'No Student Found!!';
    }
}

//Insert Capture
if(isset($_POST["inputCamera"]) && isset($_POST["primary"])){
    $Capture = $_POST['inputCamera'];
    $idid = $_SESSION['username'];
    $image_parts = explode(";base64,", $Capture);    
    $image_base64 = base64_encode($image_parts[1]);

    $student = $_POST['primary'];

    date_default_timezone_set("Asia/Manila");
    $date = date("m/d/Y H:i:s");

    $sql = "UPDATE tbl_studentinfo SET studCapture = '$image_base64', studCount = '4', studStatus = 'Certified', studDateCertified = '$date', studInstructorID='$idid' WHERE studID='$student'";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo '1';
        writeLogs("Done encoding - ".$student);
        writeLogs("Printing certificate - ".$student);
    }else{
        echo $conn->error;
    }

}


//Admin Account
if(isset($_POST["inputAccountType2"]) && isset($_POST["inputInstructorFirstname2"]) && isset($_POST["inputInstructorMiddlename2"]) && isset($_POST["inputInstructorLastname2"])  && isset($_POST["inputInstructorEmail2"])){

    $inputAccountType2 = $_POST["inputAccountType2"];
    $inputInstructorFirstname2 = $_POST["inputInstructorFirstname2"];
    $inputInstructorMiddlename2 = $_POST["inputInstructorMiddlename2"];
    $inputInstructorLastname2 = $_POST["inputInstructorLastname2"];
    $inputInstructorEmail2 = $_POST["inputInstructorEmail2"];

    $inputInstructorpassword2 = "492934e888a749f772b6b70988d2c1c8";

    $sql = "SELECT * FROM tbl_instructorInfo WHERE instFirstname = '".$inputInstructorFirstname2."' AND instMiddlename='".$inputInstructorMiddlename2."' AND instLastname='".$inputInstructorLastname2."' AND instEmail='".$inputInstructorEmail2."'";

    $result = mysqli_query($conn, $sql);

    $num_row = mysqli_num_rows($result);

    if($num_row > 0){
        $data = mysqli_fetch_array($result);
        $data1 = $data['instEmail'];
        $data2 = $data['instFirstname'];
        $data3 = $data['instMiddlename'];
        $data4 = $data['instLastname'];
        echo $data1.",".$data2.",".$data3.",".$data4;
    }else{
        $sql2 = "INSERT INTO tbl_instructorInfo(instFirstname,instMiddlename,instLastname,instPassword,instEmail,instAccountType,instStatus) VALUES ('$inputInstructorFirstname2','$inputInstructorMiddlename2','$inputInstructorLastname2','$inputInstructorpassword2','$inputInstructorEmail2','$inputAccountType2','Active')";
        
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';
            $last_id = $conn->insert_id;
            writeLogs($inputAccountType2." added - ".substr(str_repeat(0, 3).$last_id, - 3));
        }else{
            echo $conn->error;
        }
    }


}

//Instructor Account
if(isset($_POST["inputAccountType"]) && isset($_POST["inputInstructorID"]) && isset($_POST["inputInstructorFirstname"]) && isset($_POST["inputInstructorMiddlename"]) && isset($_POST["inputInstructorLastname"]) && isset($_POST["inputInstructorEmail"]) && isset($_POST["inputInstructorSignatureBase64"])){

    $inputAccountType = $_POST["inputAccountType"];
    $inputInstructorID = $_POST["inputInstructorID"];
    $inputInstructorFirstname = $_POST["inputInstructorFirstname"];
    $inputInstructorMiddlename = $_POST["inputInstructorMiddlename"];
    $inputInstructorLastname = $_POST["inputInstructorLastname"];
    $inputInstructorEmail = $_POST["inputInstructorEmail"];
    $inputInstructorSignature = $_POST["inputInstructorSignatureBase64"];
    $image_parts = explode(";base64,", $inputInstructorSignature);    
    $image_base64 = base64_encode($image_parts[1]);
    
    $inputInstructorpassword = "492934e888a749f772b6b70988d2c1c8";

    $sql = "SELECT * FROM tbl_instructorInfo WHERE instFirstname = '".$inputInstructorFirstname."' AND instMiddlename='".$inputInstructorMiddlename."' AND instLastname='".$inputInstructorLastname."' AND instAccred='".$inputInstructorID."'";

    $result = mysqli_query($conn, $sql);

    $num_row = mysqli_num_rows($result);

    if($num_row > 0){
        $data = mysqli_fetch_array($result);
        $data1 = $data['instAccred'];
        $data2 = $data['instFirstname'];
        $data3 = $data['instMiddlename'];
        $data4 = $data['instLastname'];
        echo $data1.",".$data2.",".$data3.",".$data4;
    }else{
        $sql2 = "INSERT INTO tbl_instructorInfo(instAccred,instFirstname,instMiddlename,instLastname,instPassword,instEmail,instAccountType,instStatus,instSignature) VALUES ('$inputInstructorID','$inputInstructorFirstname','$inputInstructorMiddlename','$inputInstructorLastname','$inputInstructorpassword','$inputInstructorEmail','$inputAccountType','Active','$image_base64')";
        
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';

            writeLogs("Instructor added - ".$inputInstructorID);
        }else{
            echo $conn->error;
        }
    }
}


//account status updater
if(isset($_POST["tblID"]) && isset($_POST["tblAction"]) && isset($_POST["tblAccredd"])){

    $tblID = $_POST["tblID"];
    $tblAccredd = $_POST["tblAccredd"];
    $tblAction = $_POST["tblAction"];

    $sql = "UPDATE tbl_instructorInfo SET instStatus='$tblAction' WHERE instID='$tblID'";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo '1';

        $newAcredd = explode("-", $tblAccredd); 
        if($newAcredd[0] == "Admin"){ 
            writeLogs("Admin-".substr(str_repeat(0, 3).$tblID, - 3)." - status update (".$tblAction.")");
        }else if(isset($newAcredd[1]) && $newAcredd[1] == "Admin"){ //is_numeric($tblAccredd)
            writeLogs("Super-Admin-".substr(str_repeat(0, 3).$tblID, - 3)." - status update (".$tblAction.")");
        }else{
            writeLogs($tblAccredd." - status updated (".$tblAction.")");
        }
    }else{
        echo $conn->error;
    }
}

//account signature updater
if(isset($_POST["tblID2x"]) && isset($_POST["tblSignature"]) && isset($_POST["tblAccreddx"])){

    $tblID = $_POST["tblID2x"];
    $tblSignature = $_POST["tblSignature"];
    $tblAccredd = $_POST["tblAccreddx"];

    $image_parts = explode(";base64,", $tblSignature);    
    $image_base64 = base64_encode($image_parts[1]);

    $sql = "UPDATE tbl_instructorInfo SET instSignature='$image_base64' WHERE instID='$tblID'";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo '1';

        writeLogs($tblAccredd." - signature updated");

    }else{
        echo $conn->error;
    }
}

//account signature updater
if(isset($_POST["tblID2y"]) && isset($_POST["tblAccountType2"]) && isset($_POST["tblAccreddy"])){

    $tblID = $_POST["tblID2y"];
    $tblAccountType = $_POST["tblAccountType2"];
    $tblAccredd = $_POST["tblAccreddy"];

    $sql = "UPDATE tbl_instructorInfo SET instAccountType='$tblAccountType' WHERE instID='$tblID'";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo '1';

        writeLogs($tblAccredd." - account type updated (".$tblAccountType.")");

    }else{
        echo $conn->error;
    }
}

//reset password
if(isset($_POST["tblID2"]) && isset($_POST["tblAccredd"])){

    $tblID2 = $_POST["tblID2"];
    $tblAccredd = $_POST["tblAccredd"];

    $inputInstructorpassword = "492934e888a749f772b6b70988d2c1c8";

    $sql = "UPDATE tbl_instructorInfo SET instPassword='$inputInstructorpassword' WHERE instID='$tblID2'";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo '1';

        writeLogs($tblAccredd." - Password has been reset");
    }else{
        echo $conn->error;
    }
}

//change image
if(isset($_POST["picture"]) && isset($_POST["accountID"])){

    $ID = $_POST["accountID"];
    $picture = $_POST["picture"];
    $image_parts = explode(";base64,", $picture);    
    $image_base64 = base64_encode($image_parts[1]);
    
    $sql = "UPDATE tbl_instructorInfo SET instPicture='$image_base64' WHERE instID='$ID'";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo '1';
        writeLogs("Image has been updated");
    }else{
        echo $conn->error;
    }
}

//view account
if(isset($_POST["id"]) && isset($_POST["action"])){

    $ID = $_POST["id"];
    $action = $_POST["action"];
    
    $try = explode("-", $ID);

    $sql2="";

    if(isset($try[0]) && isset($try[1]) && isset($try[2]) && isset($try[3])){
        //Instructor

        $sql2 = "SELECT * FROM tbl_instructorInfo WHERE instAccred = '".$ID."'";

    }else if(isset($try[0]) && isset($try[1]) && isset($try[2])){
        //Super-Admin

        $int = (int)$try[2];
        $sql2 = "SELECT * FROM tbl_instructorInfo WHERE instID = '".$int."'";

    }else if(isset($try[0]) && isset($try[1])){
        //Admin

        $int = (int)$try[1];
        $sql2 = "SELECT * FROM tbl_instructorInfo WHERE instID = '".$int."'";
    }

    $result2 = mysqli_query($conn, $sql2);
    $row2 = mysqli_fetch_assoc($result2);

    if($result2){
        if(isset($row2)){
            $lastname = $row2['instLastname'];
            $middle = $row2['instMiddlename'];
            $first = $row2['instFirstname'];
            $email = $row2['instEmail'];
        }else{
            $lastname = "UNAVAILABLE";
            $middle = "THIS ACCOUNT";
            $first = " TO IDENTIFY ";
            $email = "PLEASE CONTACT THE ADMINISTRATOR";
        }

        echo $lastname.','.$first.','.$middle.','.$email;
    }else{
        echo $conn->error;
    }
}

//add DL Codes
if(isset($_POST["inputDLCodeID"]) && isset($_POST["inputDLCodeDesc"]) && isset($_POST["inputSubDLCodeID"]) && isset($_POST["inputSubDLCodeDesc"]) && isset($_POST["inputTransmissionType"]) && isset($_POST["inputLicenceType"])){

    $inputDLCodeID = $_POST["inputDLCodeID"];
    $inputDLCodeDesc = $_POST["inputDLCodeDesc"];
    $inputSubDLCodeID = $_POST["inputSubDLCodeID"];
    $inputSubDLCodeDesc = $_POST["inputSubDLCodeDesc"];
    $inputTransmissionType = $_POST["inputTransmissionType"];
    $inputLicenceType = $_POST["inputLicenceType"];

        $sql = "INSERT INTO tbl_dlCodes(dlCodeName,dlCodeDesc,dlCodeSubName,dlCodeSubDesc,dlCodeType,dlCodeTransmission,dlCodeStatus) VALUES ('$inputDLCodeID','$inputDLCodeDesc','$inputSubDLCodeID','$inputSubDLCodeDesc','$inputLicenceType','$inputTransmissionType','Active')";
        
        $result = mysqli_query($conn, $sql);

    if($result){
        echo '1';

        writeLogs("DL Codes added - ".$inputDLCodeID.'-'.$inputSubDLCodeID.' '.$inputLicenceType.' '.$inputTransmissionType);
    }else{
        echo $conn->error;
    }
}


//selecting Sub-DL
if(isset($_POST["inputDLCodeID2"]) && isset($_POST["inputDLCodeDesc2"])){

    $inputDLCodeID2 = $_POST["inputDLCodeID2"];
    $inputDLCodeDesc2 = $_POST["inputDLCodeDesc2"];

    echo $inputDLCodeID2.' '.$inputDLCodeDesc2;
}

//add Branches
if(isset($_POST["inputBranch"])){
    $inputBranch = $_POST["inputBranch"];

    $sql = "INSERT INTO tbl_branches(branchName,branchStatus) VALUES ('$inputBranch','Active')";

    $result = mysqli_query($conn, $sql);
    if($result){
        echo '1';
        $last_id = $conn->insert_id;
        writeLogs("Branches added - ".$last_id);
    }else{
        echo $conn->error;
    }

}

//contact us
if(isset($_POST["contactUS"])){    
    if($_POST['name'] != "" && $_POST['number'] != "" && $_POST['email'] != "" && $_POST['subject'] != "" && $_POST['message'] != ""){
        $name = $_POST['name'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];

        $sql = "INSERT INTO tbl_contactus(contactName,contactNumber,contactEmail,contactSubject,contactMessage,contactStatus) VALUES ('$name','$number','$email','$subject','$message','Active')";

        $result = mysqli_query($conn, $sql);

        if($result){
            echo '<script>alert("Message Send");window.location.href="index.php";</script>';
        }else{
            echo '<script>alert("Unable to Send");window.location.href="index.php";</script>';
        }

    }else{
        echo '<script>alert("Fill all the fields");window.location.href="index.php";</script>';
    }
    
}

//contact us solved
if(isset($_POST["contactID"])){    
    $id = $_POST["contactID"];

    $sql2 = "UPDATE tbl_contactus SET contactStatus = 'Solved' WHERE contactID = '$id'";
    
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';

            writeLogs("Contact us ".$id." has been solved");
        }else{
            echo $conn->error;
        }

}

//branch Deactivate
if(isset($_POST["branchID"])){    
    $id = $_POST["branchID"];

    $sql2 = "UPDATE tbl_branches SET branchStatus = 'Deactivate' WHERE branchID = '$id'";
    
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';

            writeLogs("Branch ".$id." deactivated");
        }else{
            echo $conn->error;
        }

}

//branch Active
if(isset($_POST["branchIDx"]) && isset($_POST["branchStatus"])){   

    $id = $_POST["branchIDx"];

    $sql2 = "UPDATE tbl_branches SET branchStatus = 'Active' WHERE branchID = '$id'";
    
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';

            writeLogs("Branch ".$id." activated");
        }else{
            echo $conn->error;
        }

}

if(isset($_POST["dlcodeID"])){    
    $id = $_POST["dlcodeID"];

    $sql2 = "UPDATE tbl_dlCodes SET dlCodeStatus = 'Deactivate' WHERE dlcodeID = '$id'";
    
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';

            writeLogs("DL Code ".$id." deactivated");
        }else{
            echo $conn->error;
        }

}

//branch Active
if(isset($_POST["dlcodeIDx"]) && isset($_POST["dlCodeStatus"])){   
    $id = $_POST["dlcodeIDx"];
    
    $sql2 = "UPDATE tbl_dlCodes SET dlCodeStatus = 'Active' WHERE dlcodeID = '$id'";
    
        $result2 = mysqli_query($conn, $sql2);

        if($result2){
            echo '1';

            writeLogs("DL Code ".$id." activated");
        }else{
            echo $conn->error;
        }

}

function age($birthday){
     list($month, $day, $year) = explode("/", $birthday);
     $year_diff  = date("Y") - $year;
     $month_diff = date("m") - $month;
     $day_diff   = date("d") - $day;
     if ($day_diff < 0 && $month_diff==0) $year_diff--;
     if ($day_diff < 0 && $month_diff < 0) $year_diff--;
     return $year_diff;
    }

//generate excel file
if(isset($_POST["export"]) && isset($_POST["date"])){
    $date = $_POST["date"]; 

    $newDate = explode("-", $date);

    $sqlDate = $newDate[1].'/'.$newDate[2].'/'.$newDate[0];

    $sql = "SELECT * FROM tbl_studentInfo INNER JOIN tbl_trainingInfo ON studID = trainStudentID WHERE studDateCertified LIKE '$sqlDate%'";

    $result = mysqli_query($conn, $sql);
    $output="";
    if(mysqli_num_rows($result) > 0){

        writeLogs("Printing student report - ".$sqlDate);

        $output .= "<table class='table' border='1'>
                        <tr>
                            <td>Control Number</td>
                            <td>Firstname</td>
                            <td>Middlename</td>
                            <td>Lastname</td>
                            <td>Address</td>
                            <td>Date of Birth</td>
                            <td>Age</td>
                            <td>Nationality</td>
                            <td>Gender</td>
                            <td>Marital Status</td>

                            <td>Training Course</td>
                            <td>Program</td>
                            <td>Drivers Licence No.</td>
                            <td>Purpose</td>
                            <td>MV Used</td>
                            <td>DL Codes</td>
                            <td>Date Started</td>
                            <td>Date Completed</td>
                            <td>Total Hours</td>

                            <td>Assessment</td>
                            <td>Overall</td>
                            <td>Remarks</td>

                            <td>Certified Date</td>
                            <td>Instructor ID</td>
                        </tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            $id  = $row["studID"];
            $certFirstname  = strtoupper($row["studFirstname"]);
            $certMiddlename  = strtoupper($row["studMiddlename"]);
            $certLastname  = strtoupper($row["studLastname"]);
            $certAddress  = strtoupper($row["studAddress"]);
            //$certDLNo  = $row["studDLNo"];
            $certDOB  = $row["studDOB"];
            $certNationality  = $row["studNationality"];
            $certGender  = $row["studGender"];
            $certMaritalStatus  = $row["studMaritalStatus"];

            $certInstructor = $row["studInstructorID"];
            $certDate = $row["studDateCertified"];

            $certCourse  = $row["trainCourse"];
            $certProgram  = $row["trainProgram"];
            $certDLNo  = $row["trainDLNo"];
            $certPurpose  = $row["trainPurpose"];
            $certMV  = $row["trainMV"];
            $certDL  = $row["trainDL"];
            $certStarted  = $row["trainStarted"];
            $certCompleted  = $row["trainCompleted"];
            $certHours  = $row["trainHours"];

            $certAssessment  = $row["trainAssessment"];
            $certOverall  = $row["trainOverall"];
            $certRemarks  = strtoupper($row["trainRemarks"]);
            
            $DL1 = str_replace("[","",$certDL);
            $DL2 = str_replace("]","",$DL1);
            $DL3 = explode(",", $DL2);

            $DLcount = count($DL3);
            sort($DL3);
            $strDLCode ="";
                for ($c=1; $c < $DLcount; $c++) { 
                    $dlcodes = explode("/", $DL3[$c]);

                    $strDLCode .= $dlcodes[0].'-'.$dlcodes[1]."<br>";
                   
                }

        $output .= "<tr>
                        <td>MAJESTY-".date('Y', strtotime($certDate)).'-'.substr(str_repeat(0, 10).$id, - 10)."</td>
                        <td>".$certFirstname."</td>
                        <td>".$certMiddlename."</td>
                        <td>".$certLastname."</td>
                        <td>".$certAddress."</td>";

                        
                        $newDateX = date("m/d/Y", strtotime($certDOB));
        $output .= "    <td>".$newDateX."</td>";
                            
        $output .= " <td>".age($newDateX)."</td>
                        <td>".strtoupper($certNationality)."</td>";

                        if($certGender == "M"){
                            $newGender = "MALE";
                        }else if($certGender == "F"){
                            $newGender = "FEMALE";
                        }
        $output .= "    <td>".$newGender."</td>";

                        if($certMaritalStatus == "S"){
                            $newMS = "SINGLE";
                        }else if($certGender == "M"){
                            $newMS = "MARRIED";
                        }else if($certGender == "D"){
                            $newMS = "DIVORCED";
                        }else if($certGender == "W"){
                            $newMS = "WIDOWED";
                        }
                        
        $output .= "    <td>".$newMS."</td>";

                        if($certCourse == "TDC"){
                            $newCourse = "THEORETICAL DRIVING COURSE";
                        }else if($certCourse == "PDC"){
                            $newCourse = "PRACTICAL DRIVING COURSE";
                        }

        $output .= "    <td>".$newCourse."</td>";

                        if($certProgram == "TIT"){
                            $newProgram = "THEORETICAL INSTRUCTION TRAINING";
                        }else if($certProgram == "PDIT"){
                            $newProgram = "PRACTICAL DRIVING INSTRUCTION TRAINING";
                        }


        $output .= "    <td>".$newProgram."</td>";

                        if($certPurpose == "SP"){
                            $newPurpose = "STUDENT PERMIT";
                        }else if($certPurpose == "NEW"){
                            $newPurpose = "NEW DRIVER'S LICENCE"; 
                        }else if($certPurpose == "ADD"){
                            $newPurpose = "ADDING RESTRICTION CODE";
                        }else if($certPurpose == "SEM"){
                            $newPurpose = "SEMINAR";
                        }

        $output .= "    <td>".$certDLNo."</td>
                        <td>".$newPurpose."</td>

                        <td></td> 
                        <td>".$strDLCode."</td>";

        $output .= "    <td>".date("m/d/Y", strtotime($certStarted))."</td>";

                        

        $output .= "    <td>".date("m/d/Y", strtotime($certCompleted))."</td>
                        <td>".$certHours."</td>";


                        if($certAssessment== "P"){
                            $newAssessment = "PASSED";
                        }else if($certAssessment == "F"){
                            $newAssessment = "FAILED";
                        }

                        $strDLCode="";

        $output .= "    <td>".$newAssessment."</td>";

                        if($certOverall == "P"){
                            $newOverall = "PASSED";
                        }else if($certOverall == "F"){
                            $newOverall = "FAILED";
                        }

        $output .= "    <td>".$newOverall."</td>


                        <td>".$certRemarks."</td>
                        <td>".date('F d, Y', strtotime($certDate)).' at '.date('h:i:s A', strtotime($certDate))."</td>
                        <td>".$certInstructor."</td>
                    </tr>";
        
        }
        $output .= "</table>";

        header('Content-Type: application/xls');
        header('Content-Disposition: attachment; filename='.$sqlDate.' - Report.xls');

        echo $output;
        

    }else{
        echo '<script>alert("No Result");window.location.href="student-list.php";</script>';
        
    }
}

//writing Logs
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


$conn->close();
?>