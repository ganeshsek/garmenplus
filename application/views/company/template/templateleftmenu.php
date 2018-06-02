<?php
$ArrProfileInfo				= fnGetUserLoggedInfo(1);
$VarUserType				= $ArrProfileInfo['usertype'];
$VarProfilePermission		= $ArrProfileInfo['pp'];
?>
<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
	  <ul class="sidebar-menu">
		<li class="header">MAIN NAVIGATION</li>
		<li class="treeview">
			<a href="<?php echo base_url()?>dashboard/">
				<i class="fa fa-dashboard"></i> <span>Dashboard</span> <i class="fa"></i>
			</a>
		</li>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-users"></i> <span>Manage Merchant/User</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managemerchant/"><i class="fa fa-circle-o"></i> Merchant List</a></li>
				<li><a href="<?php echo base_url().CNFCOMPANY?>profile/manageusers/"><i class="fa fa-circle-o"></i> User(s) List</a></li>
				<li><a href="<?php echo base_url().CNFCOMPANY?>managerole/manageroles/"><i class="fa fa-circle-o"></i> Role(s) List</a></li>
			</ul>
		</li>
		  <li class="treeview">
			  <a href="#">
				  <i class="fa fa-shopping-cart"></i> <span>Manage Orders</span>
				  <i class="fa fa-angle-left pull-right"></i>
			  </a>
			  <ul class="treeview-menu">
				  <li><a href="<?php echo base_url().CNFCOMPANY?>order/manageorders/"><i class="fa fa-circle-o"></i> Orders List</a></li>
			  </ul>
		  </li>
		<!--<li class="treeview">
			<a href="#">
				<i class="fa fa-gears"></i> <span>Configuration</span>
				<i class="fa fa-angle-left pull-right"></i>
			</a>
			<ul class="treeview-menu">
				<li>
					<a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 1 <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managedyeingmethod/"><i class="fa fa-circle-o"></i> Dyeing Method</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managefabrictype/"><i class="fa fa-circle-o"></i> Fabrics Type</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageprinttype/"><i class="fa fa-circle-o"></i> Print Type</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageembelltype/"><i class="fa fa-circle-o"></i> Embell Type</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageunitmeasure/"><i class="fa fa-circle-o"></i> Unit of Measure</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managetrimmingtype/"><i class="fa fa-circle-o"></i> Trimming Type</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managesewingtrimmingtype/"><i class="fa fa-circle-o"></i> Sewing Trimming</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageseason/"><i class="fa fa-circle-o"></i> Season</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managegarmenttype/"><i class="fa fa-circle-o"></i> Garment Type</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managesizerange/"><i class="fa fa-circle-o"></i> Size Range</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managepackingcode/"><i class="fa fa-circle-o"></i> Packing Code</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageport/"><i class="fa fa-circle-o"></i> Port</a></li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 2 <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managecategory/"><i class="fa fa-circle-o"></i> Category</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managedsr/"><i class="fa fa-circle-o"></i> Dyeing Special Req.</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managewpg/"><i class="fa fa-circle-o"></i> Wet Processing - <br>Greige</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managedpf/"><i class="fa fa-circle-o"></i> Dry Processing - <br>Finishing</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managefwd/"><i class="fa fa-circle-o"></i> Fabric Wash Details</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managegwd/"><i class="fa fa-circle-o"></i> Garment Wash <br>Details</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageprocessflow/"><i class="fa fa-circle-o"></i> Process Flow</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageapproval/"><i class="fa fa-circle-o"></i> Approval</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managelab/"><i class="fa fa-circle-o"></i> Lab</a></li>
					</ul>
				</li>
				<li>
					<a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 3 <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managedepartment/"><i class="fa fa-circle-o"></i> Department List</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageclass/"><i class="fa fa-circle-o"></i> Class List</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managecontent/"><i class="fa fa-circle-o"></i> Content List</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managegpd/"><i class="fa fa-circle-o"></i> Garment Part Desc.</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/manageaccessories/"><i class="fa fa-circle-o"></i> Accessories</a></li>
						<li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managepackingmaterial/"><i class="fa fa-circle-o"></i> Packing Material</a></li>
					</ul>
				</li>

			</ul>
		</li>-->
		  <li class="treeview">
			  <a href="#">
				  <i class="fa fa-gears"></i> <span>Configuration</span>
				  <i class="fa fa-angle-left pull-right"></i>
			  </a>
			  <ul class="treeview-menu">
				  <li>
					  <a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 1 <i class="fa fa-angle-left pull-right"></i></a>
					  <ul class="treeview-menu">
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mdyeingmethod/managedyeingmethod/"><i class="fa fa-circle-o"></i> Dyeing Method</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mfabrictype/managefabrictypes/"><i class="fa fa-circle-o"></i> Fabrics Type</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mprinttype/manageprinttype/"><i class="fa fa-circle-o"></i> Print Type</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>membelltype/manageembelltype/"><i class="fa fa-circle-o"></i> Embell Type</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>munitmeasure/manageunitmeasure/"><i class="fa fa-circle-o"></i> Unit of Measure</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mtrimmingtype/managetrimmingtype/"><i class="fa fa-circle-o"></i> Trimming Type</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>msewingtrimmingtype/managesewingtrimmingtype/"><i class="fa fa-circle-o"></i> Sewing Trimming</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mseason/manageseason/"><i class="fa fa-circle-o"></i> Season</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mgarmenttype/managegarmenttype/"><i class="fa fa-circle-o"></i> Garment Type</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>msizerange/managesizerange/"><i class="fa fa-circle-o"></i> Size Range</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mpackingcode/managepackingcode/"><i class="fa fa-circle-o"></i> Packing Code</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mport/manageport/"><i class="fa fa-circle-o"></i> Port</a></li>
					  </ul>
				  </li>
				  <li>
					  <a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 2 <i class="fa fa-angle-left pull-right"></i></a>
					  <ul class="treeview-menu">
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managecategory/"><i class="fa fa-circle-o"></i> Category</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mdsr/managedsr/"><i class="fa fa-circle-o"></i> Dyeing Special Req.</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mwpg/managewpg/"><i class="fa fa-circle-o"></i> Wet Processing - <br>Greige</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mdpf/managedpf/"><i class="fa fa-circle-o"></i> Dry Processing - <br>Finishing</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mfwd/managefwd/"><i class="fa fa-circle-o"></i> Fabric Wash Details</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mgwd/managegwd/"><i class="fa fa-circle-o"></i> Garment Wash <br>Details</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mprocessflow/manageprocessflow/"><i class="fa fa-circle-o"></i> Process Flow</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mapproval/manageapproval/"><i class="fa fa-circle-o"></i> Approval</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mlab/managelab/"><i class="fa fa-circle-o"></i> Lab</a></li>

					  </ul>
				  </li>
				  <li>
					  <a href="#"><i class="fa fa-circle-o"></i> Master Data Conf. 3 <i class="fa fa-angle-left pull-right"></i></a>
					  <ul class="treeview-menu">
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mclass/manageclass/"><i class="fa fa-circle-o"></i> Class List</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mcontent/managecontent/"><i class="fa fa-circle-o"></i> Content List</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mgpd/managegpd/"><i class="fa fa-circle-o"></i> Garment Part Desc.</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>maccessories/manageaccessories/"><i class="fa fa-circle-o"></i> Accessories</a></li>
						  <li><a href="<?php echo base_url().CNFCOMPANY?>mpackingmaterial/managepackingmaterial/"><i class="fa fa-circle-o"></i> Packing Material</a></li>
					  </ul>
				  </li>
			  </ul>
		  </li>
		
	  </ul>
	</section>
	<!-- /.sidebar -->