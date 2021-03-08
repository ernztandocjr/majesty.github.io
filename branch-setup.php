<?php 
session_start();

if(!isset($_SESSION["username"]) && !isset($_SESSION["account"])){
    header("location:login.php");
  }

  if($_SESSION["account"] != "Super-Admin"){
     header("location:student-list.php"); 
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
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-building"></i> Branch Setup</h1>
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
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="nav-icon fas fa-plus"></i> Add Branch</button>
              </p>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                        <th>Action</th>
                        <th>Branch ID</th>
                        <th>Branch Name</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    include 'connection.php';

                    $sql = "SELECT * FROM tbl_branches";

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                                if($row['branchStatus'] == "Active"){
                                  echo '<td align="center"> <button type="button" onclick="viewInfo(\''.$row['branchID'].'\')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Option"><i class="nav-icon fas fa-cog"></i></button></td>';
                                }else{
                                  echo '<td align="center"> <button type="button" onclick="viewInfo2(\''.$row['branchID'].'\')" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Option"><i class="nav-icon fas fa-cog"></i></button></td>';
                                }
                                echo '<td>MajestyDS-'.substr(str_repeat(0, 3).$row['branchID'], - 3).'</td>';
                                echo '<td>'.$row['branchName'].'</td>';
                                echo '<td>'.$row['branchStatus'].'</td>';
                            echo '</tr>';
                        }
                    }
                  
                ?>
                </tbody>
              </table>
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

  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleaddModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleaddModal"><i class="nav-icon fas fa-plus"></i> Add Branch</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                  <div class="card-body">
                    <div class="form-group"> 
                      <label for="inputDLCodeID" id="textID">Branch Name</label>
                      <input type="text" class="form-control" id="inputBranch" placeholder="Enter Branch Name" required>
                    </div> 
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
            <button type="submit" id="btnBranch" class="btn btn-primary"><i class="nav-icon fas fa-plus"></i> Add Branch</button>
          </div>
        </div>
      </div>
    </div>
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
      var r = confirm("Are you sure you want to mark as Deactivate?");
      if (r == true) {

        $.ajax({
        url: "add-student-query.php",
        type: "POST",
        datatype: "text",
        data: {
          branchID: index,
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

     function viewInfo2(index){
      var act = 'Active';
      var r = confirm("Are you sure you want to mark as Active?");
      if (r == true) {

        $.ajax({
        url: "add-student-query.php",
        type: "POST",
        datatype: "text",
        data: {
          branchIDx: index,
          branchStatus: act
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
    $(document).ready(function(){
      
      $('#btnBranch').on("click",function() {
        var inputBranch = $('#inputBranch').val();
       
        if(inputBranch != ""){
          $.ajax({
                    url: "add-student-query.php",
                    type: "POST",
                    datatype: "text",
                    data: {
                      inputBranch: inputBranch
                    },
                    cache: false,
                    success: function(response){

                      if(response == "1"){
                        alert('Data added successfully !');
                        location.reload();
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