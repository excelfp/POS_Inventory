<?php
	
	include('session.php');
	$id=$_GET['id'];
	
	$p=mysqli_query($conn,"select * from `stock` where stockid='$id'");
	$prow=mysqli_fetch_array($p);
	
	$name=$_POST['name'];
	$supplier=$_POST['supplier'];
	$price=$_POST['price'];
	$qty=$_POST['qty'];
	$min_qty=$_POST['min_qty'];
	
	mysqli_query($conn,"update stock set stock_name='$name', supplierid='$supplier', stock_price='$price', stock_qty='$qty', min_qty='$min_qty' where stockid='$id'");
	
	if($qty!=$prow['stock_qty']){
		mysqli_query($conn,"insert into inventory (userid,action,stockid,quantity,inventory_date) values ('".$_SESSION['id']."','Update Stock Quantity', '$id', '$qty', NOW())");
	}
	?>
		<script>
			window.alert('Stock updated successfully!');
			window.history.back();
		</script>
	<?php

?>