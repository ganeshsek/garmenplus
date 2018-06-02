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
                Manage Packing Material
                <a class="btn btn-default btn-xs addrights" href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditpackingmaterial"><i class="fa fa-plus"></i> ADD DEPARTMENT</a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCOMPANY?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Manage Packing Material</li>
                <li class="active">Packing Material List</li>
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
                        <form class="form-horizontal" name="frmNameSearchPackingMaterial" id="frmNameSearchPackingMaterial">
                            <div class="box-body">
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Packing Material Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchPacking MaterialName" class="form-control" id="frmSrchPacking MaterialName" placeholder="Packing Material Name">
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
                                <button type="button" class="btn btn-default" onclick="resetForm('frmNameSearchPackingMaterial');">Reset</button>
                                <button type="button" class="btn btn-info pull-right" onclick="fnSearchPackingMaterial();">Search</button>
                            </div><!-- /.box-footer -->
                        </form>
                    </div><!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Packing Material List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div id="ResResult">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Packing Material Name</th>
                                        <th>Status</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditpackingmaterial/">Packing Material Name 1</a></td>
                                        <td>Active</td>
                                        <td>13-06-2017 22:21:00</td>
                                        <td><i class="fa fa-edit"></i>&nbsp;<a href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditpackingmaterial/">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-edit"></i>&nbsp;<a href="javascript:void(0);" onclick="fnDelPackingMaterial();">Delete</a></td>
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

