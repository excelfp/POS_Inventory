<?php
	include('session.php');
	$uid=$_GET['id'];

	$name= $_POST['ename'];
	$address= $_POST['address'];
	$contact= $_POST['contact'];
	
	mysqli_query($conn,"update employee set employee_name='$name', address='$address', contact='$contact' where userid='$uid'");
	
	?>
		<script>
			window.alert('Profile updated successfully!');
			window.history.back();
		</script>
	<?php
	
?>