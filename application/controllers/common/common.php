<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common extends CI_Controller {
	
	private $limit = 1;
	public function __construct() {
        parent::__construct();
		error_reporting(0);
        $this->load->helper('cookie');
		$this->load->helper('xssclean');
		$this->load->model("admin/localizationmodel");
		$this->load->model("admin/catalogmodel");
		$this->load->model("admin/customermodel");
		$this->load->model("user/searchmodel");
	}

	function getStates() {
		$VarCntryId												= xssclean($this->input->post('id'));
		$ArrStateList											= $this->localizationmodel->fnGetStateInfo('',$VarCntryId);
		$i=0;
		foreach ($ArrStateList as $VarKey=>$ArrStateInfo){
			$ArrFnlStateList[$i]['id']							= $ArrStateInfo['id'];
			$ArrFnlStateList[$i]['sn']							= $ArrStateInfo['statename'];
			$i=$i+1;
		}	
		echo json_encode(array('errcode'=>1,'cn'=>count($ArrFnlStateList),'ct'=>$i,'re'=>$ArrFnlStateList));
	}

	function getSubCategory() {
		$VarCategoryId											= xssclean($this->input->post('cid'));
		$ArrSubCategoryList										= $this->catalogmodel->fnGetCategoriesInfo('',2,$VarCategoryId);
		$i=0;
		foreach ($ArrSubCategoryList as $VarKey=>$ArrSubCategoryInfo){
			$ArrFnlSubCategoryList[$i]['id']					= $ArrSubCategoryInfo['id'];
			$ArrFnlSubCategoryList[$i]['sn']					= $ArrSubCategoryInfo['displayname'];
			$i=$i+1;
		}	
		echo json_encode(array('errcode'=>1,'cn'=>count($ArrFnlSubCategoryList),'ct'=>$i,'re'=>$ArrFnlSubCategoryList));
	}

	function getProductAttrValues() {
		$VarAttributeId											= xssclean($this->input->post('aid'));
		$ArrAttrValList											= $this->catalogmodel->fnGetProductAttrValInfo('',$VarAttributeId,1);
		$ArrFnlValList											= array();
		$i=0;
		foreach ($ArrAttrValList as $VarKey=>$ArrAttrvalInfo){
			$ArrFnlValList[$i]['id']							= $ArrAttrvalInfo['id'];
			$ArrFnlValList[$i]['av']							= $ArrAttrvalInfo['attributevalue'];
			$i=$i+1;
		}	
		echo json_encode(array('errcode'=>1,'cn'=>count($ArrFnlValList),'ct'=>$i,'re'=>$ArrFnlValList));
	}

	function getProductFeaturesAttrValues() {
		$VarAttributeId											= xssclean($this->input->post('aid'));
		$ArrAttrValList											= $this->catalogmodel->fnGetProductFeaturesValInfo('',$VarAttributeId,1);
		$ArrFnlValList											= array();
		$i=0;
		foreach ($ArrAttrValList as $VarKey=>$ArrAttrvalInfo){
			$ArrFnlValList[$i]['id']							= $ArrAttrvalInfo['id'];
			$ArrFnlValList[$i]['av']							= $ArrAttrvalInfo['displayname'];
			$i=$i+1;
		}	
		echo json_encode(array('errcode'=>1,'cn'=>count($ArrFnlValList),'ct'=>$i,'re'=>$ArrFnlValList));
	}

	function getProductAttrList() {
		$VarCategoryId											= xssclean($this->input->post('cid'));
		$ArrProductAttrList										= $this->catalogmodel->fnGetProductAttrInfo('',$VarCategoryId,array(1));
		$ArrFnlProdAttrList										= array();
		$i=0;
		foreach($ArrProductAttrList as $VarKey=>$ArrVal) {
			$ArrFnlProdAttrList[$i]['id']						= $ArrVal['id'];
			$ArrFnlProdAttrList[$i]['an']						= $ArrVal['displayname'];
			$i=$i+1;
		}
		echo json_encode(array('errcode'=>1,'cn'=>count($ArrFnlProdAttrList),'ct'=>$i,'re'=>$ArrFnlProdAttrList));
	}

	function getDeliveryDays() {
		$VarProductId											= xssclean($this->input->post('pid'));
		$VarPinCode												= xssclean($this->input->post('pc'));
		$VarUserType											= xssclean($this->input->post('ut'));
		if($VarUserType==1) {
			$ArrGetProductSellerInfo							= $this->searchmodel->fnProductBasicDetails('','',$VarProductId);
			$VarUserId											= $ArrGetProductSellerInfo[0]['userid'];
			$VarUserId											= 15;
			$ArrAddressInfo										= $this->customermodel->fnGetBTBAddressInfo('',$VarUserId);
			$VarSellerPinCode									= $ArrAddressInfo[0]['pincode'];
		} else {
			$VarSellerPinCode									= WHAZC;
		}
		$this->load->library('bluedart');
		$VarPickUpDate                           				= date('Y-m-d', mktime(0, 0, 0, date('m'), date('d') + COMMONEXTRADELIVERYDAYS, date('Y')));
		$VarPickUpTime                           				= '10:00';
		$ObjResult												= $this->bluedart->fnTimeServicetoDestination($VarSellerPinCode,$VarPinCode,$VarPickUpDate,$VarPickUpTime);
		$ArrResult												= array();
		if($ObjResult->GetDomesticTransitTimeForPinCodeandProductResult->IsError=='') {
			$ArrResult['EDD']									= $ObjResult->GetDomesticTransitTimeForPinCodeandProductResult->ExpectedDateDelivery;
			$ArrResult['errcode']								= 1;
		} else {
			$ArrResult['msg']									= 'Invalid Pin Code!!!';
			$ArrResult['errcode']								= -1;
		}
		echo json_encode($ArrResult);
	}
	
	
}