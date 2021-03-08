<?php 
session_start();
require_once('connection.php');
if(!isset($_SESSION["username"]) && !isset($_SESSION["account"])){
    header("location:login.php");
  }  

  if($_SESSION["account"] != "Instructor"){
    header("location:dashboard.php");
  }

  $idx = urlDecoding();
 
  $haha = explode("+", $idx);

      if(isset($haha[0]) && isset($haha[1])){

      $haha2 = explode("^", $haha[0]);
      $id = $haha2[0];
      $certDLNo = $haha2[1];

      $step = $haha[1];

      if($step == 1 || $step == 5){
        $sql = "SELECT * FROM tbl_studentInfo WHERE studID = $id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          
          while($row = $result->fetch_assoc()) {

            $certFirstname  = $row["studFirstname"];
            $certMiddlename  = $row["studMiddlename"];
            $certLastname  = $row["studLastname"];
            $certAddress  = $row["studAddress"];
            
            $certDOB  = $row["studDOB"];
            $certNationality  = $row["studNationality"];
            $certGender  = $row["studGender"];
            $certMaritalStatus  = $row["studMaritalStatus"];

            $certCapture = $row["studCapture"];

            
            $certCourse  = null;
            $certProgram  = null;
            $certPurpose  = null;
            $certMV  = null;
            $certDL  = null;
            $certStarted  = null;
            $certCompleted  = null;
            $certHours  = null;

            $certAssessment  = null;
            $certOverall  = null;
            $certRemarks  = null;

          }
        } 
      }
      
  }else{
          $id = null;
          $step = null;

          $haha2[0] = '';

          $certFirstname  = null;
          $certMiddlename  = null;
          $certLastname  = null;
          $certAddress  = null;
          $certDLNo  = null;
          $certDOB  = null;
          $certNationality  = null;
          $certGender  = null;
          $certMaritalStatus  = null;

          $certCapture  = null;

          $certCourse  = null;
          $certProgram  = null;
          $certPurpose  = null;
          $certMV  = null;
          $certDL  = null;
          $certStarted  = null;
          $certCompleted  = null;
          $certHours  = null;

          $certAssessment  = null;
          $certOverall  = null;
          $certRemarks  = null;
    }


