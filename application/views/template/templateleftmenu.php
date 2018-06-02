<?php
$ArrProfileInfo				= fnGetUserLoggedInfo(1);
$VarUserType				= $ArrProfileInfo['usertype'];
$VarProfilePermission		= $ArrProfileInfo['pp'];
?>
<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  <ul class="sidebar-menu">
		<li class="header">MAIN NAVIGATION</li>
		<?php if($VarUserType==1) {?>
			<li class="treeview">
				<a href="<?php echo base_url()?>dashboard/">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa"></i>
				</a>
			</li>
			<?php if($VarProfilePermission==1) {?>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-users"></i> <span>Manage Employee</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url()?>profile/manageemployee/"><i class="fa fa-circle-o"></i> Employee List</a></li>
					</ul>
				</li>
			<?php }?>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-building-o"></i> <span>Manage Schools</span>
				  <i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
				  <li><a href="<?php echo base_url()?>schools/manageschools/"><i class="fa fa-circle-o"></i> Schools List</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa  fa-graduation-cap"></i> <span>Manage Assessment Test</span>
					<i class="fa fa-angle-left pull-right"></i>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url()?>assessment/manageassessmenttest/"><i class="fa fa-circle-o"></i> Assessment Test List</a></li>
					<li><a href="<?php echo base_url()?>assessment/manageassignedlist/"><i class="fa fa-circle-o"></i> Assigned Test List</a></li>
				</ul>
			</li>
		<?php } ?>
	  </ul>
	</section>
	<!-- /.sidebar -->