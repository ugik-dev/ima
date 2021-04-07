  
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/front_menu/css/sidebar-menu.css">


<?php
	$user_name = $this->session->userdata('user_id');
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/js/jquery.calculator.min.js">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/js/core.js">

    <header class="main-header">
        <nav style="  background-color: #d81b60; " class="navbar navbar-default">

            <div class="row header_row">
                <div class="col-md-4 col-xs-12">
                    <div class="sn_cname">
                        <a href="<?php echo base_url('/');?>homepage">
                            <i class="fa fa-globe"> </i> <?php echo $this->db->get_where('mp_langingpage', array('id' => 1))->result_array()[0]['companyname'] ;?>
                        </a>
                        <a class=" link-setting-header" href="javscript:void(0)">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo date('d-m-Y'); ?> 	
                        </a>                        
                    </div>                    
                </div>
                <div class="col-md-8 col-xs-12 topmenushowhide">

                    <div class="header-nav">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown">
                                <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                            <img alt="" style="width:36px; height:36px;" src="<?php echo base_url(); ?>assets/img/male.png" class="mini_avatar img-rounded">

                            <div class="user">
                                <span>Selamat Datang</span>
                            </div>
                        </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="<?php echo base_url('profile');?>">
                                    <?php echo img(array('width'=>'18','height'=>'18','class'=>'img-circle','alt'=>'User Image','src'=>'uploads/users/'.$this->db->get_where('mp_users', array('id' =>$user_name['id']))->result_array()[0]['cus_picture'])); ?>
		                  <?php echo $user_name['name']; ?>                               </a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-key"></i> Ubah Kata Sandi                                </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?php echo base_url('homepage/sign_out');?>">
                                    <i class="fa fa-sign-out"></i> Logout                                </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                                    

                        <ul class="nav navbar-nav pull-right responsivetop">                           
                            <li class="con-tooltip bottom hidden-xs">
                                <a class="btn tip"  data-placement="bottom" href="<?php echo base_url('/');?>homepage "><i class="fa fa-dashboard"></i></a>
                                <div class="tooltip ">
                                    <p>Dashboard</p> 
                                </div>             
                            </li>                            
                           
                            <li class="con-tooltip bottom hidden-sm">
                                <a  data-placement="bottom" href="<?php echo base_url('/');?>invoice/manage">
                             <img src="<?php echo base_url(); ?>assets/img/quote.png">
                        </a>
                           <div class="tooltip ">
                                    <p>Invoice Hari Ini</p>
                                </div>
                            </li>
                            <li class="con-tooltip bottom hidden-xs">
                                <a class="btn bdarkGreen tip" data-placement="bottom" href="<?php echo base_url('/');?>invoice">
                            <i class="fa fa-th-large"></i> <span class="padding05">POS</span>
                        </a>
                           <div class="tooltip ">
                                    <p>POS</p>
                                </div>
                            </li>
                           
                            <li class="con-tooltip bottom hidden-xs">
                                <a class="btn bdarkGreen tip"   data-placement="bottom" href="<?php echo base_url('/');?>salesreport">
                            <i class="fa fa-hourglass-2"></i>
                        </a>
                           <div class="tooltip ">
                                    <p>Profit Hari Ini</p>
                                </div>
                            </li>   
                        </ul>
                    </div>
                </div>
            </div>

            <!-- --------------------------------------------------------------->
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" id="responsiveicond" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
 <!-- Start menu ber -->
 
            </div>
            <!-- /.container-fluid -->
        </nav>


    </header>
    <div class="col-md-2 row">

