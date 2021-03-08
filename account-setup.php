<?php 
session_start();

if(!isset($_SESSION["username"]) && !isset($_SESSION["account"])){
    header("location:login.php");
  } 

  if($_SESSION["account"] != "Admin"){
    if($_SESSION["account"] != "Super-Admin"){
      header("location:student-list.php"); 
    }
  }

 ?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'head-tag.php' ?>

  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.css">
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-user-cog"></i> Account Setup</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <p>
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="nav-icon fas fa-plus"></i> Add Account</button>
              </p>
              <div id="tblResults">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                        <th>Action</th>
                        <th>ID</th>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>Account Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>              
                  
                    <?php 
                    include 'connection.php';

                    if ($_SESSION["account"] == "Admin") {
                      $sql = "SELECT * FROM tbl_instructorInfo WHERE instAccountType = 'Instructor' AND instID != '1'"; 
                    }else if ($_SESSION["account"] == "Super-Admin"){
                      $sql = "SELECT * FROM tbl_instructorInfo WHERE instID != '1' ORDER BY instAccountType DESC";
                    }

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                                 $status = $row['instStatus'];

                                 echo '<td align="center"><button type="button" data-toggle="modal" data-target="#tblModal'.$row['instID'].'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Option"><i class="nav-icon fas fa-cog"></i> </button> ';
                                    
                                    if($status == "Active" && $row['instAccountType'] == "Instructor"){
                                       echo '<button type="button" data-toggle="modal" data-target="#tblModalx'.$row['instID'].'" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Signature"><i class="nav-icon fas fa-signature"></i></button>';
                                    }

                                    if($status == "Active" && $row['instAccountType'] == "Admin"){
                                      echo '<button type="button" data-toggle="modal" data-target="#tblModaly'.$row['instID'].'" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Promote"><i class="nav-icon fas fa-level-up-alt"></i></button>';
                                    }else if ($status == "Active" && $row['instAccountType'] == "Super-Admin"){
                                      echo '<button type="button" data-toggle="modal" data-target="#tblModaly'.$row['instID'].'" class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Demote"><i class="nav-icon fas fa-level-down-alt"></i></button>'; 
                                    }
                                    echo '</td>';
                                if($row['instAccred'] == null){
                                  if($row['instAccountType'] == "Admin"){
                                    $ID = "Admin-".substr(str_repeat(0, 3).$row['instID'], - 3);
                                    echo '<td>'.$ID.'</td>';
                                  }else{
                                    $ID = "Super-Admin-".substr(str_repeat(0, 3).$row['instID'], - 3);
                                    echo '<td>'.$ID.'</td>';
                                  }
                                }else{
                                  $ID = $row['instAccred'];
                                  echo '<td>'.$ID.'</td>';
                                }

                                echo '<td>'.$row['instLastname'].', '.$row['instFirstname'].' '.$row['instMiddlename'].'</td>';
                                echo '<td>'.$row['instEmail'].'</td>';
                                echo '<td>'.$row['instAccountType'].'</td>';
                               
                                                                if($status == "Active"){
                                  echo '<td><span class="label label-success">'.$status.'</span></td>';
                                }else{
                                  echo '<td><span class="label label-danger">'.$status.'</span></td>';
                                }

                                  //Modal 1
                                echo '<div class="modal fade" id="tblModal'.$row['instID'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Action</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form-group">
                                               <label for="tblInstructor">ID</label>
                                              <input type="text" class="form-control" id="tblInstructor'.$row['instID'].'" value="'.$ID.'" disabled>
                                            </div>
                                            <div class="form-group">
                                               <label for="tblFirstname">Full Name</label>
                                              <input type="text" class="form-control" id="tblFirstname'.$row['instID'].'" value="'.$row['instLastname'].', '.$row['instFirstname'].' '.$row['instMiddlename'].'" disabled>
                                            </div> 
                                            <div class="form-group">
                                               <label for="modalFirstname">Status</label>
                                                <select class="form-control select2bs4" style="width: 100%;" id="tblAction'.$row['instID'].'">
                                                  ';
                                                    if($status == "Active"){
                                                      echo '<option value="'.$status.'" selected>Activate</option>
                                                            <option value="Deactivate">Deactivate</option>';
                                                    }else{
                                                      echo '<option value="Active">Activate</option>
                                                            <option value="'.$status.'" selected>Deactivate</option>';
                                                    }
                                   echo'
                                                </select>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>';

                                            if($status == "Active"){
                                                      echo '<button type="submit" id="btnAction'.$row['instID'].'" onclick="sample2('.$row['instID'].')" class="btn btn-success"><i class="nav-icon fas fa-sync"></i> Reset Password</button>';
                                            }
                                  echo '
                                            <button type="submit" id="btnAction'.$row['instID'].'" onclick="sample('.$row['instID'].')" class="btn btn-primary"><i class="nav-icon fas fa-edit"></i> Update</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                  <div class="modal fade" id="tblModalx'.$row['instID'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Action</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                              <div class="form-group">
                                                 <label for="tblInstructor">ID</label>
                                                <input type="text" class="form-control" id="tblInstructor'.$row['instID'].'" value="'.$ID.'" disabled>
                                              </div>
                                              <div class="form-group">
                                                 <label for="tblFirstname">Full Name</label>
                                                <input type="text" class="form-control" id="tblFirstname'.$row['instID'].'" value="'.$row['instLastname'].', '.$row['instFirstname'].' '.$row['instMiddlename'].'" disabled>
                                              </div> 
                                              <div class="form-group">
                                                  <label for="inputInstructorSignature">Signature</label>
                                                  <input type="file" accept="image/x-png" id="inputInstructorSignature'.$row['instID'].'" 
                                                  onchange="encodeImgtoBase64X(this,'.$row['instID'].')" required> 
                                                  
                                                  <img id="blah'.$row['instID'].'" src="data:image;base64,'.base64_decode($row['instSignature']).'" width="50%"/>
                                                  <input type="text" value=";base64,'.base64_decode($row['instSignature']).'" id="inputInstructorSignatureBase64'.$row['instID'].'" hidden> 
                                              </div>
                                          </div>
                                           <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
                                            <button type="submit" id="btnAction'.$row['instID'].'" onclick="sampleX('.$row['instID'].')" class="btn btn-primary"><i class="nav-icon fas fa-edit"></i> Update</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="modal fade" id="tblModaly'.$row['instID'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Action</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                              <div class="form-group">
                                                 <label for="tblInstructor">ID</label>
                                                <input type="text" class="form-control" id="tblInstructor'.$row['instID'].'" value="'.$ID.'" disabled>
                                              </div>
                                              <div class="form-group">
                                                 <label for="tblFirstname">Full Name</label>
                                                <input type="text" class="form-control" id="tblFirstname'.$row['instID'].'" value="'.$row['instLastname'].', '.$row['instFirstname'].' '.$row['instMiddlename'].'" disabled>
                                              </div>
                                              <div class="form-group">
                                                 <label for="tblStatus">Status</label>
                                                <input type="text" class="form-control" id="tblStatus'.$row['instID'].'" value="'.$row['instAccountType'].'" disabled>
                                              </div>
                                          </div>
                                           <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
                                            <button type="submit" id="btnAction'.$row['instID'].'" onclick="sampleY('.$row['instID'].')" class="btn btn-primary"><i class="nav-icon fas fa-edit"></i> Update</button>
                                          </div>
                                        </div>
                                      </div>
                                    </div>';
                                // }else{
                                //   echo '<td></td>';
                                // }

                            echo '</tr>';
                        }
                    }else{
                        echo 'No Result';
                    }

                    $conn->close();
                ?>
                  
              </tbody>
            </table>
            </div>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </div>
  <!-- /.content-wrapper -->
  <?php include 'footer.php'; ?>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleaddModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleaddModal"><i class="nav-icon fas fa-plus"></i> Add Account</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="inputAccountType">Account Type</label>
                      <select class="form-control select2bs4" style="width: 100%;" id="inputAccountType" required>
                            <option disabled value="" selected>Choose account type</option>
                            <option value="Instructor">Instructor</option>
                            
                            <?php if($_SESSION["account"] == "Super-Admin"){echo '<option value="Admin">Admin</option><option value="Super-Admin">Super-Admin</option>';}?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="inputInstructorID" id="textID">Accredited Instructor ID</label>
                      <input type="text" class="form-control" id="inputInstructorID" placeholder="Enter Instructor ID" minlength="17" maxlength="17" required disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputInstructorFirstname">First Name</label>
                      <input type="text" class="form-control" id="inputInstructorFirstname" placeholder="Enter first name" required disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputInstructorMiddlename">Middle Name</label>
                      <input type="text" class="form-control" id="inputInstructorMiddlename" placeholder="Enter middle name" required disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputInstructorLastname">Last Name</label>
                      <input type="text" class="form-control" id="inputInstructorLastname" placeholder="Enter last name" required disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputInstructorEmail">Email (for username also)</label>
                      <input type="email" class="form-control" id="inputInstructorEmail" placeholder="Enter Instructor Email" required disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputInstructorSignature" id="textSign">Signature</label>
                      <input type="file" accept="image/x-png" id="inputInstructorSignature" 
                      onchange="encodeImgtoBase64(this)" required disabled> 
                      <!-- loadFile(event) validateFileType() onchange="validateFileType()"-->
                      <img id="blah" width="50%" hidden/>
                      <input type="text" id="inputInstructorSignatureBase64" hidden>      
                    </div>                    
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
            <button type="submit" id="btnInstructor" class="btn btn-primary" disabled><i class="nav-icon fas fa-plus"></i> Add Instructor</button>
            <button type="submit" id="btnAdmin" class="btn btn-primary" disabled hidden><i class="nav-icon fas fa-plus"></i> Add Admin</button>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="modal fade" id="duplicateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong style="color:red;">Duplicate entry!!</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
           <label for="modalFirstname">Full Name</label>
          <input type="text" class="form-control" id="modalFirstname">
        </div>
        <div class="form-group">
           <label for="modalFirstname">Instructor ID</label>
          <input type="text" class="form-control" id="modalInstructor">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="duplicateModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong style="color:red;">Duplicate entry!!</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
           <label for="modalFirstname">Full Name</label>
          <input type="text" class="form-control" id="modalFirstname2">
        </div>
        <div class="form-group">
           <label for="modalFirstname">Email</label>
          <input type="text" class="form-control" id="modalInstructor2">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
      </div>
    </div>
  </div>
