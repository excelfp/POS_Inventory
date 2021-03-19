<?php
	include('session.php');
	
	$name=$_POST['name'];
	$price=$_POST['price'];
	$supplier=$_POST['supplier'];
	$qty=$_POST['qty'];
	
	mysqli_query($conn,"insert into stock (stock_name,stock_price,stock_qty, supplierid) values ('$name','$price','$qty', '$supplier')");
	$sid=mysqli_insert_id($conn);
	
	mysqli_query($conn,"insert into inventory (userid, action, stockid, quantity, inventory_date) values ('".$_SESSION['id']."', 'Add Stock', '$sid', '$qty', NOW())");
	
	?>
		<script>
			window.alert('Stock added successfully!');
			window.history.back();
		</script>
	<?php
?>