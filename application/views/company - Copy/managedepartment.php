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
                Manage Department
                <a class="btn btn-default btn-xs addrights" href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditdepartment"><i class="fa fa-plus"></i> ADD DEPARTMENT</a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCOMPANY?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Manage Department</li>
                <li class="active">Department List</li>
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
                        <form class="form-horizontal" name="frmNameSearchDepartment" id="frmNameSearchDepartment">
                            <div class="box-body">
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Department Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchDepartmentName" class="form-control" id="frmSrchDepartmentName" placeholder="Department Name">
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
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" onclick="resetForm('frmNameSearchWPG');">Reset</button>
                                <button type="button" class="btn btn-info pull-right" onclick="fnSearchWPG();">Search</button>
                            </div><!-- /.box-footer -->
                        </form>
                    </div><!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Department List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div id="ResResult">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Department Name</th>
                                        <th>Status</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditmerchant/">Department Name 1</a></td>
                                        <td>Active</td>
                                        <td>13-06-2017 22:21:00</td>
                                        <td><i class="fa fa-edit"></i>&nbsp;<a href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditdepartment/">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-edit"></i>&nbsp;<a href="javascript:void(0);" onclick="fnDelDepartment();">Delete</a></td>
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

