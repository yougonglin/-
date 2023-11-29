<?php

//auto generated code
class autoload
{


	public static function loadClass($class)
	{
		$rootPath = dirname(__FILE__);
		$class = str_replace('douyin\\','',$class);
		$filename = $rootPath."/open/core/http/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/core/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/token/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/token/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/token/data/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/utils/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/spi/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_activityProductCategoryList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_activityProductCategoryList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolLivePreviewShare/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolLivePreviewShare/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_MCNSearchKolExclusiveActivityList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_MCNSearchKolExclusiveActivityList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_MCNSearchKolExclusiveProductList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_MCNSearchKolExclusiveProductList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_commonShareCommandParse/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_commonShareCommandParse/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeCommandParseAndShare/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeCommandParseAndShare/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductShare/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductShare/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_activityShareConvert/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_activityShareConvert/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeOrderAds/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeOrderAds/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_institutionInfo/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_institutionInfo/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_shareCommandParse/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_shareCommandParse/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeCrowdMatch/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeCrowdMatch/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductsSearch/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductsSearch/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_productsDetail/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_productsDetail/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductsDetail/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductsDetail/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolMaterialsProductsDetails/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolMaterialsProductsDetails/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductCategory/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductCategory/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_activityShareCommandParse/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_activityShareCommandParse/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductsDetails/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductsDetails/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_productSkus/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_productSkus/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_distributionRedpackDetailList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_distributionRedpackDetailList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_getProductShareMaterial/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_getProductShareMaterial/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeRewardOrders/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeRewardOrders/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolMaterialsProductsSearch/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolMaterialsProductsSearch/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeActivityMaterialList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeActivityMaterialList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_materialsProductStatus/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_materialsProductStatus/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_search/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_search/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_send/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_send/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_apply/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_apply/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_delete/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_delete/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_apply_list/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_apply_list/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductShare/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductShare/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductsDetail/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolProductsDetail/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeOrderAds/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeOrderAds/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/open_getAuthInfo/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/open_getAuthInfo/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/open_binaryupload/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/open_binaryupload/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_apply_revoke/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_apply_revoke/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_apply/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_apply/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sendResult/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sendResult/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolOrderAds/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolOrderAds/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/rights_info/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/rights_info/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidDel/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidDel/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/order_batchEncrypt/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/order_batchEncrypt/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_delete/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_delete/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/open_materialToken/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/open_materialToken/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_materialsProductStatus/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_materialsProductStatus/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductCategory/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/alliance_materialsProductCategory/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidEdit/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidEdit/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_distributionRedpackDetailList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_distributionRedpackDetailList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidEdit/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidEdit/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/security_batchReportOrderSecurityEvent/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/security_batchReportOrderSecurityEvent/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_revoke/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_revoke/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_instituteLiveShare/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_instituteLiveShare/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidDel/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidDel/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_batchSend/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_batchSend/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_distributionLiveProductList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_distributionLiveProductList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/token_refresh/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/token_refresh/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/order_getSearchIndex/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/order_getSearchIndex/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_shareRedpack/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_shareRedpack/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_instituteLivePreviewList/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_instituteLivePreviewList/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_apply_list/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_template_apply_list/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeActivityShare/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukeActivityShare/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidCreate/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_doukePidCreate/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_instituteLivePreviewShare/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_instituteLivePreviewShare/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidCreate/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_kolPidCreate/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/order_batchSensitive/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/order_batchSensitive/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_public_template/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_public_template/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_liveShareMaterial/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/buyin_liveShareMaterial/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/token_create/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/token_create/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_search/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}
		$filename = $rootPath."/open/api/sms_sign_search/param/".$class.".php";
		if(is_file($filename)) {
			include $filename;
			return;
		}

	}
}
spl_autoload_register('\autoload::loadClass');