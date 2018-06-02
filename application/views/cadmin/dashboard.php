<?php
$this->load->view('cadmin/template/pageheader');
$ArrLoggedUserInfo      = fnGetUserLoggedInfo(1);
$VarUserType            = $ArrLoggedUserInfo['usertype'];
$VarProfilePermission   = $ArrLoggedUserInfo['pp'];
$ArrUserDetails         = fnGetUserLoggedInfo();
?>
<body class="sidebar-mini skin-black wysihtml5-supported sidebar-collapse" cz-shortcut-listen="true">
<div class="wrapper">
  <?php $this->load->view('cadmin/template/templateheader');?>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
  <?php $this->load->view('cadmin/template/templateleftmenu');?>
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<section class="content-header">
	  <h1>
		Dashboard
		<small>Control panel</small>
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Dashboard</li>
	  </ol>
	</section>
	<section class="content">
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 pdl0">
				<div class="col-md-12 col-sm-12 col-xs-12 col-lg-12 pdl0">

				</div>
			</div>
		</div>
	</section>
  </div><!-- /.content-wrapper -->
  <?php $this->load->view('cadmin/template/templatefooter');?>
  <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<?php $this->load->view('cadmin/template/pagefooter');?>