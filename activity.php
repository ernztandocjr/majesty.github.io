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
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-list"></i> Activity Logs</h1>
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
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                        <th>Action</th>
                        <th>Account ID</th>
                        <th>Actions</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    include 'connection.php';

                    $sql = "SELECT * FROM tbl_activityLogs ORDER BY actID DESC";

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                                echo '<td align="center"> <button type="button" onclick="viewInfo(\''.$row['actAccountID'].'\')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="View"><i class="nav-icon fas fa-eye"></i></button></td>';
                                echo '<td>'.$row['actAccountID'].'</td>';
                                echo '<td>'.$row['actActions'].'</td>';
                                echo '<td>'.$row['actDate'].'</td>';
                                echo '<td>'.$row['actTime'].'</td>';
                            echo '</tr>';
                        }
                    }
                  
                ?>
                </tbody>
              </table>

              <div class="modal fade" id="tblModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>View</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form-group">
                                               <label for="tblInstructor">Account ID</label>
                                               <input type="text" id="tblInstructor" class="form-control" disabled>
                                            </div>
                                            <div class="form-group">
                                               <label for="tblFirstname">Full Name</label>
                                              <input type="text" id="tblFirstname" class="form-control" disabled>
                                            </div> 
                                            <div class="form-group">
                                               <label for="tblEmail">Email</label>
                                              <input type="text" id="tblEmail" class="form-control" disabled>
                                            </div> 
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
                                          </div>
                                        </div>
                                      </div>
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
    function viewInfo(index){
      //alert(index);
      var id = index;
      var action = "View";
     
      $.ajax({
        url: "add-student-query.php",
        type: "POST",
        datatype: "text",
        data: {
          id: id,
          action: action,
        },
          cache: false,
          success: function(response){
            if(response.length >= 4){
              var res = response.split(',');

              $('#tblInstructor').attr('value',id).attr('disabled',true);
              $('#tblFirstname').attr('value',res[0]+", "+res[1]+" "+res[2]).attr('disabled',true);
              $('#tblEmail').attr('value',res[3]).attr('disabled',true);
              $('#tblModal').modal({show:true});
              
            }else{
              alert(response);
            }
          }
        });
     }
  </script>
  <script>
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