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
            <h1>Order Entry</h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url().CNFCOMPANY?>dashboard"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="<?php echo base_url().CNFCOMPANY?>order/manageorders/">Manage Orders</a></li>
                <li class="active">Add/Edit Order</li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div id="DivContOrderEntryPage1">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Order Entry Chart</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmBasicOrderEntryPage1" id="frmBasicOrderEntryPage1" method="post">
                                    <div id="divEditBasicInfo">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-left">COMPANY DETAILS</label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5  text-right">Company Name</label>
                                                <div class="col-sm-7">
                                                    Midway Apparels India Private Ltd
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-8 col-lg-8 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 text-right" style="width:21%">Address</label>
                                                <div class="col-sm-9">
                                                    No. 54/4, v.s.s. Garden, Sidco East Cross, Tiruppur - Kangayam Rd, Muthalipalayampiruvu, Tiruppur, Tamil Nadu 641606
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">IOR No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1IORNo" id="frmOEPage1IORNo" value="CG37355" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1IORNo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Merchant Name</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1MerchantName" id="frmOEPage1MerchantName" class="form-control">
                                                        <option value="">Choose the Merchant Name</option>
                                                        <option value="">Name 1</option>
                                                        <option value="">Name 2</option>
                                                        <option value="">Name 3</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1MerchantName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Team Head Name</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1TeamHeadName" id="frmOEPage1TeamHeadName" class="form-control">
                                                        <option value="">Choose the Team Head Name</option>
                                                        <option value="">Name 1</option>
                                                        <option value="">Name 2</option>
                                                        <option value="">Name 3</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1TeamHeadName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Date</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1IORNo" id="frmOEPage1IORNo" value="" class="form-control datepicker" readonly>
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Contact No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Mobile" id="frmOEPage1Mobile" value="97674728098" class="form-control">
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Contact No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Mobile" id="frmOEPage1Mobile" value="97674728098" class="form-control">
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Team Code</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1TeamCode" id="frmOEPage1TeamCode" class="form-control">
                                                        <option value="">Choose the Team Code</option>
                                                        <option value="">1000</option>
                                                        <option value="">1001</option>
                                                        <option value="">1002</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1TeamCode"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Merchant Code</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1MerchantCode" id="frmOEPage1MerchantCode" class="form-control">
                                                        <option value="">Choose the Merchant Code</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1MerchantCode"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Team Head Code</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1TeamHeadCode" id="frmOEPage1TeamHeadCode" class="form-control">
                                                        <option value="">Choose the Team Head Code</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1MerchantCode"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-left">ORDER ENTRY DETAILS</label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Style Ref. No</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1StyleRefNo" id="frmOEPage1StyleRefNo" value="" class="form-control">
                                                    <div class="herr" id="ErrOEPage1StyleRefNo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Season</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Season" id="frmOEPage1Season" value="" class="form-control" >
                                                    <div class="herr" id="ErrOEPage1Season"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Total Order Qty.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1OrderQty" id="frmOEPage1OrderQty" value="" class="form-control">
                                                    <div class="herr" id="ErrOEPage1OrderQty"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Style Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1StyleName" id="frmOEPage1StyleName" value="" class="form-control" >
                                                    <div class="herr" id="ErrOEPage1StyleName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Department</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Department" id="frmOEPage1Department" value="" class="form-control" >
                                                    <div class="herr" id="ErrOEPage1Department"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Currency</label>
                                                <div class="col-sm-7 ">
                                                   <div class="col-sm-5 pdl0">
                                                       <select name="frmOEPage1Currency" id="frmOEPage1Currency" class="form-control">
                                                           <option value="">USD</option>
                                                           <option value="">INR</option>
                                                           <option value="">AED</option>
                                                       </select>
                                                       <div class="herr" id="ErrOEPage1MerchantCode"></div>
                                                   </div>
                                                   <div class="col-sm-2 pdl0 pdr0">
                                                       <label for="inputEmail3" class="control-label">Price</label>
                                                   </div>
                                                    <div class="col-sm-5 pdr0 pdl0">
                                                        <input type="text" name="frmOEPage1Price" id="frmOEPage1Price" value="" class="form-control" >
                                                        <div class="herr" id="ErrOEPage1Price"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Buyer Name</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1BuyerName" id="frmOEPage1BuyerName" class="form-control">
                                                        <option value="">Buyer 1</option>
                                                        <option value="">Buyer 2</option>
                                                        <option value="">Buyer 3</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1BuyerName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Class Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1ClassName" id="frmOEPage1ClassName" value="" class="form-control" >
                                                    <div class="herr" id="ErrOEPage1ClassName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Exchange Rate</label>
                                                <div class="col-sm-7 ">
                                                    <div class="col-sm-6 pdl0">
                                                        INR 65 (Static)
                                                    </div>
                                                    <div class="col-sm-6 pdl0 pdr0">
                                                        INR 65 (Dynamic)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Brand Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1StyleRefNo" id="frmOEPage1StyleRefNo" value="" class="form-control">
                                                    <div class="herr" id="ErrOEPage1StyleRefNo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Sub Class</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Season" id="frmOEPage1Season" value="" class="form-control" >
                                                    <div class="herr" id="ErrOEPage1Season"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Payment Terms</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1OrderQty" id="frmOEPage1OrderQty" value="" class="form-control">
                                                    <div class="herr" id="ErrOEPage1OrderQty"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Style Description</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1OrderQty" id="frmOEPage1OrderQty" value="" class="form-control">
                                                    <div class="herr" id="ErrOEPage1OrderQty"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-left">COLOUR / COMBO WISE QUANTITY DETAILS</label>
                                            </div>
                                        </div>

                                        <div id="divOrderEntryPage1">
                                            <table id="tblOrderEntryPage1" class="table table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <td>
                                                            <select name="frmPage1OrderEntryHeadComboColour" id="frmPage1OrderEntryHeadComboColour" class="form-control">
                                                                <option value=""></option>
                                                                <option value="1">Combo Name</option>
                                                                <option value="2">Colour Name</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select name="frmPage1OrderEntryHeadComboColourCode" id="frmPage1OrderEntryHeadComboColourCode" class="form-control">
                                                                <option value=""></option>
                                                                <option value="1">Combo Code</option>
                                                                <option value="2">Colour Code</option>
                                                            </select>
                                                        </td>
                                                        <th>No. of P.O.'s</th>
                                                        <th>Unit of Measure</th>
                                                        <th>Order Qty.</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>
                                                            <input type="text" name="frmOEPage1ComboName1" id="frmOEPage1ComboName1" class="form-control" value="">
                                                            <div class="herr" id="ErrOEPage1ComboName1"></div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="frmOEPage1ComboCode1" id="frmOEPage1ComboCode1" class="form-control" value="">
                                                            <div class="herr" id="ErrOEPage1ComboCode"></div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="frmOEPage1NoOfPO1" id="frmOEPage1NoOfPO1" class="form-control" value="">
                                                            <div class="herr" id="ErrOEPage1NoOfPO1"></div>
                                                        </td>
                                                        <td>
                                                            <select name="frmOEPage1UnitMeasure1" id="frmOEPage1UnitMeasure1" class="form-control">
                                                                <option value=""></option>
                                                                <option value="1">Nos.</option>
                                                                <option value="2">Set</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="frmOEPage1OrderQty1" id="frmOEPage1OrderQty1" class="form-control" value="">
                                                            <div class="herr" id="ErrOEPage1OrderQty1"></div>
                                                        </td>
                                                        <td id="divAction1">
                                                            <a href="javascript:void(0);" onclick="fnAddOrderEntryPage1Row();"><i class="fa fa-plus"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-info pull-right  addrights" onclick="fnShowProfileCont('DivContOrderEntryPage2');">Next</button>
                                        </div><!-- /.box-footer -->
                                    </div>
                                </form>
                            </div><!-- /.box-body -->
                        </div><!-- /. box -->
                    </div>
                    <div id="DivContOrderEntryPage2" class="hide">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Order Entry Chart</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body ">
                                <form class="form-horizontal" name="frmBasicOrderEntryPage1" id="frmBasicOrderEntryPage1" method="post">
                                    <div id="divEditBasicInfo">
                                        <div class="alert alert-success alert-dismissable hide" id="divSuccessBasicInfoMsg"></div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-left">COMPANY DETAILS</label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5  text-right">Company Name</label>
                                                <div class="col-sm-7">
                                                    Midway Apparels India Private Ltd
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-8 col-lg-8 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-3 text-right" style="width:21%">Address</label>
                                                <div class="col-sm-9">
                                                    No. 54/4, v.s.s. Garden, Sidco East Cross, Tiruppur - Kangayam Rd, Muthalipalayampiruvu, Tiruppur, Tamil Nadu 641606
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">IOR No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1IORNo" id="frmOEPage1IORNo" value="CG37355" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1IORNo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Merchant Name</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1MerchantName" id="frmOEPage1MerchantName" class="form-control" disabled>
                                                        <option value="">Choose the Merchant Name</option>
                                                        <option value="">Name 1</option>
                                                        <option value="">Name 2</option>
                                                        <option value="">Name 3</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1MerchantName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Team Head Name</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1TeamHeadName" id="frmOEPage1TeamHeadName" class="form-control" disabled>
                                                        <option value="">Choose the Team Head Name</option>
                                                        <option value="">Name 1</option>
                                                        <option value="">Name 2</option>
                                                        <option value="">Name 3</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1TeamHeadName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Date</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1IORNo" id="frmOEPage1IORNo" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Contact No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Mobile" id="frmOEPage1Mobile" value="97674728098" class="form-control" readonly>
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Contact No.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Mobile" id="frmOEPage1Mobile" value="97674728098" class="form-control" readonly>
                                                    <div class="herr" id="ErrBasicBusinessType"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Team Code</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1TeamCode" id="frmOEPage1TeamCode" class="form-control" disabled>
                                                        <option value="">Choose the Team Code</option>
                                                        <option value="">1000</option>
                                                        <option value="">1001</option>
                                                        <option value="">1002</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1TeamCode"></div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Merchant Code</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1MerchantCode" id="frmOEPage1MerchantCode" class="form-control" disabled>
                                                        <option value="">Choose the Merchant Code</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1MerchantCode"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Team Head Code</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1TeamHeadCode" id="frmOEPage1TeamHeadCode" class="form-control" disabled>
                                                        <option value="">Choose the Team Head Code</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                        <option value="">CGEC38371</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1MerchantCode"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-left">ORDER ENTRY DETAILS</label>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Style Ref. No</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1StyleRefNo" id="frmOEPage1StyleRefNo" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1StyleRefNo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Season</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Season" id="frmOEPage1Season" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1Season"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Total Order Qty.</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1OrderQty" id="frmOEPage1OrderQty" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1OrderQty"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Style Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1StyleName" id="frmOEPage1StyleName" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1StyleName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Department</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Department" id="frmOEPage1Department" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1Department"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Currency</label>
                                                <div class="col-sm-7 ">
                                                    <div class="col-sm-5 pdl0">
                                                        <select name="frmOEPage1Currency" id="frmOEPage1Currency" class="form-control" disabled>
                                                            <option value="">USD</option>
                                                            <option value="">INR</option>
                                                            <option value="">AED</option>
                                                        </select>
                                                        <div class="herr" id="ErrOEPage1MerchantCode"></div>
                                                    </div>
                                                    <div class="col-sm-2 pdl0 pdr0">
                                                        <label for="inputEmail3" class="control-label">Price</label>
                                                    </div>
                                                    <div class="col-sm-5 pdr0 pdl0">
                                                        <input type="text" name="frmOEPage1Price" id="frmOEPage1Price" value="" class="form-control" readonly>
                                                        <div class="herr" id="ErrOEPage1Price"></div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Buyer Name</label>
                                                <div class="col-sm-7">
                                                    <select name="frmOEPage1BuyerName" id="frmOEPage1BuyerName" class="form-control" disabled>
                                                        <option value="">Buyer 1</option>
                                                        <option value="">Buyer 2</option>
                                                        <option value="">Buyer 3</option>
                                                    </select>
                                                    <div class="herr" id="ErrOEPage1BuyerName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Class Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1ClassName" id="frmOEPage1ClassName" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1ClassName"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-right">Exchange Rate</label>
                                                <div class="col-sm-7 ">
                                                    <div class="col-sm-6 pdl0">
                                                        INR 65 (Static)
                                                    </div>
                                                    <div class="col-sm-6 pdl0 pdr0">
                                                        INR 65 (Dynamic)
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Brand Name</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1StyleRefNo" id="frmOEPage1StyleRefNo" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1StyleRefNo"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Sub Class</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1Season" id="frmOEPage1Season" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1Season"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Payment Terms</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1OrderQty" id="frmOEPage1OrderQty" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1OrderQty"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-6 col-sm-4 col-lg-4 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 control-label">Style Description</label>
                                                <div class="col-sm-7">
                                                    <input type="text" name="frmOEPage1OrderQty" id="frmOEPage1OrderQty" value="" class="form-control" readonly>
                                                    <div class="herr" id="ErrOEPage1OrderQty"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-12 col-sm-12 col-lg-12 pdl0">
                                            <div class="form-group">
                                                <label for="inputEmail3" class="col-sm-5 text-left">P.O. WISE QUANTITY BREAKUP:</label>
                                            </div>
                                        </div>
                                        <div id="divOrderEntryPage2">
                                            <table id="tblOrderEntryPage2" class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th width="40"></th>
                                                    <th width="190">Combo Name</th>
                                                    <th width="210">Component Name</th>
                                                    <th width="100">Intake</th>
                                                    <th width="100">P.O. No.</th>
                                                    <th width="100">P.O. Date</th>
                                                    <th width="100">P.O. Qty.</th>
                                                    <th width="140">Size Range</th>
                                                    <th width="180">Country</th>
                                                    <th width="25"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>
                                                        <input type="text" name="frmOEPage2ComboName1" id="frmOEPage2ComboName1" class="form-control" value="">
                                                        <div class="herr" id="ErrOEPage2ComboName1"></div>
                                                    </td>
                                                    <td>
                                                        <select name="frmOEPage2Component1" id="frmOEPage2Component1" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                        <div class="herr" id="ErrOEPage2Component1"></div>
                                                    </td>
                                                    <td>
                                                        <select name="frmOEPage2InTake1" id="frmOEPage2InTake1" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                        <div class="herr" id="ErrOEPage2InTake1"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="frmOEPage2PONO1" id="frmOEPage2PONO1" class="form-control" value="">
                                                        <div class="herr" id="ErrOEPage2PONO1"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="frmOEPage2PODate1" id="frmOEPage2PODate1" class="form-control datepicker" value="">
                                                        <div class="herr" id="ErrOEPage2PODate1"></div>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="frmOEPage2POQty1" id="frmOEPage2POQty1" class="form-control datepicker" value="">
                                                        <div class="herr" id="ErrOEPage2POQty1"></div>
                                                    </td>
                                                    <td>
                                                        <select name="frmOEPage2SizeRange1" id="frmOEPage2SizeRange1" class="form-control">
                                                            <option value=""></option>
                                                        </select>
                                                        <div class="herr" id="ErrOEPage2SizeRange1"></div>
                                                    </td>
                                                    <td>
                                                        <select name="frmOEPage2Country1" id="frmOEPage2Country1" class="form-control">
                                                            <option value=""></option>
                                                            <option value="1">India</option>
                                                            <option value="2">USA</option>

                                                        </select>
                                                        <div class="herr" id="ErrOEPage2Country1"></div>
                                                    </td>
                                                    <td id="divPage2Action1">
                                                        <a href="javascript:void(0);" onclick="fnAddOrderEntryPage2Row();"><i class="fa fa-plus"></i></a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>


                                        <div class="clearfix"></div>
                                        <div class="box-footer nopadding">
                                            <button type="button" class="btn btn-default" onclick="fnShowProfileCont('DivContOrderEntryPage1');">Back</button>
                                            <button type="button" class="btn btn-info pull-right  addrights" onclick="fnShowProfileCont('DivContOrderEntryPage3');">Next</button>
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
<style>.datepicker{}</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css">
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker();
        $(".datepicker").datepicker( "option", "dateFormat","dd-mm-yy");
    });
</script>
<script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<style>
    @media (max-width:600px){
        #divOrderEntryPage1,#divOrderEntryPage2{
            border: 1px solid #ddd;
            margin-bottom: 15px;
            overflow-y: hidden;
            width: 100%;


            min-height: 0.01%;
            overflow-x: auto;

        }
    }
</style>
<script language="javascript">
    var GlbNewUser		= "<?php echo @$VarNewUser;?>";
    var GlbUserId   	= "<?php echo @$VarUserId;?>";
    var GlbOrderEntryPage1=GlbOrderEntryPage2 = 1;
</script>
<script src="<?php echo base_url();?>assets/js/commonfunctions.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<script src="<?php echo base_url();?>assets/js/orderentry.js?r=<?php echo CNFJSCSSRANDNO?>"></script>
<?php $this->load->view(CNFCOMPANY.'template/pagefooter');?>