function urlDecoding(){
     $url= $_SERVER['REQUEST_URI'];  

     $pieces = explode("?", $url);
     if(isset($pieces[1])) {

     $sample = base64_decode( urldecode( $pieces[1] ));

     $new = explode("id=", $sample);
     
        $and = explode("&", $new[1]);

        $new2 = explode("step=", $sample);

        return $and[0].'+'.$new2[1];
     }else{
        return 0; 
     }
  }
 ?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'head-tag.php' ?>
  <link href="dist2/css/smart_wizard_all.css" rel="stylesheet" type="text/css" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper"> 

  <?php
  include 'navbar.php';
  include 'sidebar.php';
  ?>

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark"><i class="nav-icon fas fa-plus"></i> Add Student</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <section class="content">
         <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <div id="smartwizard">
                  <ul class="nav">
                      <li class="nav-item">
                        <a class="nav-link" href="#step-1">
                          <strong>Step 1</strong> <br>Student Driver Information
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#step-2">
                          <strong>Step 2</strong> <br>Driving Course Training Information
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#step-3">
                          <strong>Step 3</strong> <br>Driving Course Training Evaluation
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link " href="#step-4">
                          <strong>Step 4</strong> <br>Image Setup
                        </a>
                      </li>
                  </ul>
                  <div class="tab-content">
                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                      <input type="hidden" id="steps" value="<?php echo $step; ?>">
                        <h3>Step 1: Student Driver Information</h3>
                            <div class="form-group">
                              <label for="inputFirstname">First Name</label>
                              <input type="text" maxlength="30" class="form-control" id="inputFirstname"  <?php if($certFirstname != ""){echo 'value="'.$certFirstname.'"';}else{echo 'placeholder="Enter first name"'; } ?>>
                            </div>
                            <div class="form-group">
                              <label for="inputMiddlename">Middle Name</label>
                              <input type="text" maxlength="30" class="form-control" id="inputMiddlename" <?php if($certMiddlename != ""){echo 'value="'.$certMiddlename.'"';}else{echo 'placeholder="Enter middle name"'; } ?>>
                            </div>
                            <div class="form-group">
                              <label for="inputLastname">Last Name</label>
                              <input type="text" maxlength="30" class="form-control" id="inputLastname" <?php if($certLastname != ""){echo 'value="'.$certLastname.'"';}else{echo 'placeholder="Enter last name"'; } ?>>
                            </div>
                            <div class="form-group">
                              <label for="inputAddress">Address</label>
                              <input type="text" class="form-control" id="inputAddress" <?php if($certAddress != ""){echo 'value="'.$certAddress.'"';}else{echo 'placeholder="Enter address"'; } ?> maxlength="100">
                            </div>
                            <div class="form-group">
                              <label for="inputNationality">Nationality</label>&nbsp;&nbsp;<input type="checkbox" id="checkbox"><span><i>&nbsp;&nbsp;(check if not a filipino)</i></span>
                              <select class="form-control select2bs4" style="width: 100%;" id="inputNationality" disabled>

                                <?php if($certNationality != ""){
                                  echo '<option value="'.$certNationality.'" selected>'.ucfirst($certNationality).'</option>';
                                }else{echo '<option value="filipino" selected>Filipino</option>';}?>                                
                                <option value="afghan">Afghan</option>
                                <option value="albanian">Albanian</option>
                                <option value="algerian">Algerian</option>
                                <option value="american">American</option>
                                <option value="andorran">Andorran</option>
                                <option value="angolan">Angolan</option>
                                <option value="antiguans">Antiguans</option>
                                <option value="argentinean">Argentinean</option>
                                <option value="armenian">Armenian</option>
                                <option value="australian">Australian</option>
                                <option value="austrian">Austrian</option>
                                <option value="azerbaijani">Azerbaijani</option>
                                <option value="bahamian">Bahamian</option>
                                <option value="bahraini">Bahraini</option>
                                <option value="bangladeshi">Bangladeshi</option>
                                <option value="barbadian">Barbadian</option>
                                <option value="barbudans">Barbudans</option>
                                <option value="batswana">Batswana</option>
                                <option value="belarusian">Belarusian</option>
                                <option value="belgian">Belgian</option>
                                <option value="belizean">Belizean</option>
                                <option value="beninese">Beninese</option>
                                <option value="bhutanese">Bhutanese</option>
                                <option value="bolivian">Bolivian</option>
                                <option value="bosnian">Bosnian</option>
                                <option value="brazilian">Brazilian</option>
                                <option value="british">British</option>
                                <option value="bruneian">Bruneian</option>
                                <option value="bulgarian">Bulgarian</option>
                                <option value="burkinabe">Burkinabe</option>
                                <option value="burmese">Burmese</option>
                                <option value="burundian">Burundian</option>
                                <option value="cambodian">Cambodian</option>
                                <option value="cameroonian">Cameroonian</option>
                                <option value="canadian">Canadian</option>
                                <option value="cape verdean">Cape Verdean</option>
                                <option value="central african">Central African</option>
                                <option value="chadian">Chadian</option>
                                <option value="chilean">Chilean</option>
                                <option value="chinese">Chinese</option>
                                <option value="colombian">Colombian</option>
                                <option value="comoran">Comoran</option>
                                <option value="congolese">Congolese</option>
                                <option value="costa rican">Costa Rican</option>
                                <option value="croatian">Croatian</option>
                                <option value="cuban">Cuban</option>
                                <option value="cypriot">Cypriot</option>
                                <option value="czech">Czech</option>
                                <option value="danish">Danish</option>
                                <option value="djibouti">Djibouti</option>
                                <option value="dominican">Dominican</option>
                                <option value="dutch">Dutch</option>
                                <option value="east timorese">East Timorese</option>
                                <option value="ecuadorean">Ecuadorean</option>
                                <option value="egyptian">Egyptian</option>
                                <option value="emirian">Emirian</option>
                                <option value="equatorial guinean">Equatorial Guinean</option>
                                <option value="eritrean">Eritrean</option>
                                <option value="estonian">Estonian</option>
                                <option value="ethiopian">Ethiopian</option>
                                <option value="fijian">Fijian</option>
                                <option value="finnish">Finnish</option>
                                <option value="french">French</option>
                                <option value="gabonese">Gabonese</option>
                                <option value="gambian">Gambian</option>
                                <option value="georgian">Georgian</option>
                                <option value="german">German</option>
                                <option value="ghanaian">Ghanaian</option>
                                <option value="greek">Greek</option>
                                <option value="grenadian">Grenadian</option>
                                <option value="guatemalan">Guatemalan</option>
                                <option value="guinea-bissauan">Guinea-Bissauan</option>
                                <option value="guinean">Guinean</option>
                                <option value="guyanese">Guyanese</option>
                                <option value="haitian">Haitian</option>
                                <option value="herzegovinian">Herzegovinian</option>
                                <option value="honduran">Honduran</option>
                                <option value="hungarian">Hungarian</option>
                                <option value="icelander">Icelander</option>
                                <option value="indian">Indian</option>
                                <option value="indonesian">Indonesian</option>
                                <option value="iranian">Iranian</option>
                                <option value="iraqi">Iraqi</option>
                                <option value="irish">Irish</option>
                                <option value="israeli">Israeli</option>
                                <option value="italian">Italian</option>
                                <option value="ivorian">Ivorian</option>
                                <option value="jamaican">Jamaican</option>
                                <option value="japanese">Japanese</option>
                                <option value="jordanian">Jordanian</option>
                                <option value="kazakhstani">Kazakhstani</option>
                                <option value="kenyan">Kenyan</option>
                                <option value="kuwaiti">Kuwaiti</option>
                                <option value="kyrgyz">Kyrgyz</option>
                                <option value="laotian">Laotian</option>
                                <option value="latvian">Latvian</option>
                                <option value="lebanese">Lebanese</option>
                                <option value="liberian">Liberian</option>
                                <option value="libyan">Libyan</option>
                                <option value="liechtensteiner">Liechtensteiner</option>
                                <option value="lithuanian">Lithuanian</option>
                                <option value="luxembourger">Luxembourger</option>
                                <option value="macedonian">Macedonian</option>
                                <option value="malagasy">Malagasy</option>
                                <option value="malawian">Malawian</option>
                                <option value="malaysian">Malaysian</option>
                                <option value="maldivan">Maldivan</option>
                                <option value="malian">Malian</option>
                                <option value="maltese">Maltese</option>
                                <option value="marshallese">Marshallese</option>
                                <option value="mauritanian">Mauritanian</option>
                                <option value="mauritian">Mauritian</option>
                                <option value="mexican">Mexican</option>
                                <option value="micronesian">Micronesian</option>
                                <option value="moldovan">Moldovan</option>
                                <option value="monacan">Monacan</option>
                                <option value="mongolian">Mongolian</option>
                                <option value="moroccan">Moroccan</option>
                                <option value="mosotho">Mosotho</option>
                                <option value="motswana">Motswana</option>
                                <option value="mozambican">Mozambican</option>
                                <option value="namibian">Namibian</option>
                                <option value="nauruan">Nauruan</option>
                                <option value="nepalese">Nepalese</option>
                                <option value="new zealander">New Zealander</option>
                                <option value="ni-vanuatu">Ni-Vanuatu</option>
                                <option value="nicaraguan">Nicaraguan</option>
                                <option value="nigerien">Nigerien</option>
                                <option value="north korean">North Korean</option>
                                <option value="northern irish">Northern Irish</option>
                                <option value="norwegian">Norwegian</option>
                                <option value="omani">Omani</option>
                                <option value="pakistani">Pakistani</option>
                                <option value="palauan">Palauan</option>
                                <option value="panamanian">Panamanian</option>
                                <option value="papua new guinean">Papua New Guinean</option>
                                <option value="paraguayan">Paraguayan</option>
                                <option value="peruvian">Peruvian</option>
                                <option value="polish">Polish</option>
                                <option value="portuguese">Portuguese</option>
                                <option value="qatari">Qatari</option>
                                <option value="romanian">Romanian</option>
                                <option value="russian">Russian</option>
                                <option value="rwandan">Rwandan</option>
                                <option value="saint lucian">Saint Lucian</option>
                                <option value="salvadoran">Salvadoran</option>
                                <option value="samoan">Samoan</option>
                                <option value="san marinese">San Marinese</option>
                                <option value="sao tomean">Sao Tomean</option>
                                <option value="saudi">Saudi</option>
                                <option value="scottish">Scottish</option>
                                <option value="senegalese">Senegalese</option>
                                <option value="serbian">Serbian</option>
                                <option value="seychellois">Seychellois</option>
                                <option value="sierra leonean">Sierra Leonean</option>
                                <option value="singaporean">Singaporean</option>
                                <option value="slovakian">Slovakian</option>
                                <option value="slovenian">Slovenian</option>
                                <option value="solomon islander">Solomon Islander</option>
                                <option value="somali">Somali</option>
                                <option value="south african">South African</option>
                                <option value="south korean">South Korean</option>
                                <option value="spanish">Spanish</option>
                                <option value="sri lankan">Sri Lankan</option>
                                <option value="sudanese">Sudanese</option>
                                <option value="surinamer">Surinamer</option>
                                <option value="swazi">Swazi</option>
                                <option value="swedish">Swedish</option>
                                <option value="swiss">Swiss</option>
                                <option value="syrian">Syrian</option>
                                <option value="taiwanese">Taiwanese</option>
                                <option value="tajik">Tajik</option>
                                <option value="tanzanian">Tanzanian</option>
                                <option value="thai">Thai</option>
                                <option value="togolese">Togolese</option>
                                <option value="tongan">Tongan</option>
                                <option value="tunisian">Tunisian</option>
                                <option value="turkish">Turkish</option>
                                <option value="tuvaluan">Tuvaluan</option>
                                <option value="ugandan">Ugandan</option>
                                <option value="ukrainian">Ukrainian</option>
                                <option value="uruguayan">Uruguayan</option>
                                <option value="uzbekistani">Uzbekistani</option>
                                <option value="venezuelan">Venezuelan</option>
                                <option value="vietnamese">Vietnamese</option>
                                <option value="welsh">Welsh</option>
                                <option value="yemenite">Yemenite</option>
                                <option value="zambian">Zambian</option>
                                <option value="zimbabwean">Zimbabwean</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputDOB">Date of Birth</label>
                              <input type="date" class="form-control" id="inputDOB" onkeydown="return false" <?php if($certDOB != ""){echo 'value="'.$certDOB.'"';} ?>>
                            </div>
                            <div class="form-group">
                              <label for="inputAge">Age</label>
                              <input type="text" class="form-control" id="inputAge" <?php 

                              if($certDOB != "" ){
                                $certDOB = date("m/d/Y", strtotime($certDOB));
                                $birthDate = explode("/", $certDOB);

                                echo 'value="'. $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md") ? ((date("Y") - $birthDate[2]) - 1) : (date("Y") - $birthDate[2])).'"';
                              }else{
                                echo 'placeholder="Enter age"';
                              }
                              ?> disabled>
                            </div>
                            <div class="form-group">
                              <label for="inputGender">Gender</label>
                              <select class="form-control select2bs4" style="width: 100%;" id="inputGender">
                                <?php if($certGender != ""){
                                  echo '<option value="'.$certGender.'" selected>'; if($certGender=="M"){echo 'Male';}else{echo 'Female';} echo'</option>';
                                }else{echo '<option disabled value="" selected>Choose gender</option>';}?> 
                                <option value="M">Male</option>
                                <option value="F">Female</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label for="inputStatus">Marital Status</label>
                              <select class="form-control select2bs4" style="width: 100%;" id="inputStatus">
                                <?php if($certMaritalStatus != ""){
                                  echo '<option value="'.$certMaritalStatus.'" selected>'; if($certMaritalStatus =="S"){echo 'Single';}else if($certMaritalStatus =="M"){echo 'Married'; }else if($certMaritalStatus =="D"){ echo 'Divorced'; }else{ echo'Widowed'; } echo'</option>';
                                }else{echo '<option disabled value="" selected>Choose status</option>';}?> 
                                <option value="S">Single</option>
                                <option value="M">Married</option>
                                <option value="D">Divorced</option>
                                <option value="W">Widowed</option>
                              </select>
                            </div>
                            <input type="text" id="primeeee" <?php if($haha2[0] != ""){echo 'value="'.$haha2[0].'"';} ?> hidden>
                            <button id="butsave1" class="btn btn-primary container-fluid"><i class="nav-icon fas fa-plus"></i> Save</button>
                    </div>
                    <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                        <br><h3>Step 2: Driving Course Training Information</h3>
                        <div class="form-group">
                          <label for="inputCourseName">Driving Course Name</label>
                          <select class="form-control select2bs4" style="width: 100%;" id="inputCourseName" required>
                            <?php 

                            if($certCourse != ""){
                              echo '<option value="'.$certCourse.'" selected>'; if($certCourse == "TDC"){echo "Theoretical Driving Course";}else if($certCourse == "PDC"){echo "Practical Driving Course";} echo '</option>';
                            }else{ echo '<option value="TDC" selected>Theoretical Driving Course</option>'; }?> 

                            ?>
                            <option value="PDC">Practical Driving Course</option>
                          </select>

                        </div>
                        <div class="form-group">
                          <label for="inputProgramType">Program Type</label>
                            <?php if($certProgram != ""){
                              $var = "";
                              if($certProgram == "TIT"){$var = "THEORETICAL INSTRUCTION TRAINING";}else if($certProgram == "PDIT"){$var = "PRACTICAL DRIVING INSTRUCTION TRAINING";}
                              echo '<input type="text" class="form-control" value="'.$var.'">';
                            }else {
                              echo '<div id="newInputProgramType">
                              
                            </div>';
                            }
                            ?>
                        </div>
                        <div class="form-group">
                              <label for="inputDriversLicenseNo">Driver's Licence Number</label>
                              <input type="text" class="form-control" id="inputDriversLicenseNo" maxlength="11" <?php if($certDLNo != ""){echo 'value="'.$certDLNo.'"';}else{echo 'placeholder="Enter driver\'s licence number"'; } ?> disabled>
                            </div>
                        <div class="form-group">
                          <label for="inputTrainingPurpose">Training Purpose</label>
                            <?php if($certPurpose != ""){
                              $var = "";
                              if($certPurpose == "SP"){$var = "Studen Permit";}else if($certPurpose == "NEW"){$var = "New Driver's Licence";}else if($certPurpose == "ADD"){$var = "Adding Restriction Code";}else if($certPurpose == "SEM"){$var = "Seminar";}
                              echo '<input type="text" class="form-control" value="'.$var.'">';
                            }else {
                              echo '<div id="newInputTrainingPurpose">
                              
                                </div>';
                            }
                            ?>
                        </div>
                        <label for="inputDL">DL Codes</label>
                        <div class="form-group input-group">
                           <div class="input-group-prepend">
                              <button class="btn btn-primary input-group-text" id="btnDL" data-toggle="modal" data-target="#dlCodeModal1" disabled><i class="nav-icon fas fa-plus"></i></button>
                            </div>
                          <input type="text" class="form-control" id="inputDL" <?php if($certDL != ""){echo 'value="'.$certDL.'"';}else{echo 'placeholder="Enter DL codes"'; }?> disabled>
                          <input type="hidden" id="inputDL2">
                          
                        </div>
                        
                        <div class="form-group">
                          
                            <label for="inputMV">MV Type Used</label>
                          <input type="text" class="form-control" id="inputMV" <?php if($certMV != ""){echo 'value="'.$certMV.'"';}else{echo 'placeholder="Enter MV used type"'; }?> disabled>
                          <input type="hidden" id="inputMV2">
                        </div>
                        <div class="form-group">
                          <label for="inputDateStarted">Date Started</label>
                          <?php if($certStarted != ""){
                            
                            echo '<input type="date" class="form-control" id="inputDateStarted" value="'.$certStarted = date("m/d/Y", strtotime($certStarted)).'" name="DateStarted" onkeydown="return false" required>';
                          }else{
                            echo '<input type="date" class="form-control" id="inputDateStarted" name="DateStarted" onkeydown="return false" required>';
                          }
                          ?>
                          
                        </div>
                        <div class="form-group">
                          <label for="inputDateCompleted">Date Completed</label>
                          <?php if($certCompleted != ""){
                            echo '<input type="date" class="form-control" id="inputDateCompleted"  value="'.$certCompleted = date("m/d/Y", strtotime($certCompleted)).'" name="DateCompleted"  onkeydown="return false" disabled required>';
                          }else{
                            echo '<input type="date" class="form-control" id="inputDateCompleted" name="DateCompleted"  onkeydown="return false" disabled required>';
                          }
                          ?>
                          
                        </div>
                        <div class="form-group">
                          <label for="inputHours">Total Number of Hours</label>
                          <input type="number" class="form-control" id="inputHours" name="Hours" <?php if($certHours != ""){echo 'value="'.$certHours.'"';}else{echo 'placeholder="Enter total number of hours"'; }?> required>
                        </div>
                        <button id="butsave2" class="btn btn-primary container-fluid"><i class="nav-icon fas fa-plus"></i> Save</button>
                        <input type="text" id="primaryKey" <?php if($haha[0] != ""){echo 'value="'.$haha[0].'"';} ?> hidden>
                    </div>
                    <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                        <br><h3>Step 3: Driving Course Training Evaluation</h3>
                        
                        <div class="form-group">
                          <label for="inputAssessment">Assessment</label>
                          <select class="form-control select2bs4" style="width: 100%;" id="inputAssessment" required>
                            <?php 

                            if($certAssessment != ""){
                              echo '<option value="'.$certAssessment.'" selected>'; if($certAssessment == "P"){echo "PASSED";}else if($certAssessment == "F"){echo "FAILED";} echo '</option>';
                            }else{ echo '<option disabled value="" selected>Choose assessment</option>'; }?> 
                            <option value="P">PASSED</option>
                            <option value="F">FAILED</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="inputOverallRating">Overall Rating</label>
                          <select class="form-control select2bs4" style="width: 100%;" id="inputOverallRating" required>
                            <?php 
                            if($certOverall != ""){
                              echo '<option value="'.$certOverall.'" selected>'; if($certOverall == "P"){echo "PASSED";}else if($certOverall == "F"){echo "FAILED";} echo '</option>';
                            }else{ echo '<option disabled value="" selected>Choose overall rating</option>'; }?>
                            ?>
                            <option value="P">PASSED</option>
                            <option value="F">FAILED</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="inputRemarks">Additional Remarks (optional)</label>
                          <input type="text" class="form-control" id="inputRemarks" <?php if($certRemarks != ""){echo 'value="'.$certRemarks.'"';}else{echo 'placeholder="Enter additional remarks"'; }?> maxlength="100">
                        </div>
                        <div class="form-group">
                          <label for="inputBranch">Branch</label>
                          <select class="form-control select2bs4" style="width: 100%;" id="inputBranch" required>
                            <option disabled value="" selected>Choose branch</option>
                            <?php 
                              include 'connection.php';

                              $sql = "SELECT * FROM tbl_branches WHERE branchStatus = 'Active'";

                              $result = mysqli_query($conn, $sql);

                              if(mysqli_num_rows($result) > 0){
                                while ($row = mysqli_fetch_assoc($result)) {
                                  echo '<option value="'.$row['branchID'].'">'.$row['branchName'].'</option>';
                                }
                              }
                          ?>
                          </select>
                        </div>
                        <button id="butsave3" class="btn btn-primary container-fluid"><i class="nav-icon fas fa-plus"></i> Save</button>
                        <input type="text" id="primaryKey2" <?php if($haha[0] != ""){echo 'value="'.$haha[0].'"';} ?> hidden>
                    </div>
                    <div id="step-4" class="tab-pane" role="tabpanel" aria-labelledby="step-4">
                        <br><h3>Step 4: Image Setup</h3>
                        <div class="form-group">
                          <label for="inputChooseImage">Choose Image Type </label>
                          <select class="form-control select2bs4" style="width: 100%;" id="inputChooseImage" required>
                            <option value="C" selected>Capturing</option>
                            <option value="U">Uploading</option>
                          </select>
                        </div>
                        <div class="form-group">
                          
                          <style type="text/css">
                            #camera{
                              width: 100%;
                              height: 100%;
                            }
                            #resuls{
                              border: 1px solid black;

                            }
                          </style>
                          <div class="row">
                            <div class="col-6" id="capture">
                                <label for="inputImageCapture">Be ready for image capturing</label>
                                <center>
                                    <div id="camera"></div>
                                    <button class="btn btn-primary" id="takeCaptureBtn" disabled><i class="nav-icon fas fa-camera-retro"></i> Take snapshot</button><div id="errorMsg"></div>
                                </center>
                            </div>
                            <div class="col-12" id="upload" hidden>
                                <label for="inputImageUpload">Uploading image/ picture</label>
                                <input type="file" accept="image/jpeg" onchange="encodeImgtoBase64(this)" id="inputImageUpload">
                            </div>
                            <div class="col-6" id="caploadResult">

                                <center>
                                  <img width="350px" id="results" height="320px" src="majesty-images/unknown.jpg">
                                    
                                </center>

                            </div>
                            <div class="col-12">
                                <input type="text" id="primaryKey3" hidden>
                            <input type="text" id="inputCamera" hidden/><br>
                            <center>
                                <button class="btn btn-primary" id="takeUploadBtn" disabled hidden><i class="nav-icon fas fa-camera-retro"></i> Save upload</button>
                            </center>

                            </div>
                          </div><br>
                          <button id="butsave4" class="btn btn-primary container-fluid" disabled><i class="nav-icon fas fa-print"></i> Print Certificate</button><br><br><br>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>  
      </section>
  </div>

