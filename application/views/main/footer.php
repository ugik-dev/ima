  <script>
      var HOST_URL = "https://ugikdev.id";
  </script>
  <!--begin::Global Config(global config for global JS scripts)-->
  <script>
      var KTAppSettings = {
          "breakpoints": {
              "sm": 576,
              "md": 768,
              "lg": 992,
              "xl": 1200,
              "xxl": 1400
          },
          "colors": {
              "theme": {
                  "base": {
                      "white": "#ffffff",
                      "primary": "#3699FF",
                      "secondary": "#E5EAEE",
                      "success": "#1BC5BD",
                      "info": "#8950FC",
                      "warning": "#FFA800",
                      "danger": "#F64E60",
                      "light": "#E4E6EF",
                      "dark": "#181C32"
                  },
                  "light": {
                      "white": "#ffffff",
                      "primary": "#E1F0FF",
                      "secondary": "#EBEDF3",
                      "success": "#C9F7F5",
                      "info": "#EEE5FF",
                      "warning": "#FFF4DE",
                      "danger": "#FFE2E5",
                      "light": "#F3F6F9",
                      "dark": "#D6D6E0"
                  },
                  "inverse": {
                      "white": "#ffffff",
                      "primary": "#ffffff",
                      "secondary": "#3F4254",
                      "success": "#ffffff",
                      "info": "#ffffff",
                      "warning": "#ffffff",
                      "danger": "#ffffff",
                      "light": "#464E5F",
                      "dark": "#ffffff"
                  }
              },
              "gray": {
                  "gray-100": "#F3F6F9",
                  "gray-200": "#EBEDF3",
                  "gray-300": "#E4E6EF",
                  "gray-400": "#D1D3E0",
                  "gray-500": "#B5B5C3",
                  "gray-600": "#7E8299",
                  "gray-700": "#5E6278",
                  "gray-800": "#3F4254",
                  "gray-900": "#181C32"
              }
          },
          "font-family": "Poppins"
      };
  </script>
  <!--end::Global Config-->
  <!--begin::Global Theme Bundle(used by all pages)-->
  <script src="<?= base_url() ?>assets/metronic/plugins/global/plugins.bundle.js"></script>
  <!-- <script type="text/javascript" src="<?= base_url() ?>assets/dist/js/jstreetable.js"></script> -->

  <script src="<?= base_url() ?>assets/metronic/plugins/custom/prismjs/prismjs.bundle.js"></script>
  <script src="<?= base_url() ?>assets/metronic/js/scripts.bundle.js"></script>
  <!--end::Global Theme Bundle-->
  <!--begin::Page Vendors(used by this page)-->
  <script src="<?= base_url() ?>assets/metronic/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
  <!--end::Page Vendors-->
  <!--begin::Page Scripts(used by this page)-->
  <script src="<?= base_url() ?>assets/metronic/js/pages/widgets.js"></script>
  <script>
      //   $('#exampleModal').modal('show')
  </script>
  <!-- <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script> -->
  <!-- Bootstrap Gowl -->
  <script src="<?php echo base_url(); ?>assets/plugins/bootstrap-growl/jquery.bootstrap-growl.js"></script>
  <!-- DataTables -->
  <!-- <script src="<?php echo base_url(); ?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script> -->
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
  <!-- <script src="<?= base_url() ?>assets/metronic/plugins/custom/jstree/jstree.bundle.js"></script> -->
  <!-- <script src="<?= base_url() ?>assets/metronic/plugins/custom/jstree/jstreetable.js"></script> -->
  <!-- <script type="text/javascript" src="<?= base_url() ?>assets/dist/js/jstreetable.js"></script> -->

  <!-- <script src="<?= base_url() ?>assets/metronic /js/pages/features/miscellaneous/treeview.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script> -->
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
  <script src="<?= base_url() ?>assets/metronic/plugins/custom/datatables/datatables.bundle.js"></script>
  <!--end::Page Vendors-->
  <!--begin::Page Scripts(used by this page)-->
  <script src="<?= base_url() ?>assets/metronic/js/pages/crud/datatables/basic/headers.js"></script>
  <!--end::Page Scripts-->
  <!--end::Page Scripts-->
  </body>
  <!--end::Body-->

  </html>