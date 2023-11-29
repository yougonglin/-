<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: Your Name you@example.com
 * @Description: 杰出人类商城项目
 */
require app()->getRootPath() .  "extend/douyin/autoload.php";

class DouyinSubsidy
{

    public $accessToken;
    public function __construct() {
        //设置appKey和appSecret，全局设置一次
        GlobalConfig::getGlobalConfig()->appKey = env('douyin.app_key', '');
        GlobalConfig::getGlobalConfig()->appSecret = env('douyin.app_secret', '');
        //设置token
        $result = cache('douyin_code_token');
        if(isset($result) && $result != 'null'){
            $result = json_decode($result,true);
            $this->accessToken = AccessTokenBuilder::parse($result['access_token']);
        }
    }
    /**
     * @description: 获取token
     * @param {*} $code
     * @return {*}
     */    
    public function get_douyin_code_token($code)
    {
        $result = cache('douyin_code_token');
        //如果不是第一次请求code，就用refresh_token来刷新
        if(isset($result) && $result != 'null'){
            $result = json_decode($result,true);
            $result = AccessTokenBuilder::refresh($result['refresh_token'])->getData();
            cache('douyin_code_token',json_encode($result),6048000);
        }else{
            $result = AccessTokenBuilder::build($code, ACCESS_TOKEN_CODE)->getData();
            cache('douyin_code_token',json_encode($result),6048000);
        }
        return $result;
    }

    /**
     * @description: 抖客商品搜索
     * @param {*} $title
     * @param {*} $page
     * @return {*}
     */    
    public function douyin_search($title,$page,$type = 1)
    {
        $request = new BuyinKolMaterialsProductsSearchRequest();
        $param = new BuyinKolMaterialsProductsSearchParam();
        $request->setParam($param);
        $param->title = $title;
        $param->sort_type = 1;
        $param->page = $page;
        $param->page_size = 20;
        $param->share_status = 1;
        if($type == 1){
            $param->search_type = 0;
            $param->cos_ratio_min = 1;
        }else{
            $param->search_type = 3;
            $param->sell_num_min = 100;
        }
        return $request->execute($this->accessToken);
    }

    /**
     * @description: 创建分销链接
     * @param {*} $url
     * @param {*} $uid
     * @return {*}
     */    
    public function douyin_build_link($url,$uid,$platform)
    {
        $request = new BuyinKolProductShareRequest();
        $param = new BuyinKolProductShareParam();
        $request->setParam($param);
        $param->product_url = $url;
        $param->pid = "dy_107234610901566243127_26339_1854048540";
        $param->external_info = $uid;
        $param->need_qr_code = false;
        $param->use_coupon = false;
        $param->need_share_link = true;
        $param->need_zlink = false;
        $param->platform = $platform;
        return $request->execute($this->accessToken);
    }

    /**
     * @description: 查询分销订单
     * @param {*} $orderId
     * @return {*}
     */    
    public function douyin_get_order($orderId)
    {
        $request = new BuyinDoukeOrderAdsRequest();
        $param = new BuyinDoukeOrderAdsParam();
        $request->setParam($param);
        $param->size = 10;
        $param->order_ids = $orderId;
        $param->pid = "dy_107234610901566243127_26339_1854048540";
        $param->query_order_type = 0;
        $tmp = $request->execute($this->accessToken);
        return json_decode(json_encode($tmp),true);
    }
}