</div>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
  <?php include 'script.php';  ?>
  <script>
    var loadFile = function(event) {
    var output = document.getElementById('blah');
      $('#blah').attr('hidden',false);
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
    };

    function validateFileType(){
        var fileName = document.getElementById("inputInstructorSignature").value;
        var fileSize = document.getElementById('inputInstructorSignature').files[0].size

        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="png"){
            //TO DO
          
          const file = Math.round((fileSize / 1024)); 
          //alert(file);
          if(file >= 64){
            alert("File too Big, please select a file less than 64kb");
            $('#blah').attr('hidden',true);
            document.getElementById('inputInstructorSignature').value= null;
          }else{
            loadFile(event);
            encodeImgtoBase64(fileName);
          }         
        }else{
            alert("Only png files are allowed!");
            document.getElementById('inputInstructorSignature').value= null;
            $('#blah').attr('hidden',true);
        }   
    }

    function encodeImgtoBase64(element) {
 
      var img = element.files[0];
 
      var reader = new FileReader();
 
      reader.onloadend = function() {
        
        $("#inputInstructorSignatureBase64").attr('value',reader.result);

      }
      reader.readAsDataURL(img);
      validateFileType();
    }

    var loadFileX = function(event,id) {
    var output = document.getElementById('blah'+id);
      
      output.src = URL.createObjectURL(event.target.files[0]);
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
    };

    function validateFileTypeX(id){
        var fileName = document.getElementById("inputInstructorSignature"+id).value;
        var fileSize = document.getElementById('inputInstructorSignature'+id).files[0].size

        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();


        if (extFile=="png"){
            //TO DO
          
          const file = Math.round((fileSize / 1024)); 
          
          if(file >= 64){
            alert("File too Big, please select a file less than 64kb");
            $('#blah').attr('hidden',true);
            document.getElementById('inputInstructorSignature'+id).value= null;
          }else{
            loadFileX(event,id);
            encodeImgtoBase64X(fileName,id);
          }         
        }else{
            alert("Only png files are allowed!");
            document.getElementById('inputInstructorSignature'+id).value= null;
            $('#blah').attr('hidden',true);
        }   
    }

    function encodeImgtoBase64X(element,id) {
      
      var img = element.files[0];
 
      var reader = new FileReader();
 
      reader.onloadend = function() {
        
        $("#inputInstructorSignatureBase64"+id).attr('value',reader.result);

      }
      reader.readAsDataURL(img);
      validateFileTypeX(id);
    }

    function sample(haha,hehe){
      
      var tblID = haha;
      var tblAccredd = $('#tblInstructor'+haha).val();
      var tblAction = $('#tblAction'+haha).val();

      var r = confirm("Are you sure you want to " + tblAction + " the status of " +tblAccredd);
      if (r == true) {
        $.ajax({
          url: "add-student-query.php",
          type: "POST",
          datatype: "text",
          data: {
            tblID: tblID,
            tblAction: tblAction,
            tblAccredd: tblAccredd,
          },
          cache: false,
          success: function(response){
            if(response == "1"){
              alert('Updated successfully !');
                           
              location.reload();

            }else{
              alert(response);
            }
          }
        });
      }
    }

    function sampleX(haha){
      
      var tblID2x = haha;
      var tblAccreddx = $('#tblInstructor'+haha).val();
      var tblSignature = $('#inputInstructorSignatureBase64'+haha).val();

      var r = confirm("Are you sure you want to update the signature of "+ tblAccreddx);
      if (r == true) {
        $.ajax({
          url: "add-student-query.php",
          type: "POST",
          datatype: "text",
          data: {
            tblID2x: tblID2x,
            tblAccreddx: tblAccreddx,
            tblSignature: tblSignature,
          },
          cache: false,
          success: function(response){
            if(response == "1"){
              alert('Signature updated !');
                           
              location.reload();

            }else{
              alert(response);
            }
          }
        });
      } 
    }

    function sampleY(haha){
      
      var tblID2y = haha;
      var tblAccreddy = $('#tblInstructor'+haha).val();
      var tblAccountType = $('#tblStatus'+haha).val();

      var tblAccountType2 = "";
      var tblstate = "";
      if(tblAccountType == "Admin"){
        tblAccountType2 = "Super-Admin";
        tblstate = "Promote";
      }else if(tblAccountType == "Super-Admin"){
        tblAccountType2 = "Admin";
        tblstate = "Demote";
      }

      var r = confirm("Are you sure you want to "+ tblstate +" this ID: "+ tblAccreddy);
      if (r == true) {
        $.ajax({
          url: "add-student-query.php",
          type: "POST",
          datatype: "text",
          data: {
            tblID2y: tblID2y,
            tblAccreddy: tblAccreddy,
            tblAccountType2: tblAccountType2,
          },
          cache: false,
          success: function(response){
            if(response == "1"){
              alert('Account updated !');
                           
              location.reload();

            }else{
              alert(response);
            }
          }
        });
      } 
    }

    function sample2(haha){
      
      var tblID2 = haha;
      var tblAccredd = $('#tblInstructor'+haha).val();

      var r = confirm("Are you sure you want to reset the password of "+ tblAccredd);
      if (r == true) {
        $.ajax({
          url: "add-student-query.php",
          type: "POST",
          datatype: "text",
          data: {
            tblID2: tblID2,
            tblAccredd: tblAccredd,
          },
          cache: false,
          success: function(response){
            if(response == "1"){
              alert('Password has been reset !');
                           
              location.reload();

            }else{
              alert(response);
            }
          }
        });
      } 
    }
    
    $(document).ready(function(){
      $("#inputAccountType").on('change',function(){
        var haha = $('#inputAccountType option:selected').val();
        
        if(haha == "Admin" || haha == "Super-Admin"){
          $('#inputInstructorID').attr('hidden',true);
          $('#inputInstructorSignature').attr('hidden',true);
          $('#textID').attr('hidden',true);
          $('#textSign').attr('hidden',true);
          $('#inputInstructorEmail').attr('placeholder','Enter '+haha+' Email');
          $('#btnAdmin').attr('hidden',false);
          $('#btnInstructor').attr('hidden',true);
          $('#blah').attr('hidden',true);

          $(":input").prop("disabled", false);
          $(":button").prop("disabled", false);

        }else{
          $('#inputInstructorID').attr('hidden',false);
          $('#inputInstructorSignature').attr('hidden',false);
          $('#textID').attr('hidden',false);
          $('#textSign').attr('hidden',false);
          $('#inputInstructorEmail').attr('placeholder','Enter '+haha+' Email');
          $('#btnAdmin').attr('hidden',true);
          $('#btnInstructor').attr('hidden',false);
          $('#inputInstructorSignatureBase64').attr('value','');

          $(":input").prop("disabled", false);
          $(":button").prop("disabled", false);
          $('#blah').attr('hidden',true);
        }
        
        });

      var mailformat = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/; 

      $('#btnAdmin').on("click",function() {         
        var inputAccountType = $('#inputAccountType').val();
        var inputInstructorFirstname = $('#inputInstructorFirstname').val();
        var inputInstructorMiddlename = $('#inputInstructorMiddlename').val();
        var inputInstructorLastname = $('#inputInstructorLastname').val();
        var inputInstructorEmail = $('#inputInstructorEmail').val();

        if(!inputInstructorEmail.match(mailformat)){
          alert("Invalid email address!");
        }else if(inputAccountType !="" && inputInstructorFirstname !="" && inputInstructorMiddlename !="" && inputInstructorLastname !="" && inputInstructorEmail !=""){
          
          $.ajax({
                    url: "add-student-query.php",
                    type: "POST",
                    datatype: "text",
                    data: {
                      inputAccountType2: inputAccountType,
                      inputInstructorFirstname2: inputInstructorFirstname,
                      inputInstructorMiddlename2: inputInstructorMiddlename,
                      inputInstructorLastname2: inputInstructorLastname,
                      inputInstructorEmail2: inputInstructorEmail,
                    },
                    cache: false,
                    success: function(response){
                      if(response == "1"){
                        alert('Data added successfully !');
                         
                        location.reload();

                      }else if(response.length > 4){
                        var res = response.split(',');

                        $('#modalFirstname2').attr('value',res[1]+" "+res[2]+" "+res[3]).attr('disabled',true);
                        $('#modalInstructor2').attr('value',res[0]).attr('disabled',true);
                        $('#duplicateModal2').modal({show:true});
                        
                      }else{
                        alert(response);
                      }
                    }
              });
        }else{
          alert("Fill all required fields!!");
        }
        
      });

      $('#btnInstructor').on("click",function() { 
        var inputAccountType = $('#inputAccountType').val();
        var inputInstructorID = $('#inputInstructorID').val();
        var inputInstructorFirstname = $('#inputInstructorFirstname').val();
        var inputInstructorMiddlename = $('#inputInstructorMiddlename').val();
        var inputInstructorLastname = $('#inputInstructorLastname').val();
        var inputInstructorEmail = $('#inputInstructorEmail').val();
        var inputInstructorSignatureBase64 = $('#inputInstructorSignatureBase64').val();

        if(inputInstructorID.length < 17){
          alert("Length of Instructor ID was not meet the requirement!");
        }else if(!inputInstructorEmail.match(mailformat)){
          alert("Invalid email address!");
        }else if(inputAccountType !="" && inputInstructorID !="" && inputInstructorFirstname !="" && inputInstructorMiddlename !="" && inputInstructorLastname !="" && inputInstructorEmail !="" && inputInstructorSignatureBase64 !=""){
          
          $.ajax({
                    url: "add-student-query.php",
                    type: "POST",
                    datatype: "text",
                    data: {
                      inputAccountType: inputAccountType,
                      inputInstructorID: inputInstructorID,
                      inputInstructorFirstname: inputInstructorFirstname,
                      inputInstructorMiddlename: inputInstructorMiddlename,
                      inputInstructorLastname: inputInstructorLastname,
                      inputInstructorEmail: inputInstructorEmail,
                      inputInstructorSignatureBase64: inputInstructorSignatureBase64,
                    },
                    cache: false,
                    success: function(response){
                      if(response == "1"){
                        alert('Data added successfully !');
                         
                         location.reload();

                      }else if(response.length > 4){
                        var res = response.split(',');

                        $('#modalFirstname').attr('value',res[1]+" "+res[2]+" "+res[3]).attr('disabled',true);
                        $('#modalInstructor').attr('value',res[0]).attr('disabled',true);
                        $('#duplicateModal').modal({show:true});
                        
                      }else{
                        alert(response);
                      }
                    }
              });

        }else{
          alert("Fill all required fields!!");
        }

      });
    });

  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
  });
</script>
</body>
</html>