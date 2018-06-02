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
						<li><a href="<?php echo base_url().CNFCADMIN?>profile/manageemployee/"><i class="fa fa-circle-o"></i> Employee List</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-building-o"></i> <span>Manage Company</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url().CNFCADMIN?>company/managecompany/"><i class="fa fa-circle-o"></i> Company List</a></li>
					</ul>
				</li>
				<li class="treeview">
					<a href="#">
						<i class="fa fa-gears"></i> <span>Configuration</span>
						<i class="fa fa-angle-left pull-right"></i>
					</a>
					<ul class="treeview-menu">
						<li>
							<a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 1 <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="<?php echo base_url().CNFCADMIN?>mdyeingmethod/managedyeingmethod/"><i class="fa fa-circle-o"></i> Dyeing Method</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mfabrictype/managefabrictypes/"><i class="fa fa-circle-o"></i> Fabrics Type</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mprinttype/manageprinttype/"><i class="fa fa-circle-o"></i> Print Type</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>membelltype/manageembelltype/"><i class="fa fa-circle-o"></i> Embell Type</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>munitmeasure/manageunitmeasure/"><i class="fa fa-circle-o"></i> Unit of Measure</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mtrimmingtype/managetrimmingtype/"><i class="fa fa-circle-o"></i> Trimming Type</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>msewingtrimmingtype/managesewingtrimmingtype/"><i class="fa fa-circle-o"></i> Sewing Trimming</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mseason/manageseason/"><i class="fa fa-circle-o"></i> Season</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mgarmenttype/managegarmenttype/"><i class="fa fa-circle-o"></i> Garment Type</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>msizerange/managesizerange/"><i class="fa fa-circle-o"></i> Size Range</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mpackingcode/managepackingcode/"><i class="fa fa-circle-o"></i> Packing Code</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mport/manageport/"><i class="fa fa-circle-o"></i> Port</a></li>
							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 2 <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="<?php echo base_url().CNFCADMIN?>mastersetup/managecategory/"><i class="fa fa-circle-o"></i> Category</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mdsr/managedsr/"><i class="fa fa-circle-o"></i> Dyeing Special Req.</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mwpg/managewpg/"><i class="fa fa-circle-o"></i> Wet Processing - <br>Greige</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mdpf/managedpf/"><i class="fa fa-circle-o"></i> Dry Processing - <br>Finishing</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mfwd/managefwd/"><i class="fa fa-circle-o"></i> Fabric Wash Details</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mgwd/managegwd/"><i class="fa fa-circle-o"></i> Garment Wash <br>Details</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mprocessflow/manageprocessflow/"><i class="fa fa-circle-o"></i> Process Flow</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mapproval/manageapproval/"><i class="fa fa-circle-o"></i> Approval</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mlab/managelab/"><i class="fa fa-circle-o"></i> Lab</a></li>

							</ul>
						</li>
						<li>
							<a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 3 <i class="fa fa-angle-left pull-right"></i></a>
							<ul class="treeview-menu">
								<li><a href="<?php echo base_url().CNFCADMIN?>mclass/manageclass/"><i class="fa fa-circle-o"></i> Class List</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mcontent/managecontent/"><i class="fa fa-circle-o"></i> Content List</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mgpd/managegpd/"><i class="fa fa-circle-o"></i> Garment Part Desc.</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>maccessories/manageaccessories/"><i class="fa fa-circle-o"></i> Accessories</a></li>
								<li><a href="<?php echo base_url().CNFCADMIN?>mpackingmaterial/managepackingmaterial/"><i class="fa fa-circle-o"></i> Packing Material</a></li>
							</ul>
						</li>
					</ul>
				</li>
			<?php }?>

		<?php } ?>
	  </ul>
	</section>
	<!-- /.sidebar -->