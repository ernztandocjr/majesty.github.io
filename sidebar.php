<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="dist/img/AdminLTELogo.png" alt="majesty-logo" class="brand-image img-circle"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Majesty DS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
           <?php

          if($_SESSION["account"] == "Admin" || $_SESSION["account"] == "Super-Admin"){
            echo '<li class="nav-item">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>';
          }
          ?>

          <li class="nav-item">
            <a href="student-list.php" class="nav-link">
              <i class="nav-icon fas fa-user-graduate"></i>
                <p>
                  Student List
                </p>
            </a>
          </li>

          <?php 

        include 'connection.php';
        $sql = "SELECT contactStatus FROM tbl_contactUS WHERE contactStatus='Active'";

        $result = mysqli_query($conn, $sql);
        $output = mysqli_num_rows($result);


          if($_SESSION["account"] == "Super-Admin"){
            echo '
                
                <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-user-cog"></i>
                  <p>
                    Set-up
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="account-setup.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Account Setup
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="dlcodes-setup.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        DL Codes Setup
                      </p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="branch-setup.php" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>
                        Branches Setup
                      </p>
                    </a>
                  </li>
                </ul>
               </li>
               <li class="nav-item">
                  <a href="contact.php" class="nav-link">
                    <i class="nav-icon fas fa-comment-dots"></i>
                    <p>
                      Contact Us 
                      <span class="right badge badge-danger">'.$output.'</span>
                    </p>
                  </a>
                </li>
            ';
          }?>


          <?php if($_SESSION["account"] == "Admin"){
            echo '
                <li class="nav-item">
                  <a href="account-setup.php" class="nav-link">
                    <i class="nav-icon fas fa-user-cog"></i>
                    <p>
                      Account Setup
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="contact.php" class="nav-link">
                    <i class="nav-icon fas fa-comment-dots"></i>
                    <p>
                      Contact Us <span class="badge badge-pill badge-danger">'.$output.'</span>
                    </p>
                  </a>
                </li>
                
            ';
          }?>

          <li class="nav-header">REPORTS</li>
          <li class="nav-item">
                  <a href="#" class="nav-link" data-toggle="modal" data-target="#reportModal">
                    <i class="nav-icon fas fa-file"></i>
                    <p>
                      Excel File
                    </p>
                  </a>
                </li>

          <?php if($_SESSION["account"] == "Super-Admin"){
            echo '<li class="nav-item">
                  <a href="activity.php" class="nav-link">
                    <i class="nav-icon fas fa-list"></i>
                    <p>
                      Activity Logs
                    </p>
                  </a>
                </li>';
          }?>

                
                 
                <li class="nav-header">MISCELLANEOUS</li>
                <li class="nav-item">
                  <a href="profile.php" class="nav-link">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                      Profile
                    </p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="index.php" class="nav-link" data-toggle="modal" data-target="#logoutModal">
                    <i class="nav-icon fas fa-sign-out-alt"></i>
                    <p>
                      Log out
                    </p>
                  </a>
                </li>
         

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><strong style="color:red;">Alert Message!!!</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure that you want to log out???
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
        <a href="logout.php"><button type="button" class="btn btn-primary"><i class="nav-icon fas fa-sign-out-alt"></i> Log out</button></a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Generate Student excel file for STRADCOM System</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" action="add-student-query.php">
      <div class="modal-body">
        <div class="form-group">
          <label for="inputDateReport">Date</label>
          <input type="date" name="date" class="form-control" id="inputDateReport" onkeydown="return false">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
        <button type="submit" name="export" id="btnReport" class="btn btn-primary"><i class="nav-icon fas fa-file"></i> Generate</button></form>
      </div>
    </div>
  </div>
</div>
<?php include 'script.php';  ?>
<script type="text/javascript">
  $(document).ready(function(){

    var dtTodayX = new Date();
    var monthX = dtTodayX.getMonth() + 1;     
    var dayX = dtTodayX.getDate();
    var yearX = dtTodayX.getFullYear();
    if(monthX < 10)
      monthX = '0' + monthX.toString();
    if(dayX < 10)
      dayX = '0' + dayX.toString();
              
    var maxDateX = yearX + '-' + monthX + '-' + dayX;
    $('#inputDateReport').attr('max', maxDateX);

  });
</script>