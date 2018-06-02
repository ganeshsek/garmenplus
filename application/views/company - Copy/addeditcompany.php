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
            <h1>Add/Edit Company</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCOMPANY?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url().CNFCOMPANY?>cprofile/managecompany/">Manage Company</a></li>
                <li class="active">Add/Edit Company</li>
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
                                <h3 class="box-title">Company Information</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmBasicInfo" id="frmBasicInfo" method="post">
                                    <div id="divEditBasicInfo">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Company Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" name="frmBasicCompanyName" class="form-control" id="frmBasicCompanyName" placeholder="Company Name (Ex:Trends)" value="<?php echo @$ArrUserBasicInfo['companyname'];?>">
                                                <div class="herr" id="ErrBasicCompanyName"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 text-right">Business Type</label>
                                                <div class="col-sm-8">
                                                    <select name="frmBasicBusinessType" id="frmBasicBusinessType" class="form-control">
                                                        <option value="">Choose the Business Type</option>
                                                        <?php
                                                        $ArrBusinessTypeList  = unserialize(ARRCOMPANYBUSINESSTYPE);
                                                        foreach($ArrBusinessTypeList as $VarBusinessId=>$VarBusinessName) {?>
                                                            <option value="<?php echo $VarBusinessId?>"><?php echo $VarBusinessName?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
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
                                                <label for="inputEmail3" class="col-sm-4 control-label">Year of Established</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicEstYear" class="form-control" id="frmBasicEstYear" placeholder="Ex: 2012" value="<?php echo @$ArrUserBasicInfo['estyear'];?>">
                                                    <div class="herr" id="ErrBasicEstYear"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Factory Ownership</label>
                                                <div class="col-sm-8">
                                                    <select name="frmBasicOwnershipFactory" id="frmBasicOwnershipFactory" class="form-control">
                                                        <option value="">Choose the Ownership Factory</option>
                                                        <?php
                                                        $ArrOwnerFactoryList  = unserialize(ARROWNERSHIPFACTORY);
                                                        foreach($ArrOwnerFactoryList as $VarOwnershipId=>$VarOwnershipName) {?>
                                                            <option value="<?php echo $VarOwnershipId?>"><?php echo $VarOwnershipName?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrBasicOwnershipFactory"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Factory Size in Meter(s)</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicFactorySize" class="form-control" id="frmBasicFactorySize" placeholder="Ex: 12" value="<?php echo @$ArrUserBasicInfo['factorysize'];?>">
                                                    <div class="herr" id="ErrBasicFactorySize"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Types of Plant & Machinery in Factory</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicTypesPlant" class="form-control" id="frmBasicTypesPlant" placeholder="" value="<?php echo @$ArrUserBasicInfo['typesplant'];?>">
                                                    <div class="herr" id="ErrBasicTypesPlant"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Number of Subcontractors</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicNoOfSubContract" class="form-control" id="frmBasicNoOfSubContract" placeholder="Ex: 12" value="<?php echo @$ArrUserBasicInfo['noofcontract'];?>">
                                                    <div class="herr" id="ErrBasicNoOfSubContract"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Major Customers</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmBasicMajorCustomer" class="form-control" id="frmBasicMajorCustomer" placeholder="Ex: 12" value="<?php echo @$ArrUserBasicInfo['majorcustomer'];?>">
                                                    <div class="herr" id="ErrBasicMajorCustomer"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Past Export Markets/Country</label>
                                                <div class="col-sm-8">
                                                    <select name="frmBasicPastExport" id="frmBasicPastExport" class="form-control select2" multiple>
                                                        <option value="">Choose the Country</option>
                                                        <?php
                                                        $ArrCountryList  = unserialize(ARRCOUNTRYLIST);
                                                        foreach($ArrCountryList as $VarCountryId=>$VarCountryName) {?>
                                                            <option value="<?php echo $VarCountryId?>"><?php echo $VarCountryName?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrBasicPastExport"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Company Profile</label>
                                                <div class="col-sm-8">
                                                    <textarea name="frmBasicProfile" id="frmBasicProfile" class="form-control"></textarea>
                                                    <div class="herr" id="ErrBasicProfile"></div>
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