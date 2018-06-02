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
            <h1>Add/Edit Company</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCADMIN?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url().CNFCADMIN?>company/managecompany/">Manage Company</a></li>
                <li class="active">Add/Edit Company</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-3">
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
                                <?php if($VarNewCompany==0) {?>
                                    <li><a href="javascript:void(0);" onclick="fnShowProfileCont('DivContContactInfo');fnListCompanyContact();"><i class="fa fa-circle-o text-yellow"></i> Contact Details</a></li>
                                    <li><a href="javascript:void(0);" onclick="fnShowProfileCont('DivContPlantMachineInfo');fnListCompanyMachine();"><i class="fa fa-circle-o text-yellow"></i> Plant & Machinery Details</a></li>
                                <?php }?>
                            </ul>
                        </div><!-- /.box-body -->
                    </div><!-- /. box -->
                </div><!-- /.col -->
                <div class="col-md-9">

                    <div id="DivContBasicInfo">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Company Information</h3>
                                <div class="box-tools pull-right">
                                    <?php if($VarNewCompany==0) {?>
                                        <a class="btn btn-default btn-s addrights" href="javascript:void(0);" onclick="fnShowHideEndUserSub(1,'divEditBasicInfo');"><i class="fa fa-edit"></i> Edit</a>
                                    <?php }?>
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmBasicInfo" id="frmBasicInfo" method="post">
                                    <div id="divEditBasicInfo" class="<?php if($VarNewCompany==0) {?>hide<?php } else {?>show<?php }?>">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label" style="width:21%">Company Name</label>
                                            <div class="col-sm-9" style="width:77.5%">
                                                <input type="text" name="frmBasicCompanyName" class="form-control" id="frmBasicCompanyName" placeholder="Company Name (Ex:Trends)" value="<?php echo @$ArrCompanyBasicInfo['companyname'];?>">
                                                <div class="herr" id="ErrBasicCompanyName"></div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Business Type</label>
                                                <div class="col-sm-7">
                                                    <select name="frmBasicBusinessType" id="frmBasicBusinessType" class="form-control">
                                                        <option value="">Choose the Business Type</option>
                                                        <?php
                                                        $ArrBusinessTypeList  = unserialize(ARRCOMPANYBUSINESSTYPE);
                                                        foreach($ArrBusinessTypeList as $VarBusinessId=>$VarBusinessName) {?>
                                                            <option value="<?php echo $VarBusinessId?>" <?php if($VarBusinessId==@$ArrCompanyBasicInfo['businesstype']) {echo "selected";}?>><?php echo $VarBusinessName?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Factory Size in Sq.ft</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicFactorySize" class="form-control" id="frmBasicFactorySize" placeholder="Ex: 12" value="<?php echo @$ArrCompanyBasicInfo['factorysize'];?>">
                                                    <div class="herr" id="ErrBasicFactorySize"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Address</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicAddress" class="form-control" id="frmBasicAddress" placeholder="Address" value="<?php echo @$ArrCompanyBasicInfo['address'];?>">
                                                    <div class="herr" id="ErrBasicAddress"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">No.Of Machine</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicNoOfMachine" class="form-control" id="frmBasicNoOfMachine" placeholder="No.of Machine" value="<?php echo @$ArrCompanyBasicInfo['noofmachine'];?>">
                                                    <div class="herr" id="ErrBasicNoOfMachine"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">City</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicCity" class="form-control" id="frmBasicCity" placeholder="City" value="<?php echo @$ArrCompanyBasicInfo['city'];?>">
                                                    <div class="herr" id="ErrBasicCity"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Production Capacity Per Day (Single Shift)
                                                </label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicProductCapacity" class="form-control" id="frmBasicProductCapacity" placeholder="Product Capcity" value="<?php echo @$ArrCompanyBasicInfo['productioncapacity'];?>">
                                                    <div class="herr" id="ErrBasicProductCapacity"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">State</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicState" class="form-control" id="frmBasicState" placeholder="State" value="<?php echo @$ArrCompanyBasicInfo['state'];?>">
                                                    <div class="herr" id="ErrBasicState"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Annual Turnover (Last 3 Years)
                                                </label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicAnnualTurnOver" class="form-control" id="frmBasicAnnualTurnOver" placeholder="Annual Turnover" value="<?php echo @$ArrCompanyBasicInfo['annualturnover'];?>">
                                                    <div class="herr" id="ErrBasicAnnualTurnOver"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Country</label>
                                                <div class="col-sm-7">
                                                    <select name="frmBasicCountry" id="frmBasicCountry" class="form-control">
                                                        <option value="">Choose the Country</option>
                                                        <?php
                                                        $ArrCountryList  = unserialize(ARRCOUNTRYLIST);
                                                        foreach($ArrCountryList as $VarCountryId=>$VarCountryName) {?>
                                                            <option value="<?php echo $VarCountryId?>" <?php if($VarCountryId==@$ArrCompanyBasicInfo['country']) {echo "selected";}?>><?php echo $VarCountryName?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrBasicCountry"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">No. Of Employees (Permanent)
                                                </label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicNoOfEmployee" class="form-control" id="frmBasicNoOfEmployee" placeholder="Annual Turnover" value="<?php echo @$ArrCompanyBasicInfo['noofemployee'];?>">
                                                    <div class="herr" id="ErrBasicNoOfEmployee"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">ZIP/Pin Code</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicZipcode" class="form-control" id="frmBasicZipcode" placeholder="Ex: 603020" value="<?php echo @$ArrCompanyBasicInfo['zipcode'];?>">
                                                    <div class="herr" id="ErrBasicZipcode"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">No. Of Contract Workers
                                                </label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicContractWorker" class="form-control" id="frmBasicContractWorker" placeholder="" value="<?php echo @$ArrCompanyBasicInfo['noofcontract'];?>">
                                                    <div class="herr" id="ErrBasicContractWorker"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Factory Ownership</label>
                                                <div class="col-sm-7">
                                                    <select name="frmBasicOwnershipFactory" id="frmBasicOwnershipFactory" class="form-control">
                                                        <option value="">Choose the Ownership Factory</option>
                                                        <?php
                                                        $ArrOwnerFactoryList  = unserialize(ARRCOMPANYFACTORYOWNERSHIP);
                                                        foreach($ArrOwnerFactoryList as $VarOwnershipId=>$VarOwnershipName) {?>
                                                            <option value="<?php echo $VarOwnershipId?>" <?php if($VarOwnershipId==@$ArrCompanyBasicInfo['factoryownership']) {echo "selected";}?>><?php echo $VarOwnershipName?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrBasicOwnershipFactory"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Major Customer</label>
                                                <div class="col-sm-7">
                                                    <textarea name="frmBasicMajorCustomer" class="form-control" id="frmBasicMajorCustomer" placeholder="" ><?php echo @$ArrCompanyBasicInfo['majorcustomer'];?></textarea>
                                                    <div class="herr" id="ErrBasicMajorCustomer"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Year of Established</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicEstYear" class="form-control" id="frmBasicEstYear" placeholder="Ex: 2012" value="<?php echo @$ArrCompanyBasicInfo['yearofest'];?>">
                                                    <div class="herr" id="ErrBasicEstYear"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Major Export Customer</label>
                                                <div class="col-sm-7">
                                                    <textarea name="frmBasicMajorExportCustomer" class="form-control" id="frmBasicMajorExportCustomer" placeholder="" ><?php echo @$ArrCompanyBasicInfo['exportcustomer'];?></textarea>
                                                    <div class="herr" id="ErrBasicMajorExportCustomer"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Company Profile</label>
                                                <div class="col-sm-7">
                                                    <textarea name="frmBasicProfile" id="frmBasicProfile" class="form-control"><?php echo @$ArrCompanyBasicInfo['companyprofile'];?></textarea>
                                                    <div class="herr" id="ErrBasicProfile"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="clearfix"></div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-default" onclick="fnShowHideEndUserSub(1,'divViewBasicInfo')">Cancel</button>
                                            <button type="submit" class="btn btn-info pull-right  addrights" onclick="return fnSaveCompanyBasicInfo();">Save Changes</button>
                                        </div><!-- /.box-footer -->
                                    </div>

                                    <div id="divViewBasicInfo" class="<?php if($VarNewCompany==0) {?>show<?php } else {?>hide<?php }?>">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 text-right" style="width:21%">Company Name</label>
                                            <div class="col-sm-9" style="width:77.5%">
                                               <?php echo @$ArrCompanyBasicInfo['companyname']?>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Business Type</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrBusinessTypeList[$ArrCompanyBasicInfo['businesstype']]?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Factory Size in Sq.ft</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['factorysize']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Address</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['address']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">No.Of Machine</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['noofmachine']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">City</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['city']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Production Capacity Per Day (Single Shift)
                                                </label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['productioncapacity']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">State</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['state']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Annual Turnover (Last 3 Years)
                                                </label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['annualturnover']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Country</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCountryList[$ArrCompanyBasicInfo['country']]?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">No. Of Employees (Permanent)
                                                </label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['noofemployee']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">ZIP/Pin Code</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['zipcode']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">No. Of Contract Workers
                                                </label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['noofcontract']?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Factory Ownership</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrOwnerFactoryList[$ArrCompanyBasicInfo['factoryownership']]?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Major Customer</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['majorcustomer']?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Year of Established</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['yearofest']?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Major Export Customer</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['exportcustomer']?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Company Profile</label>
                                                <div class="col-sm-7">
                                                    <?php echo @$ArrCompanyBasicInfo['companyprofile']?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /. box -->
                    </div>

                    <div id="DivContPlantMachineInfo" class="hide">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Plant & Machinery Details</h3>
                                <div class="box-tools pull-right">
                                    <a class="btn btn-default btn-s addrights" href="javascript:void(0);" onclick="fnShowProfileCont('DivContAddPlantMachineInfo');"><i class="fa fa-edit"></i> Add Plant & Machinery Details</a>
                                </div><!-- /.box-tools -->
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div id="ResMachineListCnt"></div>
                                <div id="ResMachineList"></div>
                                <div>
                                    <section id="pagination_my" class="animated for_animate pdl15 pdb15"><ul class="pagination m-b-none animated for_animate" id="ResMachinePagination"></ul></section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="DivContAddPlantMachineInfo" class="hide">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Plant & Machinery Details</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmBasicMachineInfo" id="frmBasicMachineInfo" method="post">
                                    <div id="divEditBasicInfo">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessMachineInfoMsg"></div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Type</label>
                                                <div class="col-sm-8">
                                                    <select name="frmMachineFlag" id="frmMachineFlag" class="form-control" onchange="fnChangeMachineFlag(this.value)">
                                                        <option value=""></option>
                                                        <?php
                                                        $ArrMachinePlantType    = unserialize(ARRPLANTMACHINETYPE);
                                                        foreach($ArrMachinePlantType as $VarMachineId=>$VarMachineTableName){?>
                                                            <option value="<?php echo $VarMachineId?>"><?php echo $VarMachineTableName;?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrMachineType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0 hide" id="divMachineTypeInfo">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Machine Type</label>
                                                <div class="col-sm-8">
                                                    <select name="frmMachineType" id="frmMachineType" class="form-control">
                                                        <option value=""></option>
                                                        <?php
                                                        $ArrMachinePlantType    = unserialize(ARRCOMPANYMACHINETYPE);
                                                        foreach($ArrMachinePlantType as $VarMachineId=>$VarMachineTableName){?>
                                                            <option value="<?php echo $VarMachineId?>"><?php echo $VarMachineTableName;?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrMachineType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0 hide" id="divTableTypeInfo">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">Table Type</label>
                                                <div class="col-sm-8">
                                                    <select name="frmTableType" id="frmTableType" class="form-control">
                                                        <option value=""></option>
                                                        <?php
                                                        $ArrMachinePlantType    = unserialize(ARRCOMPANYTABLETYPE);
                                                        foreach($ArrMachinePlantType as $VarTableId=>$VarTableName){?>
                                                            <option value="<?php echo $VarTableId?>"><?php echo $VarTableName;?></option>
                                                        <?php }?>
                                                    </select>
                                                    <div class="herr" id="ErrTableType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-4 control-label">No. of Machine/Table Type</label>
                                                <div class="col-sm-8">
                                                    <input type="text" name="frmMachineCount" class="form-control" id="frmMachineCount" placeholder="Number of Machine/Table" value="">
                                                    <div class="herr" id="ErrMachineCount"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-default" >Cancel</button>
                                            <button type="submit" class="btn btn-info pull-right  addrights" onclick="return fnSaveCompanyMachine();">Save Changes</button>
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
                                <div id="ResContactListCnt"></div>
                                <div id="ResContactList"></div>
                                <div>
                                    <section id="pagination_my" class="animated for_animate pdl15 pdb15"><ul class="pagination m-b-none animated for_animate" id="ResContactPagination"></ul></section>
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
                                <form class="form-horizontal" name="frmNameBasicContactInfo" id="frmNameBasicContactInfo" method="post">
                                    <div id="divEditBasicInfo">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessContactInfoMsg"></div>
                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-3 control-label" style="width:21%">Name</label>
                                            <div class="col-sm-9" style="width:77.5%">
                                                <input type="text" name="frmBasicContactName" class="form-control" id="frmBasicContactName" placeholder="Contact Name (Ex:Raja)" value="">
                                                <div class="herr" id="ErrBasicContactName"></div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">E-Mail Id</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicContactEmail" class="form-control" id="frmBasicContactEmail" placeholder="E-Mail Id" value="">
                                                    <div class="herr" id="ErrBasicContactEmail"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Designation</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicContactDesignation" class="form-control" id="frmBasicContactDesignation" placeholder="Ex: CEO" value="">
                                                    <div class="herr" id="ErrContactDesignation"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Mobile No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicContactMobile" class="form-control" id="frmBasicContactMobile" placeholder="Ex: 9847647744" value="">
                                                    <div class="herr" id="ErrBasicContactMobile"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Phone No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmBasicContactPhone" class="form-control" id="frmBasicContactPhone" placeholder="Ex: 9847647744" value="">
                                                    <div class="herr" id="ErrBasicContactPhone"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-default" >Cancel</button>
                                            <button type="submit" class="btn btn-info pull-right  addrights" onclick="return fnSaveCompanyContact();">Save Changes</button>
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
    <?php $this->load->view(CNFCADMIN.'template/templatefooter');?>
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
    var GlbCompanyId   	= "<?php echo @$VarCompanyId;?>";
</script>
<script src="<?php echo base_url();?>assets/js/<?php echo CNFCADMIN?>/companyprofile.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/js/commonfunctions.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<?php $this->load->view(CNFCADMIN.'template/pagefooter');?>