<?php
	include('session.php');
	
	$name=$_POST['name'];
	$address=$_POST['address'];
	$contact=$_POST['contact'];
	
	$userid=mysqli_insert_id($conn);
	
	mysqli_query($conn,"insert into supplier (userid, company_name, company_address, contact) values ('$userid', '$name', '$address', '$contact')");
	
	?>
		<script>
			window.alert('Supplier added successfully!');
			window.history.back();
		</script>
	<?php
?>