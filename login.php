<?php 
  session_start();

  if(isset($_SESSION["username"]) && isset($_SESSION["account"])){
    header("location:dashboard.php");
  }
?>

<!DOCTYPE html>
<html>
<head>
  <?php include 'head-tag.php' ?>
</head>
<body class="hold-transition login-page">
<div class="login-box">

  <div class="login-logo">
    <a href="index.php"><img src="majesty-images/majesty-logo.png" class="img-fluid max-width: 100%; height: auto;"></a>
  </div>
  <h3 align="center">Majesty Driving School Encoding and Certification System</h3>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>
        <div class="input-group mb-3">
          <input type="text" id="txtUsername" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" id="txtPassword" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12" id="error"></div>
          <div class="col-8">
            
            <a href="#" onclick="alert('Please contact the Administrator');">I forgot my password</a>
            <br>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" id="btnLogin" class="btn btn-primary btn-block"> Log in</button>
          </div>
          
          <!-- /.col -->
        </div>
      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
<?php include 'script.php';  ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#btnLogin').click(function(){
      var username = $('#txtUsername').val();
      var password = $('#txtPassword').val();
        $.ajax({
            url: "add-student-query.php",
            method: "POST",
            datatype: "text",
            data: {
              username: username,
              password: password
            },
            cache: false,
            success: function(response){
              if(response == "OK"){
                alert("Log in Successful");
                window.location.href="dashboard.php";
              }else if(response == "CP"){
                alert("Log in Successful");
                window.location.href="profile.php";
              }else if(response == "CA"){
                $("#error").css('display', 'inline', 'important');
                $("#error").html("<font color='red'>Your account was Deactivated, Please contact the Administrator</font>");
              }else{
                alert("Log in failed");
                $('#txtPassword').val('');
                $("#error").css('display', 'inline', 'important');
                $("#error").html("<p style='color:red;'>Wrong username or password!</p>");
              }
            }
        });
    });

  });

</script>

</body>
</html>
