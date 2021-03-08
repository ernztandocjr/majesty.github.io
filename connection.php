<?php
	$conn = mysqli_connect('localhost','root','','majesty');

	if(!$conn){
		die('Please check your connection!'.mysqli_error());
	}
?>