<div class="modal fade" id="dlCodeModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">DL Codes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <table class="table table-bordered">
            <tr align="center">
              <th colspan="4" rowspan="2">DL Code(s) with vehicle category<br><br>Licence Type
              <select class="form-control select2bs4" style="width: 100%;" id="inputLT">
                  
                  <option value="NPL">Non-Professional</option>
                  <option selected value="PL">Professional</option>
                </select></th>
              
              <th colspan="2">Transmission Type</th>
              <th rowspan="2">Action</th>
            </tr>
            <tr align="center">
              
              <th>AT</th>
              <th>MT</th>
            </tr>

            
            
            <?php 
                include 'connection.php';

                $sql = "SELECT dlCodeName,dlCodeDesc,dlCodeType FROM tbl_dlCodes WHERE dlCodeStatus = 'Active' AND dlCodeType LIKE '%PL' GROUP BY dlCodeDesc ORDER BY dlCodeName ASC";

                $result = mysqli_query($conn, $sql);

              if(mysqli_num_rows($result) > 0){
                $no = 1;
                $no2 = 1;
                $dlno = 1;
                $clearno = 1;
                while ($row = mysqli_fetch_assoc($result)) {

                  $newAcredd = explode("-", $row['dlCodeType']);

                  if(isset($newAcredd[0]) && $newAcredd[0] == ""){
                        echo '<tbody id="tblDLCodes'.$dlno.'" class="countDLCodes countLT">';
                  }

                  echo '<tr>';
                    echo '<th><input type="checkbox" onchange="handleChange(this,'.$no.')" id="prime'.$no.'" value="'.$row['dlCodeName'].'"></th>';
                    echo '<th>'.$row['dlCodeName'].' - '.$row['dlCodeDesc'].'</th>';
                    
                    echo '<td colspan="2"><label hidden>MV Type Used:</label>
                    <div class="form-group" hidden>
                      <div class="input-group-prepend">
                        <input type="text" id="king'.$no.'" value="'.$row['dlCodeDesc'].'" class="form-control" placeholder="Enter MV used type in '.$row['dlCodeDesc'].'" maxlength="13" disabled>
                        <button class="btn btn-warning input-group-text" id="clear'.$no.'" onclick="clearX('.$no.')" disabled><i class="fas fa-times icon"></i></button>
                     </div>
                    </div>
                      </td>'; 
                    echo '<td></td>';
                    echo '<td></td>';
                    echo '<td></td>';
                  echo '</tr>'; 

                  
                  

                  $sql2 = "SELECT * FROM tbl_dlCodes WHERE dlCodeName='".$row['dlCodeName']."' AND dlCodeDesc='".$row['dlCodeDesc']."' ORDER BY dlCodeName ASC";

                  $result2 = mysqli_query($conn, $sql2);
                  $dl = $row['dlCodeName'];
                  if(mysqli_num_rows($result2) > 0){
                    while ($row2 = mysqli_fetch_assoc($result2)) {

                      
                      
                     
                      echo '<tr>';
                        echo '<td></td>'; 
                        echo '<td align="right"><input type="checkbox" onchange="handleChange2(this,'.$no2.')" id="check'.$no2.'"  class="groupX'.$no.'" value="'.$dl.' / '.$row2['dlCodeSubName'].'"  disabled></td>';
                        echo '<td colspan="2">'.$row2['dlCodeSubName'].' - '.$row2['dlCodeSubDesc'].'</td>';

                        $newTrans = explode("-", $row2['dlCodeTransmission']);

                        if(isset($newTrans[0]) && $newTrans[0] == "AT"){
                          echo '<td align="center"><input type="radio" class="group2X'.$no2.' groupX'.$no.'" name="gro2up'.$no2.'" value="'.$newTrans[0].'" disabled></td>';
                        }else{
                          echo '<td></td>';
                        }

                        if(isset($newTrans[1]) && $newTrans[1] == "MT"){
                          echo '<td align="center"><input type="radio" class="group2X'.$no2.' groupX'.$no.'" name="gro2up'.$no2.'" value="'.$newTrans[1].'" disabled></td>';
                        }else{
                          echo '<td></td>';
                        }
                        echo '<td>
                        <div id="btnActions'.$no.'">
                          <button class="btn btn-primary groupX'.$no.'" id="btn'.$no2.'" onclick="clickedX('.$no2.','.$no.')" disabled><i class="nav-icon fas fa-share"></i></button><button class="btn btn-success sample'.$clearno.' groupY'.$no.'" id="btnY'.$no2.'" onclick="clickedY('.$no2.','.$no.')" hidden><i class="nav-icon fas fa-backspace"></i></button>
                        </div></td>';

                      echo '</tr>';
                      
                      $no2++;
                    }

                    if(isset($newAcredd[0]) && $newAcredd[0] == ""){
                        echo '</tbody>';
                       $dlno++;
                    }
                    
                  echo '<tr>';
                    echo '<td colspan="9" bgcolor="grey"></td>';
                  echo '</tr>';


                  }
                  $no++;
                }
              }
              ?>
              
          </table>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary"  data-dismiss="modal"><i class="nav-icon fas fa-forward"></i> Continue</button>
      </div>
    </div>
  </div>
