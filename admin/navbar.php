<!-- Navigation -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
				<a class="navbar-brand" href="index.php">Stock Management & POS System</a>
            </div>

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
						<span class="glyphicon glyphicon-user"></span> <?php echo $user; ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
						<li><a href="#account" data-toggle="modal"><span class="glyphicon glyphicon-wrench"></span>   My Account</a></li>
						<li class="divider"></li>
                        <li><a href="#logout" data-toggle="modal"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Home </a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Inventory <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="product.php"><span class="fa fa-product-hunt"></span> Products <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="product_makanan.php"><i class="fa fa-cutlery fa-fw"></i> Makanan </a>
                                        </li>   
                                        <li>
                                            <a href="product_minuman.php"><i class="fa fa-coffee fa-fw"></i> Minuman </a>
                                        </li>                                        
                                    </ul>
                                </li>
                                <li>
                                    <a href="stock.php"> <i class="fa fa-industry"></i> Stocks </a>
                                </li>
                            </ul>
                        </li>
						<li>
                            <a href="#"><i class="fa fa-copy fa-fw"></i> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="sales.php"><i class="fa fa-money fa-fw"></i> Sales Report</a>
                                </li>
                                <li>
                                    <a href="inventory.php"><i class="fa fa-barcode fa-fw"></i> Products Report</a>
                                </li>
                                <li>
                                    <a href="inventory_stock.php"><i class="fa fa-signal fa-fw"></i> Stocks Report</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-user"></i> Users <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="employee.php"><i class="glyphicon glyphicon-user"></i> Employee </a>
                                </li>
                                <li>
                                    <a href="supplier.php"> <i class="fa fa-truck"></i> Supplier </a>
                                </li>                                      
                            </ul>
                        </li>
						<li><a href="#logout" data-toggle="modal"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>
