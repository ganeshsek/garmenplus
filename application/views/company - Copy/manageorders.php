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
                Manage Order(s)
                <a class="btn btn-default btn-xs addrights" href="<?php echo base_url().CNFCOMPANY?>orders/orderentry"><i class="fa fa-plus"></i> ADD ORDER</a>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url()?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li>Manage Orders</li>
                <li class="active">Order List(s)</li>
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
                        <form class="form-horizontal" name="frmNameSearchOrder" id="frmNameSearchOrder">
                            <div class="box-body">
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">IOR No.</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchContactName" class="form-control" id="frmSrchContactName" placeholder="IOR83737">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Team Code</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchTeamCode" id="frmSrchTeamCode" class="form-control">
                                                <option value="">Choose the Team Code</option>
                                                <option value="">Team Code 1</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Buyer Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchBuyerName" class="form-control" id="frmSrchBuyerName" placeholder="Buyer Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Merchant Name</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchMerchantName" id="frmSrchMerchantName" class="form-control">
                                                <option value="">Choose the Merchant Name</option>
                                                <option value="">Name 1</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Brand Name</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchBrandName" id="frmSrchBrandName" class="form-control">
                                                <option value="">Choose the Brand Name</option>
                                                <option value="">Brand Name 1</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Team Head Name</label>
                                        <div class="col-sm-8">
                                            <select name="frmSrchTeamHeadName" id="frmSrchTeamHeadName" class="form-control">
                                                <option value="">Choose the Team Head Name</option>
                                                <option value="">Name 1</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Delivery Date(From Date)</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchFromDate" class="form-control" id="frmSrchFromDate" placeholder="From Date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6 col-sm-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Delivery Date(To Date)</label>
                                        <div class="col-sm-8">
                                            <input type="text" name="frmSrchToDate" class="form-control" id="frmSrchToDate" placeholder="To Date">
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="button" class="btn btn-default" onclick="resetForm('frmNameSearchOrders');">Reset</button>
                                <button type="button" class="btn btn-info pull-right" onclick="fnSearchOrders();">Search</button>
                            </div><!-- /.box-footer -->
                        </form>
                    </div><!-- /.box -->
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Order List(s)</h3>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <div id="ResResult">
                                <table id="example1" class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>IOR No.</th>
                                        <th>Buyer Name</th>
                                        <th>Brand Name</th>
                                        <th>Style Ref.No</th>
                                        <th>Combo Name/Color Name</th>
                                        <th>P.O.No.</th>
                                        <th>P.O.Qty.</th>
                                        <th>Value</th>
                                        <th>Shipment Date</th>
                                        <th>Current Status</th>
                                        <th>Recent Update</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>IOR737366</td>
                                        <td>Reliance Trends</td>
                                        <td><a href="<?php echo base_url().CNFCOMPANY?>/order/orderentry/MQ%3D%3D/">Zara</a></td>
                                        <td>SRFENO37377</td>
                                        <td>Combo Name 1</td>
                                        <td>865733</td>
                                        <td>345</td>
                                        <td>USD 3625</td>
                                        <td>13-06-2017</td>
                                        <td>In Progress</td>
                                        <td>13-06-2017 12:00:00</td>
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
<style>.datepicker{}</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css">
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker();
        $(".datepicker").datepicker( "option", "dateFormat","dd-mm-yy");
    });
</script>
<script src="<?php echo base_url();?>assets/js/commonfunctions.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<?php $this->load->view(CNFCOMPANY.'template/pagefooter');?>