<?php $this->load->view(CNFCADMIN.'template/pageheader');?>
    <body class="sidebar-mini skin-black wysihtml5-supported sidebar-collapse" cz-shortcut-listen="true">
<div class="wrapper">
    <?php $this->load->view(CNFCADMIN.'template/templateheader');?>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <?php $this->load->view(CNFCADMIN.'template/templateleftmenu');?>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Add/Edit Trimming Type</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCADMIN?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url().CNFCADMIN?>mtrimmingtype/managetrimmingtype/">Manage Trimming Type</a></li>
                <li class="active">Add/Edit Trimming Type</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div id="DivContBasicInfo">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Basic Information</h3>
                                <div class="box-tools pull-right">
                                    <?php if($VarNew==0) {?>
                                        <a class="btn btn-default btn-s addrights" href="javascript:void(0);" onclick="fnShowHideEndUserSub(1,'divEditBasicInfo');"><i class="fa fa-edit"></i> Edit</a>
                                    <?php }?>
                                </div>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmBasicInfo" id="frmBasicInfo" method="post">
                                    <div id="divEditBasicInfo" class="<?php if($VarNew==1) {?>show<?php } else {?>hide<?php }?>">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="frmBasicTrimmingName" class="form-control" id="frmBasicTrimmingName" placeholder="Trimming Type" value="<?php echo @$ArrBasicInfo['trimmingname'];?>">
                                                <div class="herr" id="ErrBasicTrimmingName"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Status</label>
                                            <div class="col-sm-10">
                                                <select name="frmBasicStatus" id="frmBasicStatus" class="form-control">
                                                    <option value="">Choose the Status</option>
                                                    <?php
                                                    $ArrStatus  = unserialize(ARRSTATUS);
                                                    unset($ArrStatus[3]);
                                                    foreach($ArrStatus as $VarKey=>$VarStatus) {?>
                                                        <option value="<?php echo $VarKey?>" <?php if(@$ArrBasicInfo['status']==$VarKey) {echo "selected";}?>><?php echo $VarStatus?></option>
                                                    <?php }?>
                                                </select>
                                                <div class="herr" id="ErrBasicStatus"></div>
                                            </div>
                                        </div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-default" onclick="fnShowHideEndUserSub(1,'divShowBasicInfo');">Cancel</button>
                                            <button type="submit" class="btn btn-info pull-right  addrights" onclick="return fnSaveTrimmingTypeInfo();">Save Changes</button>
                                        </div><!-- /.box-footer -->
                                    </div>
                                    <div id="divShowBasicInfo" class="<?php if($VarNew==1) {?>hide<?php }?>">
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 text-right">Name</label>
                                            <div class="col-sm-10" id="divDispBasicName">
                                                <?php echo @$ArrBasicInfo['trimmingname'];?>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 text-right">Status</label>
                                            <div class="col-sm-10"  id="divDispStatus">
                                                <?php
                                                echo @$ArrStatus[$ArrBasicInfo['status']];
                                                ?>
                                            </div>
                                        </div><!-- /.form-group -->
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /. box -->
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php $this->load->view(CNFCADMIN.'template/templatefooter');?>
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<!-- DataTables -->
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script language="javascript">
    var GlbNewUser		        = "<?php echo @$VarNew;?>";
    var GlbId          	        = "<?php echo @$VarId;?>";
</script>
<script src="<?php echo base_url();?>assets/js/<?php echo CNFCADMIN?>/mtrimmingtype.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/js/commonfunctions.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<?php $this->load->view(CNFCADMIN.'template/pagefooter');?>