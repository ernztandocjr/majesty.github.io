 <?php 
require_once('connection.php');

  ?>
 <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      </li>
    </ul>

     <ul class="navbar-nav ml-auto">
     	<li class="nav-item dropdown">
     		<table>
			<tr>
			<th rowspan='2' style="text-align:right">
			<?php 

			$condition = $_SESSION["account"];
			if ($condition == "Instructor") {
                $sql = "SELECT * FROM tbl_instructorInfo WHERE instAccred = '".$_SESSION['username']."'";
            }else if ($condition == "Admin" || $condition == "Super-Admin"){
                $sql = "SELECT * FROM tbl_instructorInfo WHERE instID = ".$_SESSION['acctID'];
            }

		    $result = mysqli_query($conn, $sql);

		    $num_row = mysqli_num_rows($result);

		    $img = "";
		    $name = ""; $name2 = "";  
		    if($num_row > 0){
		      $data = mysqli_fetch_array($result);

		       $id = $data['instID'];
		       $name = $data['instFirstname'];
		       $name3 = $data['instLastname'];
		       $name2 = $data['instMiddlename'];
		       $accredd = $data['instAccred'];
		       $img = $data['instPicture'];
		       $signature = $data['instSignature'];
		       $account = $data['instAccountType'];
		       $email = $data['instEmail'];

		       if($img != ""){
		       	echo '<img src="data:image;base64,'.base64_decode($img).'" style="width: 20%;"class="img-circle elevation-3" alt="User Image">&nbsp;&nbsp;&nbsp;&nbsp;';
		       }else{
		       	echo '<img src="majesty-images/unknown-user.jpg" style="width: 20%;"class="img-circle elevation-3" alt="User Image">&nbsp;&nbsp;&nbsp;&nbsp;';
		       }
		    }?>

				</th>
			<td></td>
			</tr>
			<tr>
			<td><a href="profile.php" class="d-block"> <?php echo $name; echo ' '; echo $name3; $conn->close();?></a></td>
			</tr>
			</table>
     	</li>
  	 </ul>
  </nav>