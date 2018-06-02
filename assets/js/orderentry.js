function fnAddOrderEntryPage1Row() {
    var NewRowId    = GlbOrderEntryPage1+1;
    var RowContent  = '<tr><td>'+NewRowId+'</td><td><input type="text" name="frmOEPage1ComboName'+NewRowId+'" id="frmOEPage1ComboName'+NewRowId+'" class="form-control" value=""><div class="herr" id="ErrOEPage1ComboName'+NewRowId+'"></div></td><td><input type="text" name="frmOEPage1ComboCode'+NewRowId+'" id="frmOEPage1ComboCode'+NewRowId+'" class="form-control" value=""><div class="herr" id="ErrOEPage1ComboCode'+NewRowId+'"></div></td><td><input type="text" name="frmOEPage1NoOfPO'+NewRowId+'" id="frmOEPage1NoOfPO'+NewRowId+'" class="form-control" value=""><div class="herr" id="ErrOEPage1NoOfPO'+NewRowId+'"></div></td><td><select name="frmOEPage1UnitMeasure'+NewRowId+'" id="frmOEPage1UnitMeasure'+NewRowId+'" class="form-control"><option value=""></option><option value="1">Nos.</option><option value="2">Set</option></select><div class="herr" id="ErrOEPage1UnitMeasure'+NewRowId+'"></div></td><td><input type="text" name="frmOEPage1OrderQty'+NewRowId+'" id="frmOEPage1OrderQty'+NewRowId+'" class="form-control" value=""><div class="herr" id="ErrOEPage1OrderQty'+NewRowId+'"></div></td><td id="divAction'+NewRowId+'"><a href="javascript:void(0);" onclick="fnAddOrderEntryPage1Row();"><i class="fa fa-plus"></i></a></td></tr>';
    $("#divAction"+GlbOrderEntryPage1).html('');
    GlbOrderEntryPage1      = NewRowId;
    $("#tblOrderEntryPage1").append(RowContent);
}

function fnShowProfileCont(VarDivShow) {
    var ArrProfileContList = ["DivContOrderEntryPage1","DivContOrderEntryPage2","DivContOrderEntryPage3"];
    //Remove Class
    for(i=0;i<ArrProfileContList.length;i++) {
        $("#"+ArrProfileContList[i]).removeClass('show');
        $("#"+ArrProfileContList[i]).removeClass('hide');
    }
    //Add Class
    for(i=0;i<ArrProfileContList.length;i++) {
        if(VarDivShow!=ArrProfileContList[i]) {
            $("#"+ArrProfileContList[i]).addClass('hide');
        }
    }
    if(VarDivShow=="DivContAddressInfo") {
        fnShowHideEndUserSub(2,'divShowAddressInfo');
    }
    $("#"+VarDivShow).addClass('show');
}

function fnShowHideEndUserSub(VarType,VarDivShow) {
    var ArrProfileBasicList = ["divEditBasicInfo","divShowBasicInfo"];
    if(VarType==1) {
        var ArrFnalList	= ArrProfileBasicList;
    }
    //Remove Class
    for(i=0;i<ArrFnalList.length;i++) {
        $("#"+ArrFnalList[i]).removeClass('show');
        $("#"+ArrFnalList[i]).removeClass('hide');
    }
    //Add Class
    for(i=0;i<ArrFnalList.length;i++) {
        if(VarDivShow!=ArrFnalList[i]) {
            $("#"+ArrFnalList[i]).addClass('hide');
        }
    }
    $("#"+VarDivShow).addClass('show');
}

function fnAddOrderEntryPage2Row() {
    var NewRowId    = GlbOrderEntryPage2+1;
    var RowContent  = '<tr><td>'+NewRowId+'</td><td><input type="text" name="frmOEPage2ComboName'+NewRowId+'" id="frmOEPage2ComboName'+NewRowId+'" class="form-control" value=""><div class="herr" id="ErrOEPage2ComboName'+NewRowId+'"></div></td><td><select name="frmOEPage2Component'+NewRowId+'" id="frmOEPage2Component'+NewRowId+'" class="form-control"><option value=""></option></select><div class="herr" id="ErrOEPage2Component'+NewRowId+'"></div></td><td><select name="frmOEPage2InTake'+NewRowId+'" id="frmOEPage2InTake'+NewRowId+'" class="form-control"> <option value=""></option></select><div class="herr" id="ErrOEPage2InTake'+NewRowId+'"></div></td><td><input type="text" name="frmOEPage2PONO1'+NewRowId+'" id="frmOEPage2PONO1'+NewRowId+'" class="form-control" value=""><div class="herr" id="ErrOEPage2PONO1'+NewRowId+'"></div></td><td><input type="text" name="frmOEPage2PODate'+NewRowId+'" id="frmOEPage2PODate'+NewRowId+'" class="form-control datepicker" value="" onclick="$(\'#frmOEPage2PODate'+NewRowId+'\').datepicker();$(\'#frmOEPage2PODate'+NewRowId+'\').datepicker(\'show\');"><div class="herr" id="ErrOEPage2PODate'+NewRowId+'"></div></td><td><input type="text" name="frmOEPage2POQty'+NewRowId+'" id="frmOEPage2POQty'+NewRowId+'" class="form-control" value=""><div class="herr" id="ErrOEPage2POQty'+NewRowId+'"></div></td><td><select name="frmOEPage2SizeRange'+NewRowId+'" id="frmOEPage2SizeRange'+NewRowId+'" class="form-control"><option value=""></option></select><div class="herr" id="ErrOEPage2SizeRange'+NewRowId+'"></div></td><td><select name="frmOEPage2Country'+NewRowId+'" id="frmOEPage2Country'+NewRowId+'" class="form-control"><option value=""></option></select><div class="herr" id="ErrOEPage2Country'+NewRowId+'"></div></td><td id="divPage2Action'+NewRowId+'"><a href="javascript:void(0);" onclick="fnAddOrderEntryPage2Row();"><i class="fa fa-plus"></i></a></td></tr>';
    $("#divPage2Action"+GlbOrderEntryPage2).html('');
    GlbOrderEntryPage2      = NewRowId;
    $('.datepicker').datepicker();
    $(".datepicker").datepicker( "option", "dateFormat","dd-mm-yy");
    $("#tblOrderEntryPage2").append(RowContent);
}