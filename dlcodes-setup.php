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
            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-car"></i> DL Codes Setup</h1>
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
                <button class="btn btn-primary" data-toggle="modal" data-target="#addModal"><i class="nav-icon fas fa-plus"></i> Add DL Codes</button>
              </p>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                        <th>Action</th>
                        <th>DL ID</th>
                        <th>DL Description</th>
                        <th>Sub-DL ID</th>
                        <th>Sub-DL Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    include 'connection.php';

                    $sql = "SELECT * FROM tbl_dlCodes ORDER BY dlCodeStatus";

                    $result = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($result) > 0){
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                              if($row['dlCodeStatus'] == "Active"){
                                  echo '<td align="center"> <button type="button" onclick="viewInfo(\''.$row['dlCodeID'].'\')" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Option"><i class="nav-icon fas fa-cog"></i></button></td>';
                                }else{
                                  echo '<td align="center"> <button type="button" onclick="viewInfo2(\''.$row['dlCodeID'].'\')" class="btn btn-warning" data-toggle="tooltip" data-placement="top" title="Option"><i class="nav-icon fas fa-cog"></i></button></td>';
                                }
                                
                                echo '<td>'.$row['dlCodeName'].'</td>';
                                echo '<td>'.$row['dlCodeDesc'].'</td>';
                                echo '<td>'.$row['dlCodeSubName'].'</td>';
                                echo '<td>'.$row['dlCodeSubDesc'].'</td>';
                                echo '<td>'.$row['dlCodeStatus'].'</td>';
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
            <h5 class="modal-title" id="exampleaddModal"><i class="nav-icon fas fa-plus"></i> Add DL Codes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
                  <div class="card-body">
                    <div class="form-group">
                      <label for="inputAccountType">DL Code Name</label>&nbsp;&nbsp;<input type="checkbox" id="checkbox"><span><i>&nbsp;&nbsp;(check if new DL codes)</i></span>
                      <select class="form-control select2bs4" style="width: 100%;" id="inputDLCodeName" required>
                            <option disabled value="" selected>Choose DL Code name</option>
                            <?php 
                              include 'connection.php';

                              $sql = "SELECT dlCodeName,dlCodeDesc FROM tbl_dlCodes WHERE dlCodeStatus = 'Active' GROUP BY dlCodeDesc ORDER BY dlCodeName ASC";

                              $result = mysqli_query($conn, $sql);

                              if(mysqli_num_rows($result) > 0){
                                while ($row = mysqli_fetch_assoc($result)) {
                                  echo '<option value="'.$row['dlCodeName'].'-'.$row['dlCodeDesc'].'">'.$row['dlCodeName'].'-'.$row['dlCodeDesc'].'</option>';
                                }
                              }
                          ?>
                      </select>
                      <input type="text" id="newDL" class="form-control" value="NEW DL CODES" disabled hidden>
                    </div>
                    <div class="form-group" id="dl1" hidden> 
                      <label for="inputDLCodeID" id="textID">DL Code ID</label>
                      <input type="text" class="form-control" id="inputDLCodeID" placeholder="Enter DL Code ID" minlength="3" maxlength="3" required>
                      
                    </div>
                    <div class="form-group" id="dl2" hidden>
                      <label for="inputDLCodeDesc">DL Code Description</label>
                      <input type="text" class="form-control" id="inputDLCodeDesc" placeholder="Enter DL Code Description" required>
                      
                    </div>
                    <div class="form-group">
                      <label for="inputSubDLCodeID">Sub-DL Code ID</label>
                      <input type="text" class="form-control" minlength="3" maxlength="3" id="inputSubDLCodeID" placeholder="Enter Sub-DL Code Description" required disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputSubDLCodeDesc">Sub-DL Code Desctiption</label>
                      <input type="text" class="form-control" id="inputSubDLCodeDesc" placeholder="Enter Sub-DL Code Description" required disabled>
                    </div>
                    <div class="form-group">
                      <label for="inputAccountType">License Type</label>
                      <select class="form-control select2bs4" style="width: 100%;" id="inputLicenceType" required>
                            <option disabled value="" selected>Choose License Type</option>
                            <option value="NPL-PL">Both NPL and PL</option>
                            <option value="NPL-">Non-Professional License</option>
                            <option value="-PL">Professional License</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="inputAccountType">Transmission Type</label>
                      <select class="form-control select2bs4" style="width: 100%;" id="inputTransmissionType" required>
                            <option disabled value="" selected>Choose Transmission Type</option>
                            <option value="AT-MT">Both AT and MT</option>
                            <option value="AT-">Automatic</option>
                            <option value="-MT">Manual</option>
                      </select>
                    </div>     
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="nav-icon fas fa-times"></i> Cancel</button>
            <button type="submit" id="btnDLCodes" class="btn btn-primary"><i class="nav-icon fas fa-plus"></i> Add DL Codes</button>
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
        //alert(index);
        $.ajax({
        url: "add-student-query.php",
        type: "POST",
        datatype: "text",
        data: {
          dlcodeID: index,
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
        //alert(index);
        $.ajax({
        url: "add-student-query.php",
        type: "POST",
        datatype: "text",
        data: {
          dlcodeIDx: index,
          dlCodeStatus: act,
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
      $('#checkbox').on("click",function(){
            if($(this).is(":checked")){
                 $('#inputDLCodeName').attr('hidden', true);
                 $('#newDL').attr('hidden', false);

                 $('#dl1').attr('hidden', false);
                 $('#dl2').attr('hidden', false);

                 $('#inputSubDLCodeID').val('');
                 $('#inputSubDLCodeDesc').val('');

                 $('#inputDLCodeName').val('');
                  $('#inputLicenceType').val('');
                  $('#inputTransmissionType').val('');

                 $('#inputSubDLCodeID').attr('disabled', false);
                 $('#inputSubDLCodeDesc').attr('disabled', false);


                 $('#inputDLCodeID').val('');
                $('#inputDLCodeDesc').val('');

              }
              else if($(this).is(":not(:checked)")){
                  $('#inputDLCodeName').attr('hidden', false); 
                  $('#newDL').attr('hidden', true);

                  $('#inputDLCodeID').val('');
                  $('#inputDLCodeDesc').val('');
                  $('#inputSubDLCodeID').val('');
                  $('#inputSubDLCodeDesc').val('');

                  $('#dl1').attr('hidden', true);
                  $('#dl2').attr('hidden', true);

                  $('#inputDLCodeName').val('');
                  $('#inputLicenceType').val('');
                  $('#inputTransmissionType').val('');

                  $('#inputSubDLCodeID').attr('disabled', true);
                  $('#inputSubDLCodeDesc').attr('disabled', true);
              }
          });

      $("#inputDLCodeName").on('change',function(){
        var haha = $('#inputDLCodeName option:selected').val();
        
        var res = haha.split('-');

        $('#inputDLCodeID').val(res[0]);
        $('#inputDLCodeDesc').val(res[1]);

        $('#inputSubDLCodeID').attr('disabled', false);
        $('#inputSubDLCodeDesc').attr('disabled', false);
      });


      $('#btnDLCodes').on("click",function() {
        var inputDLCodeID = $('#inputDLCodeID').val();
        var inputDLCodeDesc = $('#inputDLCodeDesc').val();
        var inputSubDLCodeID = $('#inputSubDLCodeID').val();
        var inputSubDLCodeDesc = $('#inputSubDLCodeDesc').val();
        var inputTransmissionType = $('#inputTransmissionType').val();
        var inputLicenceType = $('#inputLicenceType').val();
        
        if(inputDLCodeID != "" && inputDLCodeDesc != "" && inputSubDLCodeID != "" && inputSubDLCodeDesc != "" && inputTransmissionType != null && inputLicenceType != null){
          $.ajax({
                    url: "add-student-query.php",
                    type: "POST",
                    datatype: "text",
                    data: {
                      inputDLCodeID: inputDLCodeID,
                      inputDLCodeDesc: inputDLCodeDesc,
                      inputSubDLCodeID: inputSubDLCodeID,
                      inputSubDLCodeDesc: inputSubDLCodeDesc,
                      inputTransmissionType: inputTransmissionType,
                      inputLicenceType: inputLicenceType,
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