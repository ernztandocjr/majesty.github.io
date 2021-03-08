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

            <h1 class="m-0 text-dark"><i class="nav-icon fas fa-tachometer-alt"></i> Dashboard</h1>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php 
                require('connection.php');

                $sqlx = "SELECT COUNT(branchName) AS 'total' FROM tbl_branches WHERE branchStatus = 'Active'";

                $resultx = mysqli_query($conn, $sqlx);
                $data = mysqli_fetch_array($resultx);
                echo '<h3>'.$data['total'].'</h3>';

                ?>

                <p>List of Branches</p>
              </div>
              <div class="icon">
                <i class="fas fa-building"></i>
              </div>
              <a href="reports.php?<?php echo urlencode( base64_encode('type=1'))?>" target="_blank" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php 
                require('connection.php');

                $sqlx = "SELECT COUNT(studStatus) AS 'total' FROM tbl_studentinfo WHERE studStatus = 'Certified'";

                $resultx = mysqli_query($conn, $sqlx);
                $data = mysqli_fetch_array($resultx);
                echo '<h3>'.$data['total'].'</h3>';

                ?>

                <p>List of Certified Students</p>
              </div>
              <div class="icon">
                <i class="fas fa-certificate"></i>
              </div>
              <a href="reports.php?<?php echo urlencode( base64_encode('type=2'))?>" target="_blank" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <?php 
                require('connection.php');

                $sqlx = "SELECT COUNT(instAccountType) AS 'total' FROM tbl_instructorinfo WHERE instAccountType = 'Instructor'";

                $resultx = mysqli_query($conn, $sqlx);
                $data = mysqli_fetch_array($resultx);
                echo '<h3>'.$data['total'].'</h3>';

                ?>

                <p>List of Instructors</p>
              </div>
              <div class="icon">
                <i class="fas fa-chalkboard-teacher"></i>
              </div>
              <a href="reports.php?<?php echo urlencode( base64_encode('type=3'))?>" target="_blank" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-12">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php 
                require('connection.php');

                $sqlx = "SELECT COUNT(instAccountType) AS 'total' FROM tbl_instructorinfo WHERE instAccountType = 'Admin'";

                $resultx = mysqli_query($conn, $sqlx);
                $data = mysqli_fetch_array($resultx);
                echo '<h3>'.$data['total'].'</h3>';

                ?>

                <p>List of Admin</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-cog"></i>
              </div>
              <a href="reports.php?<?php echo urlencode( base64_encode('type=4'))?>" target="_blank" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <div class="row">
          <div class="col-lg-6 col-12">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Certified today <b>(<?php date_default_timezone_set("Asia/Manila"); echo date('F d, Y');?>)</b></h3>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 480px; height: 480px; max-height: 480px; max-width: 100%;"></canvas>
              </div>
                  <!-- /.card-body -->
            </div>
          </div>
          <div class="col-lg-6 col-12">
            <div class="card card-success">
                <div class="card-header">
                  <h3 class="card-title">Year <b><?php echo date('Y')?></b></h3>
                </div>
                <div class="card-body">
                  <div class="chart">
                    <canvas id="barChart" style="min-height: 480px; height: 480px; max-height: 480px; max-width: 100%;"></canvas>
                  </div>
                </div>
                <!-- /.card-body -->
              </div>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php 

require_once('connection.php');         

$label = "";
$data = "";
$color = "";
$colorX = [];
$whole = 0;

$sqlDate = date('m'.'/'.'d'.'/'.'Y');

$sql = "SELECT * FROM tbl_branches WHERE branchStatus = 'Active'";
  $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0){
      while ($row = mysqli_fetch_assoc($result)) {
        $label.= '"'.$row['branchName'].'",';
        $id = $row['branchID'];

        $sql2 = "SELECT studID,trainStudentID,studDateCertified,trainBranch,COUNT(trainBranch) AS 'Total' FROM tbl_studentInfo s INNER JOIN tbl_trainingInfo t ON s.studID = t.trainStudentID WHERE studStatus = 'Certified' AND studDateCertified LIKE '$sqlDate%' AND trainBranch = '$id' GROUP BY trainBranch";

        $result2 = mysqli_query($conn, $sql2);

        if(mysqli_num_rows($result2) > 0){
          while ($row2 = mysqli_fetch_assoc($result2)) {
              $data.= '"'.$row2['Total'].'",';
          }
        }else{
          $data.= "0,";
        }

        $newColor = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
        $color.= '"'.$newColor.'",';
        $colorX[$whole] = '"'.$newColor.'"';
      
        $whole++;
      }

    }

$label = trim($label,',');
$data = trim($data,',');
$color = trim($color,',');

$labelX = [];
$dataX = [];
$whole = 0;

$sqlYear = date('Y');

$sqlX = "SELECT * FROM tbl_branches WHERE branchStatus = 'Active'";
  $resultX = mysqli_query($conn, $sqlX);

    if(mysqli_num_rows($resultX) > 0){
      while ($rowX = mysqli_fetch_assoc($resultX)) {
            $labelX[$whole] = '"'.$rowX['branchName'].'"'; 
            $idX = $rowX['branchID'];

            $sql2X = "SELECT studID,trainStudentID,studDateCertified,trainBranch,COUNT(trainBranch) AS 'Total' FROM tbl_studentInfo s INNER JOIN tbl_trainingInfo t ON s.studID = t.trainStudentID WHERE studStatus = 'Certified' AND studDateCertified LIKE '%$sqlYear%' AND trainBranch = '$idX' GROUP BY trainBranch";

            $result2X = mysqli_query($conn, $sql2X);

            if(mysqli_num_rows($result2X) > 0){
              while ($row2X = mysqli_fetch_assoc($result2X)) {
                $dataX[$whole] = '"'.$row2X['Total'].'",';
              } 
            }else{
              $dataX[$whole] = "0";
            }

            $whole++;
        }
       
    }

?>
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
  <script type="text/javascript">
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
          <?php echo $label;?>
      ],
      datasets: [
        {
          data: [<?php echo $data;?>],
          backgroundColor : [<?php echo $color;?>],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    var donutChart = new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions      
    })

    // var count = document.getElementById("countBranches");

    // var res = count.split(",");

    
  </script>

  <script type="text/javascript">
    
    var areaChartData = {
      labels  : [2021],
      datasets: [
        
        {
          label               : <?php echo $labelX[0]?>,
          backgroundColor     : <?php echo $colorX[0]?>,
          data                : [<?php echo $dataX[0]?>]
        },
        {
          label               : <?php echo $labelX[1]?>,
          backgroundColor     : <?php echo $colorX[1]?>,
          data                : [<?php echo $dataX[1]?>]
        },
        {
          label               : <?php echo $labelX[2]?>,
          backgroundColor     : <?php echo $colorX[2]?>,
          data                : [<?php echo $dataX[2]?>]
        },
      ],

    }
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    

    var barChartOptions = {
      responsive              : true,
      maintainAspectRatio     : false,
      datasetFill             : false,
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar', 
      data: areaChartData,
      options: barChartOptions

    })
  </script>
</body>
</html>
