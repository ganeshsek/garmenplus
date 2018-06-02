<?php
$ArrProfileInfo	= fnGetUserLoggedInfo(1);
?>
<header class="main-header">
	<!-- Logo -->
	<a href="<?php echo base_url()?>" class="logo">
	  <!-- logo for regular state and mobile devices -->
		<img src="<?php echo base_url()?>assets/img/Logo.png" height="45">
	</a>
	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top" role="navigation">
	  <!-- Sidebar toggle button-->
	  <!--<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
		<span class="sr-only">Toggle navigation</span>
	  </a>-->
	  <div class="navbar-custom-menu">
		<ul class="nav navbar-nav">             
		  <!-- User Account: style can be found in dropdown.less -->
		  <li class="dropdown user user-menu">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php if(@$ArrProfileInfo['pimg']<>'') {?>
					<img src="<?php echo base_url();?>uploads/employee/profile/<?php echo @$ArrProfileInfo['pimg']?>" class="user-image" alt="User Image">
				<?php } else {?>
					<img src="<?php echo base_url();?>assets/img/avatar5.png" class="user-image" alt="User Image">
				<?php }?>
				<span class="hidden-xs"><?php echo @$ArrProfileInfo['name']?></span>
			</a>
			<ul class="dropdown-menu">
			  <!-- User image -->
			  <li class="user-header">				
				<?php if(@$ArrProfileInfo['pimg']<>'') {?>
					<img src="<?php echo base_url();?>uploads/employee/profile/<?php echo @$ArrProfileInfo['pimg']?>" class="img-circle" alt="User Image">
				<?php } else {?>
					<img src="<?php echo base_url();?>assets/img/avatar5.png" class="img-circle" alt="User Image">
				<?php }?>				
				<p>
					<?php if(@$ArrProfileInfo['usertype']==1) {?>
						<!--<a href="<?php echo base_url()?>crm/profile/myprofile/" class="btn btn-default btn-flat">My Profile</a>-->
					<?php }?>
				</p>
			  </li>
			  <!-- Menu Body -->
			  <!-- <li class="user-body">
				<div class="col-xs-12 text-center">
				  <a href="#">Change Password</a>
				</div>
			  </li> -->
			  <!-- Menu Footer-->
			  <li class="user-footer">
				<div class="pull-left">
					<a href="<?php echo base_url()?>profile/changepassword/" class="btn btn-default btn-flat">Change Password</a>
				</div>
				<div class="pull-right">
				  <a href="<?php echo base_url()?>login/signout/" class="btn btn-default btn-flat">Sign out</a>
				</div>
			  </li>
			</ul>
		  </li>
		  <!-- Control Sidebar Toggle Button -->              
		</ul>
	  </div>
	</nav>
  </header>