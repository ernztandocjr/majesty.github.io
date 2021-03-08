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
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-comment-dots"></i> Contact Us</h1>
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
              <div id="tblResults">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Contact Number</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>              
                  
                    <?php 
                    include 'connection.php';

                    $sql = "SELECT * FROM tbl_contactUS ORDER BY contactStatus ASC";
                    

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                                $status = $row['contactStatus'];

                                if($status == "Active"){
                                    echo '<td align="center"><button class="btn btn-primary" onclick="viewInfo(\''.$row['contactID'].'\')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Option"><i class="nav-icon fas fa-cog"></i> </button></td>';
                                }else{
                                  echo '<td align="center"><button class="btn btn-primary"data-toggle="modal" data-target="#tblModal'.$row['contactID'].'" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Option" disabled><i class="nav-icon fas fa-cog"></i> </button></td>';
                                }
                                echo '<td>'.$row['contactName'].'</td>';
                                echo '<td>'.$row['contactNumber'].'</td>';
                                echo '<td>'.$row['contactEmail'].'</td>';
                                echo '<td>'.$row['contactMessage'].'</td>';
                                echo '<td>'.$status.'</td>';
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
      var r = confirm("Are you sure you want to mark as Solved?");
      if (r == true) {
        //alert(index);
        $.ajax({
        url: "add-student-query.php",
        type: "POST",
        datatype: "text",
        data: {
          contactID: index,
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
  </script>

<script type="text/javascript">
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