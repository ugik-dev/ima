<?php 
	$colors_arr = color_options();
	$THEME_COLOR = $colors_arr['primary'];
	$THEME_COLOR_HOVER =  $colors_arr['hover'];
?>
<style media="screen">
	.purchase-heading
	{
	  background-color: <?php echo $THEME_COLOR;  ?>;
	}
	.link-settting,
	.icon-settings
	{
	  color: <?php echo $THEME_COLOR;  ?>;
	}
	.btn-info,
	.bg-aqua,
	.callout.callout-info,
	.alert-info,
	.label-info,
	.modal-info .modal-body,
	.header_row
	{
	  background-color: <?php echo $THEME_COLOR;  ?>
	}
	.btn-info
	{
	  background-color: <?php echo $THEME_COLOR;  ?>;
	  border-color: <?php echo $THEME_COLOR_HOVER;  ?>;
	}
	.btn-info:hover
	{
	  background-color: <?php echo $THEME_COLOR_HOVER;  ?>;
	}
	.box.box-info
	{
		border-top-color: <?php echo $THEME_COLOR;  ?>
	}
	.box
	{
		border-top: 3px solid <?php echo $THEME_COLOR;  ?>;
	}
	.pagination>.active>a, 
	.pagination>.active>a:focus, 
	.pagination>.active>a:hover, 
	.pagination>.active>span, 
	.pagination>.active>span:focus, 
	.pagination>.active>span:hover,
	.btn-info.active, .btn-info:active, .open>.dropdown-toggle.btn-info,
	.btn-info.active.focus, .btn-info.active:focus, .btn-info.active:hover, .btn-info:active.focus, .btn-info:active:focus, .btn-info:active:hover, .open>.dropdown-toggle.btn-info.focus, .open>.dropdown-toggle.btn-info:focus, .open>.dropdown-toggle.btn-info:hover
	{
		background-color: <?php echo $THEME_COLOR;  ?>;
    	border-color: <?php echo $THEME_COLOR_HOVER;  ?>;
	}


</style>