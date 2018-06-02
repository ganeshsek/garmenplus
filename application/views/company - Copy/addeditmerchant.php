<?php $this->load->view(CNFCOMPANY.'template/pageheader');?>
    <body class="sidebar-mini skin-black wysihtml5-supported sidebar-collapse" cz-shortcut-listen="true">
<div class="wrapper">
    <?php $this->load->view(CNFCOMPANY.'template/templateheader');?>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <?php $this->load->view(CNFCOMPANY.'template/templateleftmenu');?>
    </aside>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Add/Edit Merchant</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCOMPANY?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/managemerchant/">Manage Merchant</a></li>
                <li class="active">Add/Edit Merchant</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-2">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Company Info.</h3>
                            <div class="box-tools">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div class="box-body no-padding">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="javascript:void(0);" onclick="fnShowProfileCont('DivContBasicInfo');"><i class="fa fa-circle-o text-yellow"></i> Basic Information</a></li>
                                <li><a href="javascript:void(0);" onclick="fnShowProfileCont('DivContContactInfo');"><i class="fa fa-circle-o text-yellow"></i> Contact Details</a></li>
                            </ul>
                        </div><!-- /.box-body -->
                    </div><!-- /. box -->
                </div><!-- /.col -->
                <div class="col-md-10">
                    <div id="DivContBasicInfo">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Basic Information</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmMerchantInfo" id="frmMerchantInfo" method="post">
                                    <div id="divEditBasicInfo">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Merchant Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="frmBasicMerchantName" class="form-control" id="frmBasicMerchantName" placeholder="Merchant Name (Ex:Trends)" value="<?php echo @$ArrUserBasicInfo['merchantname'];?>">
                                                <div class="herr" id="ErrBasicMerchantName"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Address</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicAddress" class="form-control" id="frmBasicAddress" placeholder="Address" value="<?php echo @$ArrUserBasicInfo['address'];?>">
                                                    <div class="herr" id="ErrBasicAddress"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">City</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicCity" class="form-control" id="frmBasicCity" placeholder="City" value="<?php echo @$ArrUserBasicInfo['city'];?>">
                                                    <div class="herr" id="ErrBasicCity"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">State</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicState" class="form-control" id="frmBasicState" placeholder="State" value="<?php echo @$ArrUserBasicInfo['state'];?>">
                                                    <div class="herr" id="ErrBasicState"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Country</label>
                                                <div class="col-sm-8">
                                                    <select name="frmBasicCountry" id="frmBasicCountry" class="form-control">
                                                        <option value="">Choose the Country</option>
                                                        <?php
                                                        $ArrCountryList  = unserialize(ARRCOUNTRYLIST);
                                                        foreach($ArrCountryList as $VarCountryId=>$VarCountryName) {?>
                                                            <option value="<?php echo $VarCountryId?>"><?php echo $VarCountryName?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrBasicCountry"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Year of Foundation</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicYearFoundation" class="form-control" id="frmBasicYearFoundation" placeholder="Ex: 2012" value="<?php echo @$ArrUserBasicInfo['yearfoundation'];?>">
                                                    <div class="herr" id="ErrBasicEstYear"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                    <label for="inputEmail3" class="col-sm-4 control-label">Product Segment</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" name="frmBasicProductSegment" class="form-control" id="frmBasicProductSegment" cols="20" rows="4" value="<?php echo @$ArrUserBasicInfo['productsegment'];?>"></textarea>
                                                    <div class="herr" id="ErrBasicProductSegment"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Product Groups</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" name="frmBasicProductGroups" class="form-control" id="frmBasicProductGroups" cols="20" rows="4" value="<?php echo @$ArrUserBasicInfo['productgroups'];?>"></textarea>
                                                    <div class="herr" id="ErrBasicProductSegment"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Main Fabrics</label>
                                                <div class="col-sm-8">
                                                    <textarea type="text" name="frmBasicProductMainFabrics" class="form-control" id="frmBasicProductMainFabrics" cols="20" rows="4" value="<?php echo @$ArrUserBasicInfo['mainfabrics'];?>"></textarea>
                                                    <div class="herr" id="ErrBasicProductMainFabrics"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Daily Capacity</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicDailyCapacity" class="form-control" id="frmBasicDailyCapacity" placeholder="Ex: 122" value="<?php echo @$ArrUserBasicInfo['dailycapacity'];?>">
                                                    <div class="herr" id="ErrBasicDailyCapacity"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Certification</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicCertification" class="form-control" id="frmBasicDailyCapacity" placeholder="Ex: 122" value="<?php echo @$ArrUserBasicInfo['certification'];?>">
                                                    <div class="herr" id="ErrBasicCertification"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Merchant Profile</label>
                                                <div class="col-sm-8">
                                                    <textarea name="frmBasicProfile" id="frmBasicProfile" class="form-control"></textarea>
                                                    <div class="herr" id="ErrBasicProfile"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-default" >Cancel</button>
                                            <button type="submit" class="btn btn-info pull-right  addrights" onclick="return fnSaveMerchant();">Save Changes</button>
                                        </div><!-- /.box-footer -->
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /. box -->
                    </div>

                    <div id="DivContContactInfo" class="hide">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Contact Details</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-default btn-s addrights" href="javascript:void(0);" onclick="fnShowProfileCont('DivContAddContactInfo');"><i class="fa fa-edit"></i> Add Contact</a>
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div id="ResResult">
                                    <table id="example1" class="table table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>E-Mail Id</th>
                                            <th>Designation</th>
                                            <th>Mobile No.</th>
                                            <th>Phone</th>
                                            <th>Date Updated</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td>Raja</td>
                                            <td>raja@trends.com</td>
                                            <td>CEO</td>
                                            <td>983737333</td>
                                            <td>-</td>
                                            <td>13-06-2017 22:21:00</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="DivContAddContactInfo" class="hide">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Company Information</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmBasicInfo" id="frmBasicInfo" method="post">
                                    <div id="divEditBasicInfo">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="frmBasicContactName" class="form-control" id="frmBasicContactName" placeholder="Contact Name (Ex:Raja)" value="">
                                                <div class="herr" id="ErrBasicContactName"></div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">E-Mail Id</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmContactEmailId" class="form-control" id="frmContactEmailId" placeholder="E-Mail Id" value="">
                                                    <div class="herr" id="ErrContactEmailId"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Designation</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmContactDesignation" class="form-control" id="frmContactDesignation" placeholder="Ex: CEO" value="">
                                                    <div class="herr" id="ErrContactDesignation"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Mobile No.</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmContactMobileNo" class="form-control" id="frmContactMobileNo" placeholder="Ex: 9847647744" value="">
                                                    <div class="herr" id="ErrContactMobileNo"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Phone No.</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmContactPhoneNo" class="form-control" id="frmContactPhoneNo" placeholder="Ex: 9847647744" value="">
                                                    <div class="herr" id="ErrContactPhoneNo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-default" >Cancel</button>
                                            <button type="submit" class="btn btn-info pull-right  addrights" onclick="return fnSaveEmployee();">Save Changes</button>
                                        </div><!-- /.box-footer -->
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /. box -->
                    </div>

                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
    <?php $this->load->view(CNFCOMPANY.'template/templatefooter');?>
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<!-- DataTables -->
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/select2/select2.min.css">
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/plugins/select2/select2.full.min.js"></script>
<script language="javascript">
    $(document).ready(function() {
        $(".select2").select2();
    });
    var GlbNewUser		= "<?php echo @$VarNewUser;?>";
    var GlbUserId   	= "<?php echo @$VarUserId;?>";
</script>
<script src="<?php echo base_url();?>assets/js/companyprofile.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/js/commonfunctions.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<?php $this->load->view(CNFCOMPANY.'template/pagefooter');?>