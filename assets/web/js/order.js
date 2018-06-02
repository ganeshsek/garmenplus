function fnPlaceOrder() {
    try{
        $('.form-control').css("border", "1px solid #cccccc");
        $('div.herr').html('');
        var ProfileFormData							= false;
        var Name        							= $("#frmBillingName").val();
        var RegAccept   							= $('input[name="frmBillingRegAccept"]:checked').val();
        var Email									= $("#frmBillingEmail").val();
        var Mobile  								= $("#frmBillingMobile").val();

        if(jsTrim(Name)== ""){
            $('#ErrBillingName').html("Please fill the name");
            $('#frmBillingName').focus();
            $('#frmBillingName').css("border", "1px solid #B94A48");
            return false;
        }
        if(GlbUserId=='') {
            if(typeof(RegAccept)== "undefined"){
                $('#ErrBillingRegAccept').html("Please choose the gender");
                $('#frmBillingRegAccept').focus();
                return false;
            }
        }
        if (jsTrim(Email) == "") {
            $('#ErrBillingEmail').html("Please fill the email id");
            $('#frmBillingEmail').focus();
            $('#frmBillingEmail').css("border", "1px solid #B94A48");
            return false;
        } else if (!isEmail(Email)) {
            $('#ErrBillingEmail').html("Invalid email id!");
            $('#frmBillingEmail').focus();
            $('#frmBillingEmail').css("border", "1px solid #B94A48");
            return false;
        }
        if(jsTrim(Mobile)== ""){
            $('#ErrBillingMobile').html("Please fill the mobile no");
            $('#frmBillingMobile').focus();
            $('#frmBillingMobile').css("border", "1px solid #B94A48");
            return false;
        }
        return true;
    } catch (e) {
        alert(e);
    }
}

function fnDelProductCart(Id) {
    var Parameters = "pid="+Id;
    MakePostRequest(base_path+'checkout/delCartInfo',Parameters,'json',fnDelProductCartRes);
}

function fnDelProductCartRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                if(data.ccnt==0) {
                    fnRedirectPageTimeOut(base_path+'business-email-database-list/');
                } else {
                    fnRedirectPageTimeOut(window.location.href);
                }
            }
        }
    }
}

var GlbSearchParam='';
function fnListOrderHistory() {
    GlbSearchParam								= "rfrom=1";
    //$("#DivTotalCntResult").html('');
    //$("#ResResult").html("<img src='"+base_path+"assets/img/loader.gif' height='8' style='padding-left:10px'>");
    //alert("sdfsd");
    MakePostRequest(base_path+'orders/orderhistory/',GlbSearchParam,'json',fnListOrderHistoryRes);
}

function fnListOrderHistoryRes(data){
    if(data!=''){
        if(data.errcode!=undefined) {
            if(data.errcode == '404') {
                fnCallSessionExpire();
                return false;
            } else {
                var PageContent='';
                if(data.cn>0) {
                    ListCount	= '<div style="font-weight:bold;">Number of Orders(s) : '+data.cn+'</div>';
                    PageContent	= "<table id='example1' class='table table-bordered table-hover'><thead><tr><th>Ordered Date</th><th>Order Code</th><th>Number of Product(s)</th><th>Price (USD)</th></tr></thead><tbody>";
                    if(data.ct>0) {
                        $.each(data.re,function(index,value){
                            PageContent=PageContent+'<tr><td>'+value.od+'</td><td><a href="'+base_path+'checkout/paymentsummary/'+value.pl+'/" target="_blank">'+value.oc+'</a></td><td>'+value.nop+'</td><td>$ '+value.p+'</td>';
                            PageContent=PageContent+'</tr>';
                        });
                    }
                    $("#DivTotalCntResult").html(ListCount);
                } else {
                    PageContent	= PageContent+'<tr><td colspan="6" class="pdl15 herr text-center" style="padding-left:10px;">No Product(s) found</td></tr>';
                    $("#DivTotalCntResult").html('');
                }
                PageContent	= PageContent+'</tbody></table>';
                if(data.pa!=undefined) {
                    $("#ResPagination").html(base64_decode(data.pa));
                }
                $("#ResResult").html(PageContent);
            }
        }
    }
}


function fnPaginationOrderHistoryList(VarURL) {
    var Parameters = GlbSearchParam;
    $("#DivTotalCntResult").html('');
    $("#ResResult").html("<img src='"+base_path+"/assets/img/loader.gif' height='8' style='padding-left:10px'>");
    MakePostRequest(VarURL,Parameters,'json',fnListOrderHistoryRes);
}