<?php $this->load->view(CNFCADMIN.'template/pageheader');?>
<body class="sidebar-mini skin-black wysihtml5-supported sidebar-collapse" cz-shortcut-listen="true">
<div class="wrapper">
    <?php $this->load->view(CNFCADMIN.'template/templateheader');?>
    <aside class="main-sidebar">
        <?php $this->load->view(CNFCADMIN.'template/templateleftmenu');?>
    </aside>
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                Manage Packing Material
                <a class="btn btn-default btn-xs addrights" href="<?php echo base_url().CNFCADMIN?>mpackingmaterial/addedit"><i class="fa fa-plus"></i> ADD PACKING MATERIAL</a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCADMIN?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Manage Packing Material</li>
                <li class="active">Packing Material List(s)</li>
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
                                        <label for="inputEmail3" class="col-sm-4 control-label">Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchPackingMaterialName" class="form-control" id="frmSrchPackingMaterialName" placeholder="Packing Material">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Status</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchPackingMaterialStatus" id="frmSrchPackingMaterialStatus" class="form-control">
                                                <option value="">Choose the Status</option>
                                                <?php
                                                $ArrStatus  = unserialize(ARRSTATUS);
                                                unset($ArrStatus[3]);
                                                foreach($ArrStatus as $VarKey=>$VarStatus) {?>
                                                    <option value="<?php echo $VarKey?>" ><?php echo $VarStatus?></option>
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
                            <div id="DivTotalCntResult" class="pd10"></div>
                            <div id="ResResult"></div>
                            <div>
                                <section id="pagination_my" class="animated for_animate pdl15 pdb15"><ul class="pagination m-b-none animated for_animate" id="ResPagination"></ul></section>
                            </div>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div><!-- /.col -->
            </div>
        </section>
    </div><!-- /.content-wrapper -->
    <?php $this->load->view(CNFCADMIN.'template/templatefooter');?>
    <div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->
<!-- DataTables -->
<script src="<?php echo base_url();?>assets/js/commonfunctions.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/js/<?php echo CNFCADMIN?>/mpackingmaterial.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script language="javascript">fnListPackingMaterial();</script>
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<?php $this->load->view(CNFCADMIN.'template/pagefooter');?>