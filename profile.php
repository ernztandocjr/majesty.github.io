<?php 
session_start();

if(!isset($_SESSION["username"]) && !isset($_SESSION["account"])){
    header("location:login.php");
  } 
  
 ?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'head-tag.php' ?>
  <style type="text/css">
    .password-strength-indicator{
      font-size: 12px;
      display: inline-block;
      height: 20px;
      min-width: 20%;
      text-align: center;
      font-weight: bold;
      transition: 1s;
      color: #000;
    }

    .password-strength-indicator.very-weak{
      background: #cf0000;
      width: 20%;
    }
    .password-strength-indicator.weak{
      background: #f6891f;
      width: 40%;
    }
    .password-strength-indicator.mediocre{
      background: #eeee00;
      width: 60%;
    }
    .password-strength-indicator.strong{
      background: #99ff33;
      width: 80%;
    }
    .password-strength-indicator.very-strong{
      background: #22cf00;
      width: 100%;
    }

    .sample {
      position: relative;
      text-align: center;
      color: black;
    }

    .bottom-right {
      position: absolute;
      bottom: 2px;
      right: 10px;
      cursor: pointer;
    }
  </style>
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
    <br>
    <!-- /.content-header -->
    <section class="content">
      <div class="row">
        <div class="col-12">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-info">
                <h3 class="widget-user-username"><?php echo $name.' '.$name2.' '.$name3;?></h3>
                <h5 class="widget-user-desc"><?php echo $account;?></h5>
              </div>
              <div class="widget-user-image sample">
                <?php if($img != ""){
                        echo '<img src="data:image;base64,'.base64_decode($img).'" id="blah" class="img-circle elevation-2" alt="User Avatar">';
                       }else{
                        echo '<img src="majesty-images/unknown-user.jpg" id="blah" class="img-circle elevation-2" alt="User Avatar">';
                       }
                 ?>
                  <div class="bottom-right">
                      <i class="nav-icon fas fa-edit" id="changePicture"></i>
                      <input type="file" accept="image/x-png|jpg" id="openFile" hidden /> 
                      <input type="text" id="resultPicture" hidden> 

                      
                  </div>
              </div>
              
              
              <!-- /.card-header -->
              <div class="card-body" id="hehe">
                    <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1">
                        <h3>Account Profile</h3>
                            <div class="form-group">
                              <input type="hidden" id="accountID" value="<?php echo $id;?>">
                              <label for="inputFirstname">Account ID</label>
                              <input type="text" value="<?php 

                              if($accredd != null){ 
                                  echo $accredd;
                              }else{
                                  echo $_SESSION["account"].'-'.substr(str_repeat(0, 3).$id, - 3);
                              }
                              ?>" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                              <label for="inputFirstname">Email</label>
                              <input type="text" value="<?php echo $email;?>" class="form-control" disabled>
                            </div>
                            <div class="form-group">
                              <label for="inputFirstname">Old Password</label>
                              <input type="password" id="oldPass" class="form-control" >
                            </div>
                            <div class="form-group">
                              <label for="inputMiddlename">New Password</label>
                              <input type="password" id="newPass" class="form-control">
                            </div>
                            <div class="form-group">
                              <label for="inputLastname">Confirm Password</label>
                              <input type="password" id="conPass" class="form-control" >
                              <div class="col-12" id="error"></div>
                            </div>
                            
                            <button class="btn btn-primary container-fluid" id="changePass"><i class="nav-icon fas fa-edit"></i> Update</button>
                    </div>
                  </div>
                  <!-- /.col -->
                </div>
            <!-- /.widget-user -->
          </div>
      </div>
    </section>

  </div>
  <!-- /.content-wrapper -->
  <?php include 'footer.php'; ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
  <?php include 'script.php';  ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $("#newPass").passwordStrength();

      $("#changePicture").on('click',function(){
        $("#openFile").trigger("click");
      });

      $("#openFile").on('change',function(){
          var img = document.getElementById('openFile').files[0];

          var reader = new FileReader();
     
          reader.onloadend = function() {
            
            $("#resultPicture").attr('value',reader.result);

          }
          reader.readAsDataURL(img);
          
          validatePicture();

      });

      var loadFile = function(event) {
        var output = document.getElementById('blah');
          
          output.src = URL.createObjectURL(event.target.files[0]);
          output.onload = function() {
            URL.revokeObjectURL(output.src)
          }
        };

      function validatePicture(){
        var fileName = document.getElementById("openFile").value;
        var fileSize = document.getElementById('openFile').files[0].size

        var idxDot = fileName.lastIndexOf(".") + 1;
        var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
        if (extFile=="png" || extFile=="jpg"){
          const file = Math.round((fileSize / 1024)); 
          
          if(file >= 64){
            alert("File too Big, please select a file less than 64kb");
            $('#blah').attr('src','majesty-images/unknown-user.jpg');
            document.getElementById('openFile').value= null;
          }else{
            loadFile(event);

            setTimeout(function() 
              {
                savePicture();
              }, 1000);
          }
        }
      }

      function savePicture(){
        var accountID = $('#accountID').val();
            var picture = $('#resultPicture').val();

            var r = confirm("Are you sure you want to change your profile picture??");
            if (r == true) {
              $.ajax({
                url: "add-student-query.php",
                type: "POST",
                datatype: "text",
                data: {
                  accountID: accountID,
                  picture: picture,
                },
                cache: false,
                success: function(response){
                  if(response == "1"){
                    alert('Picture has been changed !');
                                 
                    location.reload();
                  }else{
                    alert(response);
                  }
                }
              });
            }else{
              location.reload();
            }
      }


      $("#changePass").on('click',function(){
          var accountID = $('#accountID').val();
          var oldPass = $('#oldPass').val();
          var newPass = $('#newPass').val();
          var conPass = $('#conPass').val();

          if(newPass.length > 14){
            if(newPass != conPass){
              $("#error").css('display', 'inline', 'important');
              $("#error").html("<font color='red'>Please make sure your password match</font>");
            }else{  
              $.ajax({
                  url: "add-student-query.php",
                  method: "POST",
                  datatype: "text",
                  data: {
                    accountID: accountID,
                    oldPass: oldPass,
                    newPass: newPass
                  },
                  cache: false,
                  success: function(response){
                    if(response == "1"){
                      alert("Change password successful");
                      alert("You need to log in again");

                      window.location.href="logout.php";
                    }else if(response == "2"){
                      alert("Existing password didn't match with your Old password!!");
                      $('#oldPass').val('');
                    }else{
                      alert(response);
                    }
                  }
              });
            }
          }else{
            alert('New Password strength atleast at STRONG level');
          }
      });
      
  });
  </script>
      }
</body>
</html>