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
                Manage Garment Wash Details
                <a class="btn btn-default btn-xs addrights" href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditgwd"><i class="fa fa-plus"></i> ADD GARMENT WASH DETAILS</a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCOMPANY?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Manage Garment Wash Details</li>
                <li class="active">Garment Wash Details List(s)</li>
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
                        <form class="form-horizontal" name="frmNameSearchGWD" id="frmNameSearchGWD">
                            <div class="box-body">
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Garment Wash Details</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchGWD" class="form-control" id="frmSrchGWD" placeholder="Garment Wash Details					 						 ">
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" onclick="resetForm('frmNameSearchGWD');">Reset</button>
                                <button type="button" class="btn btn-info pull-right" onclick="fnSearchGWD();">Search</button>
                            </div><!-- /.box-footer -->
                        </form>
                    </div><!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Garment Wash Details List</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div id="ResResult">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Garment Wash Details</th>
                                        <th>Date Updated</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td><a href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditgwd/">Garment Wash Details					 						 </a></td>
                                        <td>13-06-2017 22:21:00</td>
                                        <td><i class="fa fa-edit"></i>&nbsp;<a href="<?php echo base_url().CNFCOMPANY?>mastersetup/addeditgwd/">Edit</a>&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-edit"></i>&nbsp;<a href="javascript:void(0);" onclick="fnDelGWD();">Delete</a></td>
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