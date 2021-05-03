    <script type="text/javascript">
        function show_modal_page(url) {

            console.log('show_modal_page')

            // SHOWING AJAX PRELOADER IMAGE
            jQuery('#page_model_view_data2 .modal-body').html('<div style="text-align:center;margin-top:200px;"><img src="<?php echo base_url(); ?>assets/img/loader-1.gif" style="height:25px;" /></div>');

            // // LOADING THE AJAX MODAL
            // $('#page_model_view_data2').modal('show');
            // $('#exampleModal').modal('show')
            $('#page_model_view_data2').modal('show')

            // // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: url,
                success: function(response) {
                    // alert(response);
                    jQuery('#page_model_view_data2 .modal-body').html(response);
                }
            });
        }

        function add_new_row(url) {
            // SHOW AJAX RESPONSE ON REQUEST SUCCESS
            $.ajax({
                url: url,
                success: function(response) {
                    // console.log(response)
                    jQuery('#transaction_table_body').append(response);
                    $('.select2').select2();

                    $('.mask').mask('000.000.000.000.000,00', {
                        reverse: true
                    });
                    // $('#sub_head').select2('data', {
                    //     value: '10'
                    // });

                }
            });
        }
    </script>

    <!-- (Ajax Modal)-->
    <div class="modal fade" id="page_model_view_data">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" style="height:500px; overflow:auto;">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="page_model_view_data2" tabindex="-1" role="dialog" aria-labelledby="exampleModalSizeSm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">

            <!-- <div class="modal fade" id="page_model_view_data2" tabindex="-1" role="dialog" aria-labelledby="page_model_view_data" aria-hidden="true">
                <div class="modal-dialog" role="document"> -->
            <div class="modal-content">

                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>