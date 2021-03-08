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
    <section class="content-header">
      <div class="container-fluid"> 
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-user-graduate"></i> Student List</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
              <?php 
              if ($_SESSION["account"] == "Instructor") {
                echo '
                  <p>
                    <a href="add-student.php"><button class="btn btn-primary"><i class="nav-icon fas fa-plus"></i> Add Student</button></a>
                  </p>
                ';
              }
               ?>

              
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Action</th>
                  <th>Full Name</th>
                  <th>Driver's Licence</th>
                  <th>Date Certified</th>
                  <!-- <th>Status</th> -->
                </tr>
                </thead>
                <tbody>
                  <?php 
                    include 'connection.php';
                    
                    $sql = "SELECT * FROM tbl_studentInfo WHERE studStatus = 'Certified' ORDER BY studID DESC";

                   

                      $result = mysqli_query($conn, $sql);
                    
                      $count=0;
                      if(mysqli_num_rows($result) > 0){
                          while ($row = mysqli_fetch_assoc($result)) {
                              echo '<tr>';
                                $sql2 = "SELECT trainCount,trainDLNo FROM tbl_trainingInfo WHERE trainStudentID = ".$row['studID'];

                                $result2 = mysqli_query($conn, $sql2);

                                 $row2 = mysqli_fetch_assoc($result2);

                               
                                  echo '<td align="center"><a href="certificate.php?'.urlencode( base64_encode('id='.$row['studID'].'&print=yes')).'" data-toggle="tooltip" data-placement="top" title="Re-print" target="_blank"><button type="button" class="btn btn-success"><i class="nav-icon fas fa-print"></i></button></a> ';

                                    

                                    if ($_SESSION["account"] == "Instructor"){
                                      

                                      echo '<button type="button" onclick="viewInfo2(\''.$row['studID'].'\')" data-toggle="tooltip" data-placement="top" title="Edit" class="btn btn-warning"><i class="nav-icon fas fa-list-alt"></i></button>&nbsp;';

                                      echo '<button type="button" onclick="viewInfo(\''.$row['studID'].'\')" data-toggle="tooltip" data-placement="top" title="Duplicate" class="btn btn-primary"><i class="nav-icon fa fa-file"></i></button>';

                                    

                                  
                                } echo '</td>';

                                echo '<td>'.$row['studLastname'].', '.$row['studFirstname'].' '.$row['studMiddlename'].'</td>';
                                
                                $DLNo = $row2['trainDLNo'];
                                if($DLNo == null || $DLNo == ""){
                                  echo '<td>N\A</td>';
                                }else{
                                  echo '<td>'.$row2['trainDLNo'].'</td>';
                                }
                                $certDate = $row['studDateCertified'];
                                echo '<td>'.date('F d, Y', strtotime($certDate)).' at '.date('h:i:s A', strtotime($certDate)).'</td>';

                                
                                  $count=0;
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
    <!-- /.content -->
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
<!-- page script -->
<script type="text/javascript">
    function viewInfo(index){
      var id = index;
      var r = confirm("Are you sure you want to duplicate this entry??");
      if (r == true) {
         $.ajax({
            url: "add-student-query.php",
            type: "POST",
            datatype: "text",
            data: {
              inputDuplicate: id,
            },
            cache: false,
            success: function(response){

              var nameArr = response.split('^');

              if(nameArr[0] > 1){                
                alert('Duplicate successfully !');
                
                window.open('add-student2.php?'+urlencode(btoa('id='+response+'&step=1')));

              }else{
                alert(response);
              }
            }
          });
      }
     }

     function viewInfo2(index){
      var id = index;
      var r = confirm("Are you sure you want to edit this entry??");


      var response = index+"^"+'';
      if (r == true) {
        window.open('add-student2.php?'+urlencode(btoa('id='+response+'&step=5')));
        
       }
     }

  </script>
<script>

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