<!------------------- Start Demo Menu ------------------>
<?php
        //SIDEMENU CONFIGURATION FROM HELPER CLASS VISIT HELPER CLASS FOR  MORE details
       
        if(!empty($this->uri->segment(2))){
            $url = $this->uri->segment(2);
        }else{
            $url = $this->uri->segment(1);
        }
       // $url = $this->uri->segment(2);
	    $SideMenu_records = Fetch_Users_Access_Control_Menu($user_name['id']);
	    if($SideMenu_records != NULL)
	    {
		?>
                       <ul class="nav in sidebar-menu" id="side-menu">  
                            <?php
		 foreach ($SideMenu_records as  $obj_SideMenu_records) {
             if($obj_SideMenu_records->id == 26){
          $SideSubMenu_records = Fetch_Users_Access_Control_Sub_Menu($obj_SideMenu_records->id);
		?>
           <li class="treeview <?php
          foreach ($SideSubMenu_records as $obj_SideSubMenu_records){
            $pathe = $obj_SideSubMenu_records->link;
            preg_match("/[^\/]+$/",$pathe, $pathe);
             $last_word = $pathe[0]; // me7MYkA_zO0
           echo ($last_word == $url)?'active': '';
              }
           ?> ">
            <a href="#">
	          		<i class="<?php echo $obj_SideMenu_records->icon; ?> icon-settings" aria-hidden="true" > </i>
	              	
	               		<?php echo $obj_SideMenu_records->name; ?><i class="fa fa-angle-left pull-right"></i>
			    </a>
                <ul class="treeview-menu">
                     <?php
                  		//DEFINES TO FETCH THE ROLES ASSIGNED TO USER SUB MENU DATA mp_menulist TABLE
                  		$SideSubMenu_records = Fetch_Users_Access_Control_Sub_Menu($obj_SideMenu_records->id);
	                    if($SideSubMenu_records != NULL)
	                    {
	                        foreach ($SideSubMenu_records as $obj_SideSubMenu_records){   
                                $pathe = $obj_SideSubMenu_records->link;
                                preg_match("/[^\/]+$/",$pathe, $pathe);
                                 $last_word = $pathe[0]; // me7MYkA_zO0 
                                 ?>
                                <li class="<?php echo ($last_word == $url)?'activee': '';?>" > <a href="<?php echo base_url($obj_SideSubMenu_records->link);?>">
                                  <i class="fa fa-circle-o"></i> <?php echo $obj_SideSubMenu_records->title; ?></a>
                                </li>
                                <?php 
                  			}
                     	}
	                ?>
                        </ul>
                    </li>
   
                    <?php 
                        } }
                        /* for withourt dashboard */
                       

         foreach ($SideMenu_records as  $obj_SideMenu_records) {
             if($obj_SideMenu_records->id != 26){
                $SideSubMenu_records = Fetch_Users_Access_Control_Sub_Menu($obj_SideMenu_records->id);
		?>
          <li class="treeview <?php
          foreach ($SideSubMenu_records as $obj_SideSubMenu_records){
            $pathe = $obj_SideSubMenu_records->link;
            preg_match("/[^\/]+$/",$pathe, $pathe);
             $last_word = $pathe[0]; // me7MYkA_zO0
           echo ($last_word == $url)?'active': '';
              }
           ?> ">
            <a href="#">
	          		<i class="<?php echo $obj_SideMenu_records->icon; ?> icon-settings" aria-hidden="true" > </i>
	              	
	               		<?php echo $obj_SideMenu_records->name; ?><i class="fa fa-angle-left pull-right"></i>
			    </a>
                <ul class="treeview-menu">
                     <?php
                  		//DEFINES TO FETCH THE ROLES ASSIGNED TO USER SUB MENU DATA mp_menulist TABLE
                  		
	                    if($SideSubMenu_records != NULL)
	                    {
	                        foreach ($SideSubMenu_records as $obj_SideSubMenu_records) 
	                        { 
                                $pathe = $obj_SideSubMenu_records->link;
                                preg_match("/[^\/]+$/",$pathe, $pathe);
                                 $last_word = $pathe[0]; // me7MYkA_zO0 
                                 ?>
                                <li class="<?php echo ($last_word == $url)?'activee': '';?>" > <a href="<?php echo base_url($obj_SideSubMenu_records->link);?>">
                                  <i class="fa fa-circle-o"></i> <?php echo $obj_SideSubMenu_records->title; ?></a>
                                </li>
                                <?php 
                  			}
                     	}
	                ?>
                        </ul>
                    </li>
   
                    <?php 
                        } }
                        ?>
                        </ul>
                        <?php 
                        }
                        ?>
<!------------------- End Demo Menu ------------------>

                <!-- /.navbar-collapse -->
    <!-- End menu ber -->
            </div>
    <div class="col-md-10">

<script>
$(function() {
  var menuVisible = false;
  $('#responsiveicond').click(function() {
    if (menuVisible) {
      $('#side-menu').css({'display':'none'});
      menuVisible = false;
      return;
    }
    $('#side-menu').css({'display':'block'});
    menuVisible = true;
  });
});
</script>

<style>
@media only screen and (max-width: 870px) {
  .responsivetop {
    display:none;
  }
  .topmenushowhide {
    display:none;
  }
  
}

@media only screen and (max-width: 770px) {
  #side-menu {
    display:none;
  }
}

  @media only screen and (min-width: 772px) {
  #side-menu {
    display:block !important;
  }
  
}
.activee{background:#0a0909;}
.treeview-menu .activee a{ color:white !important;}

</style>