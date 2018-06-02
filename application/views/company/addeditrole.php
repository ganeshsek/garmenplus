<?php $this->load->view(CNFCOMPANY.'template/pageheader');?>
    <body class="sidebar-mini skin-black wysihtml5-supported sidebar-collapse" cz-shortcut-listen="true">
<div class="wrapper">
    <?php $this->load->view(CNFCOMPANY.'template/templateheader');?>
    <aside class="main-sidebar">
        <?php $this->load->view(CNFCOMPANY.'template/templateleftmenu');?>
    </aside>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Add/Edit Roles
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCOMPANY?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url().CNFCOMPANY?>managerole/manageroles"><i class="fa fa-dashboard"></i> Manage Role</a></li>
                <li class="active">Role List(s)</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Role Information</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" name="frmNameSearchRole" id="frmNameSearchRole">
                            <div class="box-body">
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Role Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchRoleName" class="form-control" id="frmSrchRoleName" placeholder="Role Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Status</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchStatus" id="frmSrchStatus" class="form-control">
                                                <option value="">Choose the Status</option>
                                                <?php
                                                $ArrStatus  = unserialize(ARRSTATUS);
                                                unset($ArrStatus[3]);
                                                foreach($ArrStatus as $VarKey=>$VarStatus) {?>
                                                    <option value="<?php echo $VarKey?>"><?php echo $VarStatus?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                        </form>
                    </div><!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Configure Permission</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div id="ResResult">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th width="3%"><input type="checkbox" name="frmRoleAll" id="frmRoleAll"></th>
                                        <th>Module Name</th>
                                        <th width="8%">Add</th>
                                        <th width="8%">Edit</th>
                                        <th width="8%">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th colspan="4">Master Configuration</th>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="frmRoleAll" id="frmRoleAll"></td>
                                            <td>Dyeing Method</td>
                                            <td><input type="checkbox" name="frmRoleAdd1" id="frmRoleAdd1"></td>
                                            <td><input type="checkbox" name="frmRoleEdit1" id="frmRoleEdit1"></td>
                                            <td><input type="checkbox" name="frmRoleDelete1" id="frmRoleDelete1"></td>
                                        </tr>
                                        <tr>
                                            <th colspan="4">Merchant/User</th>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="frmRoleAll" id="frmRoleAll"></td>
                                            <td>Manage Merchant</td>
                                            <td><input type="checkbox" name="frmRoleAdd1" id="frmRoleAdd1"></td>
                                            <td><input type="checkbox" name="frmRoleEdit1" id="frmRoleEdit1"></td>
                                            <td><input type="checkbox" name="frmRoleDelete1" id="frmRoleDelete1"></td>
                                        </tr>
                                        <tr>
                                            <td><input type="checkbox" name="frmRoleAll" id="frmRoleAll"></td>
                                            <td>Manage User(s)</td>
                                            <td><input type="checkbox" name="frmRoleAdd1" id="frmRoleAdd1"></td>
                                            <td><input type="checkbox" name="frmRoleEdit1" id="frmRoleEdit1"></td>
                                            <td><input type="checkbox" name="frmRoleDelete1" id="frmRoleDelete1"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer nopadding">
                            <button type="button" class="btn btn-default" onclick="fnShowHideEndUserSub(1,'divShowBasicInfo');">Cancel</button>
                            <button type="submit" class="btn btn-info pull-right  addrights" onclick="return fnSaveDepartmentInfo();">Save Changes</button>
                        </div><!-- /.box-footer -->
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