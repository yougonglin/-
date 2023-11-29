<?php
/*
 * @Author: 温州市宅龙网络科技有限公司
 * @email: 
 * @github:https://gitee.com/yourking/outstanding-human-social-mall 
 * @LastEditors: 温州市宅龙网络科技有限公司
 * @Description: 杰出人类商城项目
 */
declare (strict_types = 1);

namespace app\app\controller\star;
use think\facade\Request;
use \supernova\Shuchu;
use app\app\model\star\UserinfoModel;
use app\app\model\user\UserModel;
use think\facade\Db;
use app\app\model\user\YueLog;

class SocializeController
{
    /**
  * @description: 保存/更新个人约会信息
  * @return {*}
  */	
	public function profile_save(UserModel $UserModel,UserinfoModel $UserinfoModel,YueLog $YueLog,Shuchu $Shuchu)
	{
		$data = Request::except(['frequency','is_pass','violation_record'], 'post');
    $data['uid'] = request()->userInfo->uid;
    $data['picture'] = json_encode($data['picture']);
    $data['place'] = json_encode($data['place']);
    //每次更新进入审核
    $data['is_pass'] = 0;
    //扣费1元
    $price = 1;
    Db::startTrans();
    try {
        //扣除余额
        $UserModel->where('uid',$data['uid'])->dec('yue_num',$price)->update();
        //余额记录
        $YueLog->save([
            'uid' => $data['uid'],
            'num' => $price,
            'type' => 2,
            'mark' => '更新个人简介'
        ]);
        //插入/更新资料
		    $result = $UserinfoModel->json(['place','picture'])->cache('SocializeUserInfo')->duplicate($data)->insert($data);
        // 提交事务
        Db::commit();
    } catch (\Exception $e) {
        $result = $e->getMessage();
        // 回滚事务
        Db::rollback();
    }
    return $Shuchu->json($result);
	}

  public function profile_save_free(UserModel $UserModel,UserinfoModel $UserinfoModel,YueLog $YueLog,Shuchu $Shuchu)
	{
		$data = Request::except(['frequency','is_pass','violation_record'], 'post');
    $data['uid'] = request()->userInfo->uid;
    $data['picture'] = json_encode($data['picture']);
    $data['place'] = json_encode($data['place']);
    //每次更新进入审核
    $data['is_pass'] = 0;
    //插入/更新资料
    $result = $UserinfoModel->json(['place','picture'])->cache('SocializeUserInfo')->duplicate($data)->insert($data);
    return $Shuchu->json($result);
	}

  /**
  * @description: 获取个人约会信息
  *@return {*}
  */	
	public function profile_get(UserinfoModel $UserinfoModel,Shuchu $Shuchu)
	{
    $uid = Request::get('uid');
    if(Request::get('self') == '1'){
      $result = $UserinfoModel->withoutField('violation_record,is_pass,frequency')->find($uid);
    }else{
      $result = $UserinfoModel->withoutField('violation_record,is_pass,frequency')->where('is_show',1)->where('is_pass',1)->find($uid);
    }
    return $Shuchu->json($result);
	}

  /**
  * @description: 约会数据条件查询
  * @param {Request} $request
  * @param {YuehuiUserServices} $yuehuiUserServices
  * @return {*}
  */  
	public function search(UserinfoModel $UserinfoModel,Shuchu $Shuchu)
	{
		$uid = request()->userInfo->uid;
    //判断是否为vip
    $isVip = Request::get('vip',false);
    //不是VIP就只查询性别
    $data = $isVip == 'true' ? Request::post() : array("sex" => Request::post('sex','1'));
    //组合查询条件
    $tmp = array_keys($data);
    $where = [];$whereTime = ['1970-10-1', '2088-10-1'];
    foreach($tmp as $val){
        if($val == 'height' || $val == 'weight'){
            array_push($where,[$val,'between',[$data[$val]['min'],$data[$val]['max']]]);
        }elseif($val == 'age'){
            $max = $data[$val]['max'] + 1;
            $whereTime = ["-{$max} years","-{$data[$val]['min']} years"];
        }elseif($val == 'place'){
            foreach($data[$val] as $key => $val){
                array_push($where,["place->{$key}->name",'=',$val]);
            }
        }else{
            array_push($where,[$val,'=',$data[$val]]);
        }
    }
    $result = [];$i = 1;$frequencyUpdate = [];
    //开始查询
    $data = $UserinfoModel->field('uid,place,name,birthday,weight,height,school,occupation,picture,frequency')->whereTime('birthday', 'between', $whereTime)->where($where)->where('picture','not null')->where('is_pass',1)->where('is_show',1)->order('frequency', 'asc')->page((int) Request::get('page',1),20)->select();
    //更新被查询次数,给所有用户平均的展示机会
    foreach($data as $user){
      array_push($frequencyUpdate,['uid' => $user['uid'],'frequency' => ($user['frequency'] + 1)]);
    }
    $UserinfoModel->saveAll($frequencyUpdate);
    return $Shuchu->json($data);
	}

  /**
   * @description: 获取目标手机号
   * @param {Request} $request
   * @param {YuehuiUserServices} $yuehuiUserServices
   * @return {*}
   */  
  public function get_phone(UserModel $UserModel,YueLog $YueLog,Shuchu $Shuchu)
  {
    $targetId = Request::get('uid');
    $uid = request()->userInfo->uid;
    $price = 10;
    Db::startTrans();
    try {
        //扣除余额
        $UserModel->where('uid',$uid)->dec('yue_num',$price)->update();
        //余额记录
        $YueLog->save([
            'uid' => $uid,
            'num' => $price,
            'type' => 2,
            'mark' => '获取他人联系方式'
        ]);
        $result = $UserModel->where('uid',$targetId)->value('phone') ?? '18058365420';
        // 提交事务
        Db::commit();
    } catch (\Exception $e) {
        $result = 0;
        // 回滚事务
        Db::rollback();
    }
    return $Shuchu->json($result);
  }

  public function get_phone_free(UserModel $UserModel,YueLog $YueLog,Shuchu $Shuchu)
  {
    $targetId = Request::get('uid');
    $result = $UserModel->where('uid',$targetId)->value('phone') ?? '18058365420';
    return $Shuchu->json($result);
  }

  /**
   * @description: 举报用户
   * @return {*}
   */  
  public function report_user(UserinfoModel $UserinfoModel,Shuchu $Shuchu)
  {
		$uid = request()->userInfo->uid;
    $targetId = Request::post('targetId');
    $desc = Request::post('desc');
    //如果是举报图片色情则直接举报
    $desc = "[{$uid}:{$desc}]";
    $result = $UserinfoModel->where('uid',$targetId)->exp('violation_record','CONCAT(violation_record,"·'.$desc.'")')->update(['is_pass' => 0]);
    //防止刷恶意举报攻击，限制举报次数
    return $Shuchu->json($result);
  }

  /**
   * @description: 获取最新用户列表
   * @param {UserinfoModel} $UserinfoModel
   * @param {Shuchu} $Shuchu
   * @return {*}
   */  
  public function get_user_list(UserinfoModel $UserinfoModel,Shuchu $Shuchu)
  {
    //这个有数据重复的问题，量大了可以想想解决
    $result = $UserinfoModel->field('uid,place,name,birthday,weight,height,school,occupation,picture')->where('picture','not null')->where('is_pass',1)->where('is_show',1)->order('id','desc')->page((int) Request::get('page'),20)->select();
    return $Shuchu->json($result);
  }
}
