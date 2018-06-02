<?php $this->load->view('template/pageheader');?>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
	  <div class="login-logo" style="margin-left:-20px;">
		  <a href="javascript:void(0);"><?php echo COMPANYNAME?></a>
	  </div><!-- /.login-logo -->
  </div><!-- /.login-logo -->
  <div class="login-box-body">
	<div id="divLoginBox">
		<p class="login-box-msg"><b>LOGIN</b></p>
		<form method="post" method="post" name="frmNameLogin" id="frmNameLogin">
		  <div class="herr" id="ErrLoginMsg"></div>
		  <div class="form-group has-feedback">
			<input type="email" name="frmEmail" id="frmEmail" class="form-control" placeholder="Email">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			<div id="ErrEmail" class="herr"></div>
		  </div>
		  <div class="form-group has-feedback">
			<input type="password" name="frmPass" id="frmPass" class="form-control" placeholder="Password">
			<span class="glyphicon glyphicon-lock form-control-feedback"></span>
		  </div>
		  <div class="">
				<input type="checkbox" name="frmLoginRememberMe" id="frmLoginRememberMe">&nbsp;<label for="frmLoginRememberMe">Remember Me</label>
		  </div>
		  <div class="row">
			<div class="col-xs-8">
			  
			</div><!-- /.col -->
			<div class="col-xs-4">
			  <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="return fnLogin();">Sign In</button>
			</div><!-- /.col -->
		  </div>
		</form>
		<!--<a href="javascript:void(0);" onclick="fnShowLoginBox(2);">I forgot my password</a><br>-->
	</div>
	<div id="divFPBox" class="hide">
		<p class="login-box-msg"><b>FORGOT PASSWORD</b></p>
		<form method="post" method="post" name="frmNameForgotPass" id="frmNameForgotPass">
		  <div class="successmsg" id="ErrForgotPassMsg"></div>
		  <div class="form-group has-feedback">
			<input type="email" name="frmFPEmail" id="frmFPEmail" class="form-control" placeholder="Email">
			<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			<div id="ErrFPEmail" class="herr"></div>
		  </div>
		  <div class="row">
			<div class="col-xs-8">
			  
			</div><!-- /.col -->
			<div class="col-xs-4">
			  <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="return fnForgotPass();">Submit</button>
			</div><!-- /.col -->
		  </div>
		</form>
		<a href="javascript:void(0);" onclick="fnShowLoginBox(1);">Back to Login</a><br>
	</div>
  </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
<script src="<?php echo base_url();?>assets/js/ajax.js"></script>
<script src="<?php echo base_url();?>assets/js/commonfunctions.js"></script>
<script src="<?php echo base_url();?>assets/js/login.js"></script>
<?php $this->load->view('template/pagefooter');?>