<?php
	include('session.php');
	$pid=$_GET['id'];
	
	$a=mysqli_query($conn,"select * from stock where stockid='$pid'");
	$b=mysqli_fetch_array($a);
	
	mysqli_query($conn,"delete from stock where stockid='$pid'");
	
	header('location:stock.php');

?>