</div>
    <?php include 'footer.php'; ?>

     <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
<!-- ./wrapper -->
<!-- jQuery -->
   <?php include 'script.php';  ?>
  <script type="text/javascript" src="dist2/js/jquery.smartWizard.min.js"></script>
  
  <script>

    var someObj={};
    someObj.fruitsGranted=[];
    someObj.fruitsDenied=[];

    function clicked(){
      

      for (var i = 0; i < someObj.fruitsGranted.length; i++) {
        var hehe = someObj.fruitsGranted[i];
        alert(hehe);
      }
      
    }
    function showDLnMV(){
      var mv = $("#inputMV2").val();
      var dl = $("#inputDL2").val();
      

      var itemMV = mv.substring(1, mv.length);
      var itemDL = dl.substring(1, dl.length);
      

      var resMV = itemMV.replace(/\//g, "-");
      var resDL = itemDL.replace(/\//g, "-");
      

      $("#inputMV").val(resMV);
      $("#inputDL").val(resDL);
      
    }

    
    function clearX(no){

      var mv = $("#inputMV2").val();
      var newMV = $("#prime"+no).val() + " / "+$("#king"+no).val();
    
      if(mv.includes(newMV)){
        
        var strnew = mv.replace(',['+newMV+']','');
        
        $("#inputMV2").val(strnew);
      }

     
    }

    function clearZ(no){

      alert('HAHAH '+no);
      
    }

    function handleChange(checkbox,no) {
      $("table .groupX"+no).prop("checked", false); 
      
        if(checkbox.checked == true){
            
            $("table .groupX"+no+":checkbox").attr("disabled", false);

           
            $("#king"+no).attr('disabled',false);
            $("#clear"+no).attr('disabled',false);
            $("#inputDateStarted"+no).attr('disabled',false);
            $("#inputDateCompleted"+no).attr('disabled',false);
            

            callDateTime(no);

            $("table .groupX"+no).prop("checked", true); 
            $("table .groupX"+no+":button").attr("disabled", false);
            $("table .groupX"+no+":radio").attr("disabled", false);
            
        }else{
            $("table .groupX"+no).attr("disabled", true);
            $("table .groupX"+no).prop("checked", false);
            $("#king"+no).attr('disabled',true);
            $("#clear"+no).attr('disabled',true);
            $("#inputDateStarted"+no).val('');
            $("#inputDateCompleted"+no).val('');
            $("#inputDateStarted"+no).attr('disabled',true);
            $("#inputDateCompleted"+no).attr('disabled',true);


         
       }


    }

   

    function handleChange2(checkbox,no2) {

      $("table .group2X"+no2).prop("checked", false);
      
        if(checkbox.checked == true){

            $("table .group2X"+no2).attr("disabled", false); 
            $("table .group2X"+no2).prop("checked", true);
            $("table #btn"+no2).attr("disabled", false);


            
        }else{
            $("table .group2X"+no2).attr("disabled", true);
            $("table .group2X"+no2).prop("checked", false);
            $("table #btn"+no2).attr("disabled", true);

       }
    }

    function clickedX(no2,no){ 
                                                     
      var value = "["+$("#check"+no2).val() + " " + $('#inputLT option:selected').val() + " " + $("input[name = 'gro2up"+no2+"']:checked").val()+"]";

      if($("#king"+no).val() != "" ){
          $("#btn"+no2).attr('hidden',true);
          $("#btnY"+no2).attr('hidden',false);
          $("#check"+no2).attr('disabled',true);
          
          $("input[name = 'gro2up"+no2+"']").attr('disabled',true);
          
          $("#king"+no).attr('disabled',true);
          $("#clear"+no).attr('disabled',true);
          $("#clearZ"+no).attr('disabled',true);
          $("#inputDateStarted"+no).attr('disabled',true);
          $("#inputDateCompleted"+no).attr('disabled',true);

          if($("#check"+no2).attr('disabled',true)){
            $("#prime"+no).attr('disabled',true);
            $('#inputLT').attr('disabled',true);
          }

          //DL input
          var dl = $("#inputDL2").val();

          var total = dl +","+ value;
        
          $("#inputDL2").attr('value',total);


          //MV input
          var mv = $("#inputMV2").val();
          var newMV = $("#prime"+no).val() + " / "+$("#king"+no).val();
          
          if(!mv.includes(newMV)){
              
            var totalMV = mv + ",["+newMV+"]";

            $("#inputMV2").val(totalMV);
          }

          

      }else{
        alert("Fill all required fields!!");
      }
      
     
      showDLnMV();

    }
    
    function clickedY(no2,no){ 
      
      var value = "["+$("#check"+no2).val() + " " + $('#inputLT option:selected').val() + " " + $("input[name = 'gro2up"+no2+"']:checked").val()+"]";
      
        var r = confirm("Are you sure you want to reset "+ value);
        if (r == true) {
            $("#btn"+no2).attr('hidden',false);
            $("#btnY"+no2).attr('hidden',true);
            $("#check"+no2).attr('disabled',false);
            
            $("input[name = 'gro2up"+no2+"']").attr('disabled',false);
            
            var btn = []; 
            $('.sample1').each(function(index, obj){
              if($(this).attr('hidden')){
                btn[index] = true;
              }else{
                btn[index] = false;
              }
            });

            const allEqual = arr => arr.every(v => v === arr[0]);
            if(allEqual(btn)){
              
              $('#inputLT').attr('disabled',false);
              $('.groupX'+no+" :checkbox").attr('disabled',false);
            }


            var dl = $("#inputDL2").val();
            
            if(dl.includes(value)){
              var strnew = dl.replace(','+value,'');

              $("#inputDL2").attr('value',strnew);
            }

           

            clearX(no);

          
        }

        showDLnMV();

    }

    $("#inputLT").on('change',function(){

      var haha = $('#inputLT option:selected').val();
      
      var numItems = $('.countDLCodes').length
      
      var able;
      if(haha == "NPL"){ 
        able = true;
      }else if(haha == "PL"){
        able = false;
      }

      for (var i = 1; i <= numItems; i++) {
        $("#tblDLCodes"+i+" input:checkbox").attr('disabled',able);
      }

      
    });

    function callDateTime(id){
      $('#inputDateStarted'+id).val('dd/mm/yyyy');
      $('#inputDateCompleted'+id).val('dd/mm/yyyy');
      $('#inputDateCompleted'+id).attr('disabled', true);

      var dtToday2 = new Date();

      var day2 = dtToday2.getDate();
      var month2 = dtToday2.getMonth() + 1;    
      var year2 = dtToday2.getFullYear();
      if(month2 < 10)
        month2 = '0' + month2.toString();
      if(day2 < 10)
        day2 = '0' + day2.toString();

      var maxDate2 = year2 + '-' + month2 + '-' + day2;

      $('#inputDateStarted'+id).attr('max', maxDate2);

      $('#inputDateStarted'+id).change(function(){

      var dt1 = document.getElementById('inputDateStarted'+id).value;

      var dtToday = new Date(dt1);
      var month = dtToday.getMonth() + 1;     
      var day = dtToday.getDate();
      var year = dtToday.getFullYear();
      if(month < 10)
        month = '0' + month.toString();
      if(day < 10)
        day = '0' + day.toString();
              
      var maxDate = year + '-' + month + '-' + day;

      $('#inputDateCompleted'+id).attr('min', maxDate);

      $('#inputDateCompleted'+id).attr('disabled', false);
      $('#clearZ'+id).attr('disabled', false);

      $('#inputDateCompleted'+id).attr('max', maxDate2);

      });          
    }

    var loadFile = function(event) {
    var output = document.getElementById('results');
      
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) 
      }
    };

    function validateFileType(){
        var fileName = document.getElementById("inputImageUpload").value;
        var fileSize = document.getElementById('inputImageUpload').files[0].size

        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();

        if (extFile=="jpg"){
            //TO DO
          const file = Math.round((fileSize / 1024));

          if(file >= 64){
            alert("File too Big, please select a file less than 64kb");
            $('#results').attr('src','majesty-images/unkown.jpg');
            document.getElementById('inputImageUpload').value= null;
            document.getElementById('takeUploadBtn').disabled = true;
            document.getElementById('butsave4').disabled = true; 
            
          }else{
            loadFile(event);
            document.getElementById('takeUploadBtn').disabled = false; 
          }         
        }else{
            alert("Only jpg files are allowed!");
            document.getElementById('inputImageUpload').value= null;
            $('#results').attr('src','majesty-images/unkown.jpg');
            document.getElementById('butsave4').disabled = true; 
            document.getElementById('takeUploadBtn').disabled = true;
            
        }   
    }

    function encodeImgtoBase64(element) {
 
      var img = element.files[0];
        
      var reader = new FileReader();
 
      reader.onloadend = function() {
        
        $("#inputCamera").val(reader.result);

      }
      reader.readAsDataURL(img);
      validateFileType();
    }

    
         
    </script>
  <script type="text/javascript">
        $(document).ready(function(){

          $('#smartwizard').smartWizard({
                selected: 0,
                theme: 'progress', 
                
                transition: {
                    animation: 'slide-horizontal', 
                },
                toolbarSettings: {
                    toolbarPosition: 'bottom', 
                    
                    showPreviousButton : false,
                    showNextButton : false,
                    
                },keyboardSettings: {
                      keyNavigation: false, 
                      keyLeft: [37], 
                      keyRight: [39] 
                  },enableURLhash: false

            });

            var dtToday = new Date();
            var month = dtToday.getMonth() + 1;     
            var day = dtToday.getDate();
            var year = dtToday.getFullYear(); 
            if(month < 10)
                month = '0' + month.toString();
            if(day < 10)
                day = '0' + day.toString();
            
            var maxDate = year + '-' + month + '-' + day;
            $('#inputDOB').attr('max', maxDate);

            $('#inputDOB').change(function() { 
                var dt1 = document.getElementById('inputDOB').value;
                var birth_date = new Date(dt1);


                var b_month = birth_date.getMonth();     
                var b_day = birth_date.getDate();
                var b_year = birth_date.getFullYear();

                

                today_date = new Date();
                today_year = today_date.getFullYear();
                today_month = today_date.getMonth();
                today_day = today_date.getDate();

                age = today_year - b_year;

                if ( today_month < (b_month - 1))
                {
                    age--;
                }
                if (((b_month - 1) == today_month) && (today_day < b_day))
                {
                    age--;
                }

                $('#inputAge').attr('value', '0');
                $('#inputAge').attr('value', age); 
            });

            function stepsCounter(){
               var steps = $('#steps').val();
               
               if(steps == 1){
                $('#smartwizard').smartWizard("goToStep", 1);

                $("#step-1 input").prop("disabled", true);
                $("#step-1 select").prop("disabled", true);
                $("#step-1 button").prop("disabled", true);

                
                
               }else if(steps == 2){
                $('#smartwizard').smartWizard("goToStep", 1);
                $('#smartwizard').smartWizard("goToStep", 2);

                $("#step-1 input").prop("disabled", true);
                $("#step-1 select").prop("disabled", true);
                $("#step-1 button").prop("disabled", true);

                $("#step-2 input").prop("disabled", true);
                $("#step-2 select").prop("disabled", true);
                $("#step-2 button").prop("disabled", true);

               }else if(steps == 3){
                $('#smartwizard').smartWizard("goToStep", 1);
                $('#smartwizard').smartWizard("goToStep", 2);
                $('#smartwizard').smartWizard("goToStep", 3);

                $("#step-1 input").prop("disabled", true);
                $("#step-1 select").prop("disabled", true);
                $("#step-1 button").prop("disabled", true);

                $("#step-2 input").prop("disabled", true);
                $("#step-2 select").prop("disabled", true);
                $("#step-2 button").prop("disabled", true);

                $("#step-3 input").prop("disabled", true);
                $("#step-3 select").prop("disabled", true);
                $("#step-3 button").prop("disabled", true);

                take_snapshot();
               }
             }

             stepsCounter();
             
            


            function callInputs(inputIndex){
              
              var types = ["THEORETICAL INSTRUCTION TRAINING", "PRACTICAL DRIVING INSTRUCTION TRAINING"]; 
              var typesVar = ["TIT","PDIT"];

              $('#inputHours').val('15');

             

              if (inputIndex == 0) {
                  $('<input type="text" class="form-control" value="STUDENT PERMIT" placeholder="Enter Training Purpose" disabled required><input type="text" class="form-control" id="inputTrainingPurpose" value="SP" hidden>').appendTo('#newInputTrainingPurpose');
                  
                 

                   $("#inputDriversLicenseNo").attr('disabled',true);

                  callDateTimeX();

              }else if(inputIndex == 1){

                $('<select class="form-control select2bs4" style="width: 100%;" id="inputTrainingPurpose" required>'+
                        '<option disabled value="" selected>Choose training purpose</option>' +
                        '<option value="NEW">New Driver\'s Licence</option>' +
                        '<option value="ADD">Adding Restriction Code</option>' +
                        '<option value="SEM">Seminar</option>' +
                    '</select>').appendTo('#newInputTrainingPurpose');

                  

                  $("#inputDriversLicenseNo").attr('disabled',false);
                
              }
              
              $('<input type="text" class="form-control" value="'+ types[inputIndex] +'"  disabled required><input type="text" class="form-control" id="inputProgramType" value="'+ typesVar[inputIndex] +'" hidden>').appendTo('#newInputProgramType');
            }

            callInputs(0);

            function callDateTimeX(){
              $('#inputDateStarted').val('dd/mm/yyyy');
              $('#inputDateCompleted').val('dd/mm/yyyy');
              $('#inputDateCompleted').attr('disabled', true);

              var dtToday2 = new Date();

              var day2 = dtToday2.getDate();
              var month2 = dtToday2.getMonth() + 1;    
              var year2 = dtToday2.getFullYear();
              if(month2 < 10)
                month2 = '0' + month2.toString();
              if(day2 < 10)
                day2 = '0' + day2.toString();

              var maxDate2 = year2 + '-' + month2 + '-' + day2;

              $('#inputDateStarted').attr('max', maxDate2);

              $('#inputDateStarted').change(function(){

                var dt1 = document.getElementById('inputDateStarted').value;
                

              var dtToday = new Date(dt1);
              var month = dtToday.getMonth() + 1;     
              var day = dtToday.getDate();
              var year = dtToday.getFullYear();
              if(month < 10)
                month = '0' + month.toString();
              if(day < 10)
                day = '0' + day.toString();
                      
              var maxDate = year + '-' + month + '-' + day;

              $('#inputDateCompleted').attr('min', maxDate);

              $('#inputDateCompleted').attr('disabled', false);
              $('#clearZ').attr('disabled', false);

              $('#inputDateCompleted').attr('max', maxDate2);

              });          

              $('#inputDateCompleted').change(function(){

                var dt2 = document.getElementById('inputDateCompleted').value;

                
              }); 
            }
            
            $("#inputCourseName").on('change',function(){
              var haha = $('#inputCourseName option:selected').val();
              
              if(haha == "TDC"){
                
                $("#newInputProgramType").empty();
                $("#newInputTrainingPurpose").empty();

                callInputs(0);
                

                $('#inputMV').attr('disabled', true);
                $('#inputMV').val('');
                $('#inputMV').attr('placeholder', 'Enter MV used type');
                $('#inputDL').attr('disabled', true);
                $('#inputDL').val('');
                $('#inputDL').attr('placeholder', 'Enter DL codes');

                $('#inputDL2').val('');
                $('#inputMV2').val('');
                

                $('#btnMV').attr('disabled', true);
                $('#btnDL').attr('disabled', true);

              }else if(haha == "PDC"){
                $("#newInputProgramType").empty();
                $("#newInputTrainingPurpose").empty();

                callInputs(1);
                
                $('#inputDL2').val('');
                $('#inputMV2').val('');
                

                $('#inputHours').val('8');
                
                $('#btnMV').attr('disabled', false);
                $('#btnDL').attr('disabled', false);

              }
            });

          
            function urlencode(str) {
                str = (str + '')
                    .toString();
                return encodeURIComponent(str)
                    .replace(/!/g, '%21')
                    .replace(/'/g, '%27')
                    .replace(/\(/g, '%28')
                    .
                replace(/\)/g, '%29')
                    .replace(/\*/g, '%2A')
                    .replace(/%20/g, '+');
            }

            
        $('#checkbox').on("click",function(){
          if($(this).is(":checked")){
               $('#inputNationality').attr('disabled', false);
            }
            else if($(this).is(":not(:checked)")){
                $('#inputNationality').attr('disabled', true);
                $('#inputNationality').val("filipino");
            }
        });


        $("#inputChooseImage").on('change',function(){
              var haha = $('#inputChooseImage option:selected').val();

              $("#inputCamera").val('');
              $('#results').attr('src','majesty-images/unknown.jpg');
              document.getElementById('butsave4').disabled = true; 
              document.getElementById('inputImageUpload').value= null;
              $('#takeUploadBtn').attr('disabled', true);

              if(haha == "C"){
                $('#capture').attr('hidden', false);
                $('#upload').attr('hidden', true);   

                $('#caploadResult').removeClass("col-12");
                $('#caploadResult').addClass("col-6");
                
                $('#takeUploadBtn').attr('hidden', true); 
                
              }else if(haha == "U"){
                $('#upload').attr('hidden', false);
                $('#capture').attr('hidden', true);

                $('#caploadResult').removeClass("col-6");
                $('#caploadResult').addClass("col-12");

                $('#takeUploadBtn').attr('hidden', false); 

              }

        });

        $('#butsave1').on("click",function() {  
          var primeeee = $('#primeeee').val();
          var inputFirstname = $('#inputFirstname').val();
          var inputMiddlename = $('#inputMiddlename').val();
          var inputLastname = $('#inputLastname').val();
          var inputAddress = $('#inputAddress').val();
          var inputNationality = $('#inputNationality').val();
          var inputDOB = $('#inputDOB').val();
          var inputAge = $('#inputAge').val();
          var inputGender = $('#inputGender').val();
          var inputStatus = $('#inputStatus').val();

            if(inputAddress.length > 125){
              alert("Length of Address was meet the max requirement");
            }else if(inputFirstname !="" && inputMiddlename !="" && inputLastname !="" && inputAddress !="" && inputNationality !="" && inputDOB !="" && inputAge !="" && inputGender != null && inputStatus != null){
              $.ajax({
                    url: "add-student-query.php",
                    type: "POST",
                    datatype: "text",
                    data: {
                      primeeee: primeeee,
                      inputFirstname: inputFirstname,
                      inputMiddlename: inputMiddlename,
                      inputLastname: inputLastname,
                      inputAddress: inputAddress,
                      inputNationality: inputNationality,
                      inputDOB: inputDOB,
                      inputGender: inputGender,
                      inputStatus: inputStatus
                    },
                    cache: false,
                    success: function(response){

                      var nameArr = response.split(',');

                      if(nameArr[0] == "1"){
                        alert('Data added successfully !');
                        $('#primeeee').val(nameArr[1]);

                        
                        $('#butsave1').attr('disabled',true);
                        $('#step-1 :input').attr('disabled',true);
                        $('#smartwizard').smartWizard("goToStep", 1);

                    }else{
                        alert(response);
                      }
                    }
              });
            }else{
              alert("Fill all required fields!!");
            }
          }); 

        $('#btnDuplicate').on("click",function() {  
          var inputDuplicate = $('#modalStudID').val();

          
          $.ajax({
            url: "add-student-query.php",
            type: "POST",
            datatype: "text",
            data: {
              inputDuplicate: inputDuplicate,
            },
            cache: false,
            success: function(response){
              if(response > 1){
                alert('Duplicate successfully !');
     

                $('#duplicateModal').modal('toggle');
                window.location.href='add-student2.php?'+urlencode(btoa('id='+response+'&step=1'));

                

              }else{
                alert(response);
              }
            }
          });

        });



        $('#butsave2').on("click",function() {
          

          var primeeee = $('#primeeee').val();

          var inputCourseName = $('#inputCourseName').val();
          var inputDriversLicenseNo = $('#inputDriversLicenseNo').val();
          var inputProgramType = $('#inputProgramType').val();
          var inputTrainingPurpose = $('#inputTrainingPurpose').val();

         
          var inputMV2 = $('#inputMV2').val();
          var inputDL2 = $('#inputDL2').val();
          var inputDateStarted = $('#inputDateStarted').val();
          var inputDateCompleted = $('#inputDateCompleted').val();
          
          var inputHours = $('#inputHours').val();

          var sample = $('#inputCourseName option:selected').val();

          var DL = true;
          var MV = true;
          var LicenceNo = true;

          if(sample == "PDC"){
             DL = inputDL2 != "";
             MV = inputMV2 != "";
             

            if(inputDriversLicenseNo.length != 11){
              alert("Length of Drivers Licence wasn't meet the minimum length requirement");
              LicenceNo = false;
            }else{
              LicenceNo = true;
            }
          }
            if(primeeee != "" && inputCourseName !="" && inputProgramType !="" && inputTrainingPurpose != null && inputDateStarted !="" && inputDateCompleted !="" && inputHours !="" && DL && MV && LicenceNo){
              
              $.ajax({
                    url: "add-student-query.php",
                    type: "POST",
                    datatype: "text",
                    data: {
                      
                      primeeee: primeeee,
                      inputCourseName: inputCourseName,
                      inputDriversLicenseNo: inputDriversLicenseNo,
                      inputProgramType: inputProgramType,
                      inputTrainingPurpose: inputTrainingPurpose,
                      inputMV2: inputMV2,
                      inputDL2: inputDL2,
                      inputDateStarted: inputDateStarted,
                      inputDateCompleted: inputDateCompleted,
                      inputHours: inputHours                      
                    },
                    cache: false,
                    success: function(response){
                      
                      var nameArr = response.split(',');

                      if(nameArr[0] == "1"){
                        alert('Data added successfully !');
                        $('#primaryKey').val(nameArr[1]);
                        $('#smartwizard').smartWizard("goToStep", 2);
                        $('#butsave2').attr('disabled',true);

                        
                      }else{
                        alert(response);
                      }
                    }
              });
            }else{
              alert("Fill all required fields!!");
            }
          });

        $('#butsave3').on("click",function() {  
          
          

          var inputAssessment = $('#inputAssessment').val();
          var inputOverallRating = $('#inputOverallRating').val();
          var inputRemarks = $('#inputRemarks').val();
          var inputBranch = $('#inputBranch').val();

          var inputPrimaryKey = $('#primaryKey').val(); 
          

          if(inputAssessment != null && inputOverallRating != null && inputPrimaryKey != "" && inputBranch != null){
                $.ajax({
                    url: "add-student-query.php",
                    type: "POST",
                    datatype: "text",
                    data: {
                      inputAssessment: inputAssessment,
                      inputOverallRating: inputOverallRating,
                      inputRemarks: inputRemarks,
                      inputBranchX: inputBranch,
                      inputPrimaryKey: inputPrimaryKey                       
                    },
                    cache: false,
                    success: function(response){
                      
                      var nameArr2 = response.split(',');

                      if(nameArr2[0] == "1"){
                        alert('Data added successfully !');
                        $('#primaryKey2').val(nameArr2[1]);
                        $('#smartwizard').smartWizard("goToStep", 3);
                        $('#butsave3').attr('disabled',true);
                        take_snapshot();
                      }else{
                        alert(response);
                      }
                    }
              });
          }else{
            alert("Fill all required fields!!");
          }
        });

        $('#butsave4').on("click",function() {  
          var inputCamera = $('#inputCamera').val();
          var primary = $('#primaryKey2').val();

          if(inputCamera != "" && primary != ""){
            $.ajax({
                      url: "add-student-query.php",
                      type: "POST",
                      datatype: "text",
                      data: {
                        inputCamera: inputCamera,
                        primary: primary                     
                      },
                      cache: false,
                      success: function(response){
                        if(response == "1"){
                          alert('Data added successfully !');
                          window.open('certificate.php?'+urlencode(btoa('id='+primary)), '_blank');
                          window.location.href="student-list.php";
                        }else{
                          alert(response);
                        }
                      }
                });
          }else{
            alert("Fill all required fields!!");
          }

        });

        $('#takeUploadBtn').on("click",function() { 

            var r = confirm("Are you sure you want to upload this image");
            if (r == true) {
                document.getElementById('butsave4').disabled = false; 
            }
        });

        $('#takeCaptureBtn').on("click",function() { 
            Webcam.snap(function(data_uri){

            var letterCounter = data_uri.length;

            if(letterCounter > 1371){
              $('#inputCamera').val('');
              $('#results').attr('src','majesty-images/unknown.jpg');
              $('#results').attr('src',data_uri);
              $('#inputCamera').val(data_uri);

              document.getElementById('butsave4').disabled = false; 

            }else{
              alert("The image was blank, please try to refresh the page");
              refresher();
              
              document.getElementById('butsave4').disabled = true;

            }
          });

        });

      });


    function take_snapshot(){
      Webcam.set({
      width: 350,
      height:350,
      image_format:'jpeg',
      image_quality:2000

    })
    Webcam.attach("#camera");

    document.getElementById('butsave4').disabled = true;

    Webcam.on( 'error', function(err) {
      alert("NO CAMERA FOUND, PLEASE REFRESH AND CONNECT THE CAMERA");

      document.getElementById('takeCaptureBtn').disabled = true;
      document.getElementById('butsave4').disabled = true;
      refresher();
      
    });

    setTimeout(function(){
        document.getElementById('takeCaptureBtn').disabled = false;
      }, 3000);
    }

    function refreshes(){
      
      take_snapshot();
    }

    function refresher(){
      $("#camera").empty();
      $('<button onclick="refreshes()" class="btn btn-danger"> Please click me to refresh</button>').appendTo('#camera');
      
      $('#results').attr('src','majesty-images/unknown.jpg');
    }


  </script>
  </body>
</html>