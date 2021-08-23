<?php
include('session.php');
include('header.php'); 
include('database.php'); 
include('fungsi.php'); 
include('mining.php'); 
include('display_mining.php');
?>
<head>
    <link rel="stylesheet" href="assets/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
    <link rel="stylesheet" href="assets/css/bootstrap-colorpicker.min.css" />
</head>
<div id="wrapper">
<?php 
include('navbar.php');
include('script.php'); 
include('modal.php'); 
 ?>
<div id="page-wrapper" class="main-content">
    <div class="main-content-inner">
        <div class="container-fluid">
            <div class="page-header">
                <h1 style="padding-top: 50px;">
                    Apriori Report
                </h1>
            </div><!-- /.page-header -->
            
<?php
//object database class
$db_object = new database();

$pesan_error = $pesan_success = "";
if (isset($_GET['pesan_error'])) {
    $pesan_error = $_GET['pesan_error'];
}
if (isset($_GET['pesan_success'])) {
    $pesan_success = $_GET['pesan_success'];
}

if (isset($_POST['submit'])) {
    $can_process = true;
    if (empty($_POST['min_support']) || empty($_POST['min_confidence'])) {
        $can_process = false;
        ?>
        <script> location.replace("?menu=proses_apriori&pesan_error=Min. Support dan Min. Confidence harus diisi");</script>
        <?php
    }
    if(!is_numeric($_POST['min_support']) || !is_numeric($_POST['min_confidence'])){
        $can_process = false;
        ?>
        <script> location.replace("?menu=proses_apriori&pesan_error=Min. Support dan Min. Confidence harus diisi angka");</script>
        <?php
    }
    //  01/09/2016 - 30/09/2016

    if($can_process){
        $tgl = explode(" - ", $_POST['range_tanggal']);
        $start = format_date($tgl[0]);
        $end = format_date($tgl[1]);

        if(isset($_POST['id_process'])){
            $id_process = $_POST['id_process'];
            //delete hitungan untuk id_process
            reset_hitungan($db_object, $id_process);

            //update log process
            $field = array(
                            "start_date"=>$start,
                            "end_date"=>$end,
                            "min_support"=>$_POST['min_support'],
                            "min_confidence"=>$_POST['min_confidence']
                        );
            $where = array(
                            "id"=>$id_process
                        );
            $query = $db_object->update_record("process_log", $field, $where);
        }
        else{
            //insert log process
            $field_value = array(
                            "start_date"=>$start,
                            "end_date"=>$end,
                            "min_support"=>$_POST['min_support'],
                            "min_confidence"=>$_POST['min_confidence']
                        );
            $query = $db_object->insert_record("process_log", $field_value);
            $id_process = $db_object->db_insert_id();
        }
        //show form for update
        ?>
        <div class="row">
            <div class="col-sm-12">
            
                <form method="post" action="">
                    <div class="col-lg-6 " >
                        <!-- Date range -->
                        <div class="form-group">
                            <label>Transaksi per Tanggal: </label>
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" name="range_tanggal"
                                       id="id-date-range-picker-1" required="" placeholder="Date range" 
                                       value="<?php echo $_POST['range_tanggal']; ?>">
                            </div><!-- /.input group -->
                        </div><!-- /.form group -->
                        <div class="form-group">
                            <input name="search_display" type="submit" value="Search" class="btn btn-default">
                        </div>
                    </div>
                    <div class="col-lg-6 " >
                        <div class="form-group">
                            <label>Min. Support: </label>
                            <input name="min_support" type="text" 
                                   value="<?php echo $_POST['min_support']; ?>"
                                   class="form-control" placeholder="Min. Support">
                        </div>
                        <div class="form-group">
                            <label>Min. Confidence: </label>
                            <input name="min_confidence" type="text"
                                   value="<?php echo $_POST['min_confidence']; ?>"
                                   class="form-control" placeholder="Min. Confidence">
                        </div>
                        <input type="hidden" name="id_process" value="<?php echo $id_process; ?>">
                        <div class="form-group">
                            <input name="submit" type="submit" value="Proses" class="btn btn-success">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <?php


        echo "Min. Support Absolut: " . $_POST['min_support'];
        echo "<br>";
        $sql = "SELECT COUNT(*) FROM transaksi 
        WHERE transaction_date BETWEEN '$start' AND '$end' ";
        $res = $db_object->db_query($sql);
        $num = $db_object->db_fetch_array($res);
        // $minSupportRelatif = ($_POST['min_support']/$num[0]) * 100;
        // echo "Min Support Relatif: " . $minSupportRelatif;
        // echo "<br>";
        $minSupportRelatif = $_POST['min_support'];
        echo "Min. Confidence: " . $_POST['min_confidence'];
        echo "<br>";
        echo "Start Date: " . $_POST['range_tanggal'];
        echo "<br>";

        $result = mining_process($db_object, $_POST['min_support'], $_POST['min_confidence'],
                $start, $end, $id_process);
        if ($result) {
            display_success("Proses mining selesai");
        } else {
            display_error("Gagal mendapatkan aturan asosiasi");
        }

        display_process_hasil_mining($db_object, $id_process);
    }
               
} 
else {

    if(isset($_POST['range_tanggal'])){
        $tgl = explode(" - ", $_POST['range_tanggal']);
        $start = format_date($tgl[0]);
        $end = format_date($tgl[1]);
        
        $where = " WHERE `transaction_date` "
                . " BETWEEN '$start' AND '$end'";

        $sql = "SELECT
            *
            FROM
             `transaksi` ".$where;
    }

    $truncate_transaksi_table= $db_object->db_query("TRUNCATE TABLE transaksi");
    $set_transaksi_table= $db_object->db_query("INSERT INTO transaksi (transaction_date, produk)
        SELECT DATE(s.sales_date), GROUP_CONCAT(DISTINCT p.product_name SEPARATOR ',') AS Products FROM sales s INNER JOIN sales_detail sd ON s.salesid = sd.salesid INNER JOIN product p ON sd.productid = p.productid GROUP BY DATE(s.sales_date)");
    $add_sample_data=$db_object->db_query("INSERT INTO TRANSAKSI(`transaction_date`, `produk`)
VALUES ('2021-06-05', 'Pizza,Coca-Cola,Es Kopi Susu,Ice Americano,Orange Juice,Ice Matcha Latte'),
('2021-06-06', 'Es Kopi Susu,Ice Americano,Orange Juice,Ice Matcha Latte,Donut'),
('2021-06-07', 'Es Kopi Susu,Ice Americano,Ice Matcha Latte,Donut'),
('2021-06-08', 'Burger,Donut,Nasi Goreng Special,French Fries,Es Kopi Susu,Air Mineral,Kebab,Fanta,Ice Matcha Latte'),
('2021-06-09', 'Kebab,Es Kopi Susu,Air Mineral,Fanta,Ice Matcha Latte,French Fries,Chicken Fingers'),
('2021-06-05', 'Kebab,Es Kopi Susu,Air Mineral,Coca-Cola,Pizza,Ice Matcha Latte,French Fries,Chicken Fingers,Burger,BLT Sandwich'),
('2021-06-06', 'Burger,Donut,Nasi Goreng Special,French Fries,Pizza,Coca-Cola,Fanta,Sprite,Es Kopi Susu,Air Mineral'),
('2021-06-07', 'Teh Tarik,Donut,French Fries,Pizza,Coca-Cola,Es Kopi Susu,Air Mineral'),
('2021-06-08', 'Strawberry Juice,Orange Juice,Chicken Fingers,Chicken Salad,Es Kopi Susu,Air Mineral,Ice Americano,Ice Matcha Latte'),
('2021-06-09', 'Pizza,Burger,Chicken Fingers,Chicken Salad,Donut,French Fries,Kebab,BLT Sandwich,Kue Cokelat (per-slice),Ice Americano,Es Kopi Susu'),
('2021-06-10', 'Es Kopi Susu,Ice Americano,Ice Matcha Latte,Donut,French Fries,Kebab,Kue Cokelat (per-slice)'),
('2021-06-11', 'Pizza,Burger,Chicken Fingers,Chicken Salad,Donut,French Fries,Kebab,Kue Cokelat (per-slice),Mexican Taco,Nasi Goreng Special,Es Kopi Susu,Air Mineral,Ice Matcha Latte,Teh Tarik,Strawberry Juice'),
('2021-06-12', 'Strawberry Juice,Orange Juice,Chicken Fingers,Chicken Salad,Es Kopi Susu,Air Mineral,Ice Americano,Ice Matcha Latte,Kebab,Pancake'),
('2021-06-13', 'Pizza,Burger,Chicken Fingers,Chicken Salad,Donut,French Fries,Kebab,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik,Strawberry Juice,Es Kopi Susu'),
('2021-06-14', 'Pizza,Chicken Fingers,Es Kopi Susu,Donut,French Fries,Kebab,Kue Cokelat (per-slice),Sprite,Air Mineral,Ice Americano,Ice Matcha Latte,Coca-Cola'),
('2021-06-15', 'Chicken Fingers,French Fries,Kebab,Kue Cokelat (per-slice),Mexican Taco,Spaghetti,Fanta,Ice Americano,Teh Tarik,Strawberry Juice,Es Kopi Susu'),
('2021-06-17', 'Burger,Donut,Nasi Goreng Special,French Fries,Kue Cokelat (per-slice),Spaghetti,Orange Juice,Strawberry Juice,Es Kopi Susu,Ice Matcha Latte'),
('2021-06-18', 'Ice Americano,Es Kopi Susu,Ice Matcha Latte,Pizza,Coca-Cola,Fanta,Air Mineral'),
('2021-06-20', 'Burger,French Fries,Ice Americano,Es Kopi Susu,Ice Matcha Latte,Air Mineral'),
('2021-06-21', 'Pizza,Coca-Cola,Fanta,French Fries,Ice Americano,Es Kopi Susu,Ice Matcha Latte'),
('2021-06-22', 'Chicken Fingers,Donut,Es Kopi Susu,Ice Matcha Latte,Air Mineral'),
('2021-06-23', 'Pizza,Coca-Cola,Sprite,Fanta,Es Kopi Susu,Chicken Fingers,Kue Cokelat (per-slice)'),
('2021-06-24', 'Chicken Fingers,Chicken Salad,BLT Sandwich,Kue Cokelat (per-slice),Mexican Taco,Nasi Goreng Special,Pancake,Coca-Cola,Air Mineral,Ice Americano,Teh Tarik,Orange Juice,Strawberry Juice,Es Kopi Susu'),
('2021-06-25', 'Pizza,Burger,Chicken Fingers,French Fries,Kebab,Kue Cokelat (per-slice),Nasi Goreng Special,Spaghetti,Es Kopi Susu,Fanta,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik'),
('2021-06-26', 'Pizza,Chicken Fingers,Donut,French Fries,Kebab,Mexican Taco,Es Kopi Susu,Sprite,Fanta,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik,Orange Juice,Strawberry Juice'),
('2021-06-27', 'Pizza,Chicken Fingers,Donut,French Fries,Kebab,Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik,Orange Juice,Strawberry Juice'),
('2021-06-28', 'Pizza,Chicken Fingers,French Fries,Kebab,Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik'),
('2021-06-29', 'Pizza,Chicken Fingers,French Fries,Kebab,Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte'),
('2021-06-30', 'Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Chicken Fingers,Kebab'),
('2021-05-01', 'Pizza,Coca-Cola,Fanta,Es Kopi Susu,Teh Tarik,Chicken Salad,Air Mineral,Orange Juice,Donut'),
('2021-05-02', 'Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Chicken Fingers,Kebab,French Fries'),
('2021-05-03', 'Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Chicken Fingers,Kebab,French Fries'),
('2021-05-04', 'Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Chicken Fingers,Kebab,French Fries'),
('2021-05-05', 'Burger,Es Kopi Susu,Nasi Goreng Special,French Fries,Ice Matcha Latte,Kue Cokelat (per-slice),Donut'),
('2021-05-06', 'Burger,Donut,Nasi Goreng Special,French Fries,Es Kopi Susu,Air Mineral,Kebab,Fanta,Ice Matcha Latte'),
('2021-05-07', 'Strawberry Juice,Orange Juice,Chicken Fingers,Chicken Salad,Es Kopi Susu,Air Mineral,Ice Americano,Ice Matcha Latte,Kebab,Pancake'),
('2021-05-08', 'Pizza,Coca-Cola,Fanta,Es Kopi Susu,Teh Tarik,Chicken Salad,Air Mineral,Orange Juice,Donut'),
('2021-05-09', 'Burger,French Fries,Ice Americano,Es Kopi Susu,Ice Matcha Latte,Air Mineral'),
('2021-05-10', 'Ice Americano,Es Kopi Susu,Ice Matcha Latte,Pizza,Coca-Cola,Fanta,Air Mineral,Sprite'),
('2021-05-11', 'Kebab,Chicken Fingers,Es Kopi Susu,Ice Matcha Latte,Pizza,Coca-Cola,Fanta,Air Mineral,Sprite'),
('2021-05-12', 'Pizza,Chicken Fingers,French Fries,Kebab,Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik'),
('2021-05-13', 'Burger,Donut,Nasi Goreng Special,French Fries,Chicken Salad,Orange Juice,Strawberry Juice,Air Mineral,Ice Americano,Es Kopi Susu'),
('2021-05-14', 'Kebab,Nasi Goreng Special,French Fries,Ice Matcha Latte,Orange Juice,Air Mineral,Ice Americano,Es Kopi Susu'),
('2021-05-15', 'Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Chicken Fingers,Kebab,French Fries'),
('2021-05-16', 'Es Kopi Susu,Air Mineral,Kebab,Burger,Donut,Nasi Goreng Special,French Fries'),
('2021-05-17', 'Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Chicken Fingers,Kebab,French Fries'),
('2021-05-18', 'Es Kopi Susu,Ice Americano,Ice Matcha Latte,Donut,Kue Cokelat (per-slice)'),
('2021-05-19', 'Pizza,Coca-Cola,Es Kopi Susu,Ice Americano,Ice Matcha Latte,Donut,Kue Cokelat (per-slice)'),
('2021-05-20', 'Pizza,Coca-Cola,Es Kopi Susu,Ice Americano,Ice Matcha Latte,Air Mineral'),
('2021-05-21', 'Ice Americano,Es Kopi Susu,Ice Matcha Latte,Pizza,Coca-Cola,Fanta,Air Mineral,Sprite,Chicken Fingers'),
('2021-05-22', 'Burger,French Fries,Fanta,Ice Americano,Es Kopi Susu,Ice Matcha Latte,Pizza,Coca-Cola,Fanta,Air Mineral,Sprite'),
('2021-05-23', 'Es Kopi Susu,Ice Americano,Ice Matcha Latte,Donut,Kue Cokelat (per-slice),French Fries'),
('2021-05-24', 'Pizza,Chicken Fingers,French Fries,Kebab,Es Kopi Susu,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik'),
('2021-05-25', 'Pizza,Chicken Fingers,Donut,French Fries,Kebab,Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik,Orange Juice,Strawberry Juice'),
('2021-05-26', 'Pizza,Chicken Fingers,French Fries,Es Kopi Susu,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik'),
('2021-05-27', 'Es Kopi Susu,Ice Americano,Ice Matcha Latte,Donut,Kue Cokelat (per-slice)'),
('2021-05-28', 'Es Kopi Susu,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Chicken Fingers,Kebab,French Fries'),
('2021-05-29', 'Chicken Fingers,Chicken Salad,BLT Sandwich,Kue Cokelat (per-slice),Mexican Taco,Nasi Goreng Special,Pancake,Coca-Cola,Air Mineral,Ice Americano,Teh Tarik,Orange Juice,Strawberry Juice,Es Kopi Susu'),
('2021-05-30', 'Pizza,Burger,Chicken Fingers,Donut,French Fries,Kebab,Nasi Goreng Special,Spaghetti,Es Kopi Susu,Sprite,Fanta,Coca-Cola,Ice Americano,Ice Matcha Latte,Teh Tarik,Orange Juice,Strawberry Juice'),
('2021-05-31', 'Pizza,Burger,Chicken Fingers,Chicken Salad,Donut,French Fries,Kebab,BLT Sandwich,Kue Cokelat (per-slice),Mexican Taco,Nasi Goreng Special,Pancake,Spaghetti,Es Kopi Susu,Sprite,Fanta,Coca-Cola,Air Mineral,Ice Americano,Ice Matcha Latte,Teh Tarik,Orange Juice,Strawberry Juice')");

    if(isset($sql)){
        $query = $db_object->db_query($sql);
        $jumlah = $db_object->db_num_rows($query);
    }
    else { $jumlah = 0; }

    ?>
    <form method="post" action="">
        <div class="row">
            <div class="col-lg-6 " >
                <!-- Date range -->
                <div class="form-group">
                    <label>Transaksi per Tanggal: </label>
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" name="range_tanggal"
                               id="id-date-range-picker-1" required="" placeholder="Date range" 
                               value="<?php echo $_POST['range_tanggal']; ?>">
                    </div><!-- /.input group -->
                </div><!-- /.form group -->


                <div class="form-group">
                    <input name="search_display" type="submit" value="Search" class="btn btn-default">
                </div>
            </div>
            <div class="col-lg-6 " >
                <div class="form-group">
                    <input name="min_support" type="text" class="form-control" placeholder="Min. Support">
                </div>
                <div class="form-group">
                    <input name="min_confidence" type="text" class="form-control" placeholder="Min. Confidence">
                </div>
                <div class="form-group">
                    <input name="submit" type="submit" value="Proses" class="btn btn-success">
                </div>
            </div>

        </div>
    </form>

    <?php
    if (!empty($pesan_error)) {
        display_error($pesan_error);
    }
    if (!empty($pesan_success)) {
        display_success($pesan_success);
    }


    echo "Jumlah data: " . $jumlah . "<br>";
    if ($jumlah == 0) {
        echo "Data kosong...";
    } 
    else {
        ?>
        <table class='table table-bordered table-striped  table-hover'>
            <tr>
                <th>No</th>
                <th style="width: 15%;">Tanggal</th>
                <th>Produk</th>
            </tr>
            <?php
            $no = 1;
            while ($row = $db_object->db_fetch_array($query)) {
                echo "<tr>";
                echo "<td>" . $no . "</td>";
                echo "<td>" . $row['transaction_date'] . "</td>";
                echo "<td>" . $row['produk'] . "</td>";
                echo "</tr>";
                $no++;
            }
            ?>
        </table>
        <?php
    }           
}
?>
        </div>
    </div>
</div>
</div>

<!-- basic scripts -->

        <!--[if !IE]> -->
        <script src="assets/js/jquery-2.1.4.min.js"></script>

        <!-- <![endif]-->

        <!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
        <script type="text/javascript">
                    if ('ontouchstart' in document.documentElement)
                        document.write("<script src='assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
        </script>
        <script src="assets/js/bootstrap.min.js"></script>

        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
          <script src="assets/js/excanvas.min.js"></script>
        <![endif]-->
        <script src="assets/js/jquery-ui.custom.min.js"></script>
        <script src="assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="assets/js/jquery.easypiechart.min.js"></script>
        <script src="assets/js/jquery.sparkline.index.min.js"></script>
        <script src="assets/js/jquery.flot.min.js"></script>
        <script src="assets/js/jquery.flot.pie.min.js"></script>
        <script src="assets/js/jquery.flot.resize.min.js"></script>

        
        <!-- page specific plugin scripts -->

        <!--[if lte IE 8]>
          <script src="assets/js/excanvas.min.js"></script>
        <![endif]-->
        <script src="assets/js/chosen.jquery.min.js"></script>
        <script src="assets/js/spinbox.min.js"></script>
        <script src="assets/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/js/bootstrap-timepicker.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/daterangepicker.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/bootstrap-colorpicker.min.js"></script>
        <script src="assets/js/jquery.knob.min.js"></script>
        <script src="assets/js/autosize.min.js"></script>
        <script src="assets/js/jquery.inputlimiter.min.js"></script>
        <script src="assets/js/jquery.maskedinput.min.js"></script>
        <script src="assets/js/bootstrap-tag.min.js"></script>
                
                
        <!-- ace scripts -->
        <script src="assets/js/ace-elements.min.js"></script>
        <script src="assets/js/ace.min.js"></script>

<script type="text/javascript">
            jQuery(function ($) {
                //datepicker plugin
                //link
                $('.date-picker').datepicker({
                        autoclose: true,
                        todayHighlight: true
                })
                //show datepicker when clicking on the icon
                .next().on(ace.click_event, function(){
                        $(this).prev().focus();
                });

                //or change it into a date range picker
                $('.input-daterange').datepicker({autoclose:true});


                //to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
                $('input[name=range_tanggal]').daterangepicker(
                        
                {
                        'applyClass' : 'btn-sm btn-success',
                        'cancelClass' : 'btn-sm btn-default',
                        locale: {
                                applyLabel: 'Apply',
                                cancelLabel: 'Cancel',
                                format: 'DD/MM/YYYY',
                        }
                })
                .prev().on(ace.click_event, function(){
                        $(this).next().focus();
                });

               $('#id-input-file-1 , #id-input-file-2').ace_file_input({
            no_file:'No File ...',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false //| true | large
            //whitelist:'gif|png|jpg|jpeg'
            //blacklist:'exe|php'
            //onchange:''
            //
        });

                //flot chart resize plugin, somehow manipulates default browser resize event to optimize it!
                //but sometimes it brings up errors with normal resize event handlers
                $.resize.throttleWindow = false;

                /////////////////////////////////////
                $(document).one('ajaxloadstart.page', function (e) {
                    $tooltip.remove();
                });
            });
</script>
<?php include('script.php'); ?>
<script src="custom.js"></script>