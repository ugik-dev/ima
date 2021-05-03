<?php
	$user_name = $this->session->userdata('user_id');
?>
<header class="main-header">
<nav style="  background-image:url(<?php echo base_url().'assets/img/heade3.png'?>); " class="navbar navbar-default">
	<div class="row header_row">
	    <div class="col-md-8 col-xs-12">
	       <a href="<?php echo base_url('/');?>homepage ">
	      <i class="fa fa-globe"> </i> <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?>
	     </a>
	    </div>
	    <div class="col-md-4 col-xs-12 ">
	    	<span class="pull-right">
	    			    		
		        <a class=" link-setting-header" href="javscript:void(0)">
		                <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('d-m-Y'); ?> 	
		        </a>
		    	<a class="text-center link-setting-header" href="<?php echo base_url('profile');?>">
		             <?php echo img(array('width'=>'18','height'=>'18','class'=>'img-circle','alt'=>'User Image','src'=>'uploads/users/'.$this->db->get_where('mp_users', array('id' =>$user_name['id']))->result_array()[0]['cus_picture'])); ?>
		                  <?php echo $user_name['name']; ?>
		        </a> 
		        <a class="pull-right link-setting-header" href="<?php echo base_url('homepage/sign_out');?>">
		                <i class="fa fa-sign-out" aria-hidden="true"></i> Logout
		        </a>
	        </span>
    	</div>
	</div>
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    	<?php
	    //SIDEMENU CONFIGURATION FROM HELPER CLASS VISIT HELPER CLASS FOR  MORE details
	    $SideMenu_records = Fetch_Users_Access_Control_Menu($user_name['id']);
	    if($SideMenu_records != NULL)
	    {
		?>
     		 <ul class="nav navbar-nav">
      	<?php
		 foreach ($SideMenu_records as  $obj_SideMenu_records) 
		 {
		?>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle text-center link-settting" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	          		<i class="<?php echo $obj_SideMenu_records->icon; ?> icon-settings" aria-hidden="true" >
			            </i>
	              	<span class="text-center link-settting" > 
	               		<?php echo $obj_SideMenu_records->name; ?>
	              	</span>
			    </a>
	          <ul class="dropdown-menu">
	          		<?php
                  		//DEFINES TO FETCH THE ROLES ASSIGNED TO USER SUB MENU DATA mp_menulist TABLE
                  		$SideSubMenu_records = Fetch_Users_Access_Control_Sub_Menu($obj_SideMenu_records->id);
	                    if($SideSubMenu_records != NULL)
	                    {
	                        foreach ($SideSubMenu_records as $obj_SideSubMenu_records) 
	                        {   
                   	?>
			            <li class="responsive-color-list">
			            	<a href="<?php echo base_url($obj_SideSubMenu_records->link);?>">
			            		<i class="fa fa-circle-o"></i>
								<?php echo $obj_SideSubMenu_records->title; ?>
			       			 </a>
			       	 	</li>
        		    <?php 
                  			}
                     	}
	                ?>
	          </ul>
		    </li>
	    <?php 
		 }
    	?>
      </ul>
		<?php 
		}
	    ?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</header>