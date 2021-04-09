<?php

	$pq=mysqli_query($conn,"select * from stock where stock_qty <= min_qty");

	while($pqrow=mysqli_fetch_array($pq)){

		$stock_name=$pqrow['stock_name'];
		$stock_qty=$pqrow['stock_qty'];

		echo '<script type="text/javascript">
				
				alert("There\'s Stock(s) You Need to Purchase: \r '.$stock_name.' - '.$stock_qty.' left.");
			</script>';
	}

?>