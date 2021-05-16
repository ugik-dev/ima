		<div class="error error-5 d-flex flex-row-fluid bgi-size-cover bgi-position-center" style="height: 800px;background-image: url(<?= base_url() ?>assets/metronic/media/error/bg5.jpg);">
		    <!--begin::Content-->
		    <div class="container d-flex flex-row-fluid flex-column justify-content-md-center p-12">
		        <h1 class="error-title font-weight-boldest text-info mt-10 mt-md-0 mb-12">Oops!</h1>
		        <p class="font-weight-boldest display-4">Something went wrong here.</p>
		        <p class="font-size-h3"><?php if (!empty($message)) {
                                            echo $message;
                                        } else {
                                            echo "We're working on it and we'll get it fixedas soon possible.You can back or use our Help Center.";
                                        } ?>
		        </p>
		    </div>
		    <!--end::Content-->
		</div>