<?php
if ($this->session->userdata('user_id') == "") {
    redirect('login');
} else {
    $user_id = $this->session->userdata('user_id');
    //TO AVOID USER TO ACCESS THE UNASSIGNED LINKS
    if (Authenticate_Url($user_id['id'], $this->uri->segment(1)) != NULL) {
    } else {
        redirect('profile');
    }
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo base_url(); ?>assets/img/favicon.png">
        <title><?php echo isset($title) ? $title : 'PT Indometal Asia | Dashboard'; ?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <!-- Theme style -->
        <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/fontawesome/css/font-awesome.css"> -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/fontawesome-5.15.3/css/all.css">

        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/css/import-font.css" />
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/iCheck/flat/blue.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!-- Datatable css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/select2/select2.min.css">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/custom.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

        <!-- jQuery 2.2.3 -->
        <script src="<?php echo base_url(); ?>assets/plugins/jQuery/jquery-3.6.0.min.js"></script>
        <!-- Bootstrap 3.3.6 -->

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    </head>

    <body class="hold-transition skin-yellow sidebar-collapse">
        <div class="wrapper">
            <?php
            $this->load->view('main2/stylings.php'); ?>
            <div class="content-wrapper">
                <section class="invoice">
                    <?php
                    $attributes = array('id' => 'invoice_form', 'autocomplete' => 'off', 'method' => 'post', 'class' => 'form-horizontal');
                    ?>
                    <?php echo form_open('invoice/add_auto_invoice', $attributes); ?>
                    <!-- title row -->
                    <div class="row">
                        <div class="col-md-3">
                            <h3>
                                <i class="fa fa-globe"></i> Nomor Invoice # <?php echo $invoice; ?>
                            </h3>
                        </div>
                        <div class="col-md-1 pull-right ">
                            <a class="pull-right btn-flat homescreen-icon btn btn-primary" href="<?php echo base_url('supply/create_new_supply'); ?>"> <i class="fa fa-truck"></i> Penjualan Grosir
                            </a>
                        </div>
                        <div class="col-md-1 pull-right ">
                            <a class="pull-right btn-flat homescreen-icon btn btn-primary" href="<?php echo base_url('dashboard'); ?>"> <i class="fa fa-dashboard"></i> Home screen
                            </a>
                        </div>
                        <div class="col-md-1 pull-right ">
                            <a class="pull-right btn-flat pos-invoice-btn homescreen-icon btn btn-primary" href="<?php echo base_url('invoice/manage'); ?>"> <i class="fa fa-file-text"></i> Daftar Invoice
                            </a>
                        </div>

                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label><i class="fa fa-barcode" aria-hidden="true"></i> SCAN BARCODE ATAU CARI ITEM</label>
                            <input type="text" class="form-control input-lg " onkeyup="add_item_invoice(this.value)" id="barcode_scan_area" name="search_area" autofocus="autofocus" />
                            <div id="search_id_result_manual"></div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="form-group">
                            <label><a onclick="show_modal_page('<?php echo base_url() . 'invoice/popup/add_patner_model'; ?>')" href="#">Tambah Customer</a></label> <br />
                            <select name="customer_id" onchange="search_customer_payments(this.value)" class="form-control select2" id="customer_id" style="width: 100%;">
                                <?php
                                if ($customer_record != NULL) {
                                    foreach ($customer_record as $single_customer) {
                                ?>
                                        <option value="<?php echo $single_customer->id; ?>">
                                            <?php echo 'Nama: ' . $single_customer->customer_name . ' - ' . $single_customer->cus_company . ' - ' . $single_customer->cus_contact_2 . ' - ' . $single_customer->cus_type . ' - ' . $single_customer->cus_region;

                                            ?>
                                        </option>
                                <?php
                                    }
                                } else {
                                    echo "No Record Found";
                                }
                                ?>
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div id="inner_invoice_area" class="col-md-12 ">
                            <?php $this->load->view($temp_view, $temp_data); ?>

                        </div>
                        <p class="col-md-12">
                            <small class="instructions ">
                                <b>ESC</b> Invoice Baru | <b>F4</b>Retur item | <b>Enter</b> Simpan invoice | <b>F2</b> Lihat invoice
                            </small>
                        </p>

                    </div>

                </section>
                <!-- Bootstrap model  -->
                <?php $this->load->view('bootstrap_model.php'); ?>
                <!-- Bootstrap model  ends-->

                <!-- AJAX FUNCTIONS   -->
                <?php $this->load->view('ajax/invoice.php'); ?>
            </div>
            <script type="text/javascript">
                //USED TO DELETE AN ITEM FROM DATABASE TEMP TABLE
                function delete_item(item_id) {
                    // SHOW AJAX RESPONSE ON REQUEST SUCCESS
                    $.ajax({
                        url: '<?php echo base_url('invoice/delete_item_temporary/'); ?>' + item_id,
                        success: function(response) {
                            jQuery('#inner_invoice_area').html(response);
                            $('#barcode_scan_area').val('');

                        }
                    });

                    $('#barcode_scan_area').focus();
                }

                var discounttimmer;
                //USED TO CALCUATE DISCOUNT AMOUT
                function checkDiscount(dis_amt) {

                    clearTimeout(discounttimmer);
                    discounttimmer = setTimeout(function callback() {
                        var total_gross_amt = $('#total_gross_amt').val();
                        var total_tax_amt = $('#total_tax_amt').val();
                        if (dis_amt > 0) {
                            var newamt = parseFloat(total_gross_amt - dis_amt) + parseFloat(total_tax_amt);
                            $('#net_total_amount').html(newamt.toFixed(2));
                            $('#bill_paid').val(newamt.toFixed(2));
                            $('#total_bill').val(newamt.toFixed(2));
                        } else {
                            var pre_val = parseFloat(total_gross_amt) + parseFloat(total_tax_amt);
                            $('#net_total_amount').html(pre_val.toFixed(2));
                            $('#bill_paid').val(pre_val.toFixed(2));
                            $('#total_bill').val(pre_val.toFixed(2));
                        }
                    }, 500)
                }

                //USED TO CALCULATE HOW MUCH AMOUNT SHOULD RETURN TO CUSTOMER
                function amount_refund(amt) {
                    var netamt = $('#net_total_amount').html();

                    var cash_given = amt - parseFloat(netamt);
                    $('#cash_given_to_customer').html(cash_given.toFixed(2));
                }

                //USED TO OPEN CUSTOMER PAYMENT MODEL 
                function open_payment_model() {
                    var cus_id = $('#customer_id').val();
                    show_modal_page('<?php echo base_url('invoice/popup/add_customer_payment_pos_model/'); ?>' + cus_id)
                }
            </script>
        </div>
        </div>
        <!-- ./wrapper -->
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- Bootstrap Gowl -->
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-growl/jquery.bootstrap-growl.js"></script>
        <!-- DataTables -->
        <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="<?php echo base_url(); ?>assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- FastClick -->
        <script src="<?php echo base_url(); ?>assets/plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo base_url(); ?>assets/dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="<?php echo base_url(); ?>assets/dist/js/demo.js"></script>
        <!-- bootstrap datepicker -->
        <script src="<?php echo base_url(); ?>assets/plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- Select2 -->
        <script src="<?php echo base_url(); ?>assets/plugins/select2/select2.full.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/jquery/jquery.validate.js"></script>
        <!-- bootstrap color picker -->
        <script src="<?php echo base_url(); ?>assets/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
        <!-- Form Validation -->
        <script src="<?php echo base_url(); ?>assets/dist/js/custom.js?v=0.0.2"></script>
        <!-- ChartJS 1.0.1 -->
        <script src="<?php echo base_url(); ?>assets/plugins/chartjs/Chart.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
        <!-- Page Script -->
        <script>
            //Colorpicker
            $(".my-colorpicker1").colorpicker();
            //color picker with addon
            $(".my-colorpicker2").colorpicker();


            $(function() {
                //Add text editor
                $("#compose-textarea").wysihtml5();
            });
        </script>
        <!-- page script -->
        <script>
            $(function() {
                $("#example1").DataTable();
                $("#example3").DataTable();
                $('#example2').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            });

            $(function() {
                //Initialize Select2 Elements
                $(".select2").select2();


            });

            function alertFunc(status, message) {
                $.bootstrapGrowl(message, {
                    ele: 'body', // which element to append to
                    type: status, // (NULL, 'info', 'error', 'success')
                    offset: {
                        from: 'top',
                        amount: 10
                    }, // 'top', or 'bottom'
                    align: 'right', // ('left', 'right', or 'center')
                    width: 300, // (integer, or 'auto')
                    delay: 3000,
                    allow_dismiss: true,
                    stackup_spacing: 10 // spacing between consecutively stacked growls.
                });
            };

            $(document).ready(function() {
                $('#example5').DataTable({
                    "order": [
                        [0, "asc"]
                    ]
                });
            });
        </script>

        <?php
        if ($this->session->flashdata('status') == "") {
        } else {

            $message = $this->session->flashdata('status');
            echo "<script>alertFunc('" . $message['alert'] . "','" . $message['msg'] . "')</script>";
        }
        ?>
    </body>

    </html>
<?php
}
?>