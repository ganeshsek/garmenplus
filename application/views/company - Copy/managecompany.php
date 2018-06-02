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
            <h1>
                Manage Company(s)
                <a class="btn btn-default btn-xs addrights" href="<?php echo base_url().CNFCOMPANY?>cprofile/addeditcompany"><i class="fa fa-plus"></i> ADD COMPANY</a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url()?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Manage Company</li>
                <li class="active">Company List(s)</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Search</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" name="frmNameSearchCompany" id="frmNameSearchCompany">
                            <div class="box-body">
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Company Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchCompanyName" class="form-control" id="frmSrchCompanyName" placeholder="Company Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Contact Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchContactName" class="form-control" id="frmSrchContactName" placeholder="Contact Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Mobile No</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchContactMobile" class="form-control" id="frmSrchContactMobile" placeholder="Mobile No">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Phone No</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchContactPhone" class="form-control" id="frmSrchContactPhone" placeholder="Phone No">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Business Type</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchBusinessType" id="frmSrchBusinessType" class="form-control">
                                                <option value="">Choose the Business Type</option>
                                                <?php
                                                $ArrBusinessTypeList  = unserialize(ARRCOMPANYBUSINESSTYPE);
                                                foreach($ArrBusinessTypeList as $VarBusinessId=>$VarBusinessName) {?>
                                                    <option value="<?php echo $VarBusinessId?>"><?php echo $VarBusinessName?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Country</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchCountry" id="frmSrchCountry" class="form-control">
                                                <option value="">Choose the Country</option>
                                                <?php
                                                $ArrCountryList  = unserialize(ARRCOUNTRYLIST);
                                                foreach($ArrCountryList as $VarCountryId=>$VarCountryName) {?>
                                                    <option value="<?php echo $VarCountryId?>"><?php echo $VarCountryName?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" onclick="resetForm('frmNameSearchCompany');">Reset</button>
                                <button type="button" class="btn btn-info pull-right" onclick="fnSearchCompany();">Search</button>
                            </div><!-- /.box-footer -->
                        </form>
                    </div><!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Employee List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div id="ResResult">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Business Type</th>
                                        <th>Factory Ownership</th>
                                        <th>Username</th>
                                        <th>Password</th>
                                        <th>City</th>
                                        <th>Country</th>
                                        <th>Date Updated</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="<?php echo base_url().CNFCOMPANY?>/cprofile/profiledetails/MQ%3D%3D/">Reliance Trends</a></td>
                                        <td>Exporters, Manufacturers, Trading Company</td>
                                        <td>Wholly Owned</td>
                                        <td>contcat@trends.com</td>
                                        <td>Password12345</td>
                                        <td>Pune</td>
                                        <td>India</td>
                                        <td>13-06-2017 22:21:00</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>
        </section>
    </div><!-- /.content-wrapper -->
    <?php $this->load->view(CNFCOMPANY.'template/templatefooter');?>
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<!-- DataTables -->
<script src="<?php echo base_url();?>assets/js/commonfunctions.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<?php $this->load->view(CNFCOMPANY.'template/pagefooter');?>