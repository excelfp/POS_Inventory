<?php include('session.php'); ?>
<?php include('header.php'); ?>
<body>
<div id="wrapper">
<?php include('navbar.php'); ?>
<div style="height:50px;"></div>
<div id="page-wrapper">
<div class="container-fluid">
	<!-- Dashboards -->
	<div class="row">
		<div class="col-lg-6">
			<div class="dbox dbox--color-2">
				<div class="dbox__icon">
					<i class="fa fa-usd"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count"><?php $q=mysqli_query($conn,"select sum(sales_total) as todaySum from `sales` where date(sales_date)=(date(now()))");
								$qrow=mysqli_fetch_array($q);
								echo "Rp" . number_format($qrow['todaySum'],2,',','.'); ?></span>
					<span class="dbox__title">Today's Revenue</span>
				</div>			
			</div>
		</div>
		<div class="col-lg-6">
			<div class="dbox dbox--color-3">
				<div class="dbox__icon">
					<i class="fa fa-product-hunt"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count"><?php $q=mysqli_query($conn,"select p.product_name as productName, SUM(sd.sales_qty) as quantity FROM sales s JOIN sales_detail sd ON s.salesid=sd.salesid JOIN product p ON sd.productid=p.productid WHERE date(s.sales_date)=(date(now())) GROUP BY p.product_name ORDER BY quantity DESC LIMIT 1");
								$qrow=mysqli_fetch_array($q);
								echo $qrow['productName'] . ": " . $qrow['quantity']; ?></span>
					<span class="dbox__title">Today's Top Product</span>
				</div>			
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6">
			<div class="dbox dbox--color-2">
				<div class="dbox__icon">
					<i class="fa fa-usd"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count"><?php $q=mysqli_query($conn,"select sum(sales_total) as thisMonthSum from `sales` where month(sales_date)=(month(now())) and year(sales_date)=(year(now()))");
								$qrow=mysqli_fetch_array($q);
								echo "Rp" . number_format($qrow['thisMonthSum'],2,',','.'); ?></span>
					<span class="dbox__title">This Month's Revenue</span>
				</div>			
			</div>
		</div>
		<div class="col-lg-6">
			<div class="dbox dbox--color-3">
				<div class="dbox__icon">
					<i class="fa fa-product-hunt"></i>
				</div>
				<div class="dbox__body">
					<span class="dbox__count"><?php $q=mysqli_query($conn,"select p.product_name as productName, SUM(sd.sales_qty) as quantity FROM sales s JOIN sales_detail sd ON s.salesid=sd.salesid JOIN product p ON sd.productid=p.productid WHERE MONTH(s.sales_date) = (MONTH(now())) AND year(s.sales_date) = (year(CURRENT_DATE())) GROUP BY p.product_name ORDER BY quantity DESC LIMIT 1");
								$qrow=mysqli_fetch_array($q);
								echo $qrow['productName'] . ": " . $qrow['quantity']; ?></span>
					<span class="dbox__title">This Month's Top Product</span>
				</div>			
			</div>
		</div>
	</div>
</div>
</div>
</div>
<?php include('script.php'); ?>
<?php include('modal.php'); ?>
</body>
<style type="text/css">
	body{
		overflow-x: auto;
	}
	.dbox {
    position: relative;
    background: rgb(255, 86, 65);
    background: -moz-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    background: -webkit-linear-gradient(top, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    background: linear-gradient(to bottom, rgba(255, 86, 65, 1) 0%, rgba(253, 50, 97, 1) 100%);
    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#ff5641', endColorstr='#fd3261', GradientType=0);
    border-radius: 4px;
    text-align: center;
    margin: 60px 0 50px;
	}
	.dbox__icon {
	    position: absolute;
	    transform: translateY(-50%) translateX(-50%);
	    left: 50%;
	}
	.dbox__icon:before {
	    width: 75px;
	    height: 75px;
	    position: absolute;
	    background: #fda299;
	    background: rgba(253, 162, 153, 0.34);
	    content: '';
	    border-radius: 50%;
	    left: -17px;
	    top: -17px;
	    z-index: -2;
	}
	.dbox__icon:after {
	    width: 60px;
	    height: 60px;
	    position: absolute;
	    background: #f79489;
	    background: rgba(247, 148, 137, 0.91);
	    content: '';
	    border-radius: 50%;
	    left: -10px;
	    top: -10px;
	    z-index: -1;
	}
	.dbox__icon > i {
	    background: #ff5444;
	    border-radius: 50%;
	    line-height: 40px;
	    color: #FFF;
	    width: 40px;
	    height: 40px;
		font-size:22px;
	}
	.dbox__body {
	    padding: 50px 20px;
	}
	.dbox__count {
	    display: block;
	    font-size: 30px;
	    color: #FFF;
	    font-weight: 300;
	}
	.dbox__title {
	    font-size: 13px;
	    color: #FFF;
	    color: rgba(255, 255, 255, 0.81);
	}
	.dbox__action {
	    transform: translateY(-50%) translateX(-50%);
	    position: absolute;
	    left: 50%;
	}
	.dbox__action__btn {
	    border: none;
	    background: #FFF;
	    border-radius: 19px;
	    padding: 7px 16px;
	    text-transform: uppercase;
	    font-weight: 500;
	    font-size: 11px;
	    letter-spacing: .5px;
	    color: #003e85;
	    box-shadow: 0 3px 5px #d4d4d4;
	}


	.dbox--color-2 {
	    background: rgb(31, 252, 45);
	    background: -moz-linear-gradient(top, rgba(31, 252, 45, 1) 1%, rgba(26, 142, 34, 1) 99%);
	    background: -webkit-linear-gradient(top, rgba(31, 252, 45, 1) 1%, rgba(26, 142, 34, 1) 99%);
	    background: linear-gradient(to bottom, rgba(31, 252, 45, 1) 1%, rgba(26, 142, 34, 1) 99%);
	    filter: progid: DXImageTransform.Microsoft.gradient( startColorstr='#fcbe1b', endColorstr='#f85648', GradientType=0);
	}
	.dbox--color-2 .dbox__icon:after {
	    background: #fee036;
	    background: rgba(31, 181, 41, 0.81);
	}
	.dbox--color-2 .dbox__icon:before {
	    background: #fee036;
	    background: rgba(31, 181, 41, 0.64);
	}
	.dbox--color-2 .dbox__icon > i {
	    background: #1FFC29;
	}

	.dbox--color-3 {
	    background: rgbrgb(50,160,255);
	    background: -moz-linear-gradient(top, rgba(50,160,255,1) 0%, rgba(125,174,230,1) 100%);
	    background: -webkit-linear-gradient(top, rgba(50,160,255,1) 0%,rgba(125,174,230,1) 100%);
	    background: linear-gradient(to bottom, rgba(50,160,255,1) 0%,rgba(125,174,230,1) 100%);
	    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#b747f7', endColorstr='#6c53dc',GradientType=0 );
	}
	.dbox--color-3 .dbox__icon:after {
	    background: #b446f5;
	    background: rgba(112, 189, 255, 0.76);
	}
	.dbox--color-3 .dbox__icon:before {
	    background: #e284ff;
	    background: rgba(112, 189, 255, 0.66);
	}
	.dbox--color-3 .dbox__icon > i {
	    background: #3FA6FF;
	}
</style>
</html>
