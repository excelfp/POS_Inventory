<?php
	include('session.php');
	
	$stock=$_POST['stock'];
	$supplier=$_POST['supplier'];
	$qty=$_POST['qty'];
	$desc=$_POST['desc'];
	
	mysqli_query($conn,"insert into stock_return (stockid, return_qty, supplierid, description, return_date) values ('$stock','$qty', '$supplier', '$desc', NOW())");
	$sid=mysqli_insert_id($conn);
	
	mysqli_query($conn,"insert into inventory (userid, action, stockid, quantity, inventory_date) values ('".$_SESSION['id']."', 'Stock Return', '$stock', '$qty', NOW())");
	
	?>
		<script>
			window.alert('Return Added Successfully!');
			window.history.back();
		</script>
	<?php
?>