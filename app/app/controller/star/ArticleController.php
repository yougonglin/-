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
use app\app\model\star\ArticleCommentModel;
use app\app\model\star\ArticleLogModel;
use \supernova\Shuchu;
use app\app\model\user\UserModel;
use app\app\model\user\YueLog;
use app\app\model\user\PayLogModel;
use think\facade\Db;
use app\app\model\user\JinbiLogModel;
use think\facade\Request;
class ArticleController
{

    /**
     * @description: 发帖
     * @param {ArticleLogModel} $ArticleLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function publish(ArticleLogModel $ArticleLogModel,Shuchu $Shuchu)
    {
        if(request()->userInfo->uid == 1){
            $data = Request::post(['content','imgs','audio','video','file_info','file_content']);
            //判断是否在视频白名单
            if($data['video']){
                $isVideo = preg_match('/kuaishou.com|douyin.com|bilibili.com|b23.tv/i',$data['video']);
                if($isVideo == 0){
                    return $Shuchu->json(201,'视频链接只能是抖音/快手/B站，您的链接有误请重试');
                }
            }
            $data['uid'] = request()->userInfo->uid;
            $ArticleLogModel->save($data);
            return $Shuchu->json($ArticleLogModel->id);
        }else{
            return $Shuchu->json(201,'您目前无权发帖');
        }
    }

    /**
     * @description: 帖子列表
     * @param {ArticleLogModel} $ArticleLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function list(ArticleLogModel $ArticleLogModel,PayLogModel $PayLogModel,Shuchu $Shuchu)
    {
        $uid = Request::get('uid','');
        if($uid){
            //判断是获取自身贴还是收藏/付费
            if(Request::get('isSelf','false') == 'true'){
                $result = $ArticleLogModel->field('id,uid,content,imgs,audio,video,file_info,create_time')->where('uid',$uid)->page((int) input('get.page'),15)->order('id','desc')->select()->toArray();
            }else{
                //获取付费或收藏的帖子数组
                $ids = $PayLogModel->where('uid',$uid)->value(Request::get('payType',''));
                $ids = array_slice(array_reverse(array_column($ids,'id')),(input('get.page') - 1) * 15,15);
                $result = $ArticleLogModel->field('id,uid,content,imgs,audio,video,file_info,create_time')->where('id','in',$ids)->order('id','desc')->select()->toArray();
            }
        }else{
            //还缺少热门等功能
            $result = $ArticleLogModel->field('id,uid,content,imgs,audio,video,file_info,create_time')->page((int) input('get.page'),15)->order('id','desc')->select()->toArray();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 帖子详情
     * @param {ArticleLogModel} $ArticleLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function details(ArticleLogModel $ArticleLogModel,Shuchu $Shuchu)
    {
        $result = $ArticleLogModel->field('id,uid,content,imgs,audio,video,file_info,create_time')->where('id',input('get.id'))->find();
        return $Shuchu->json($result);
    }

    /**
     * @description: 获取评论
     * @param {ArticleCommentModel} $ArticleCommentModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function comment_get(ArticleCommentModel $ArticleCommentModel,Shuchu $Shuchu)
    {
        //缺少热门评价以及子评价查看
        $result = $ArticleCommentModel->withoutField('article_id')->where('article_id',input('get.articleId'))->page(input('get.page'),15)->order('id','desc')->select()->toArray();
        return $Shuchu->json($result);
    }

    /**
     * @description: 新增评论
     * @param {ArticleCommentModel} $ArticleCommentModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function comment_add(ArticleCommentModel $ArticleCommentModel,Shuchu $Shuchu)
    {
        $data = input('post.');
        $data = Request::post(['content','imgs','audio','video','file_info','file_content']);
        unset($data['id']);
        unset($data['nums']);
        $data['uid'] = request()->userInfo->uid;
        $ArticleCommentModel->save($data);
        return $Shuchu->json($ArticleCommentModel->id);
    }

    /**
     * @description: 附件购买
     * @param {UserModel} $UserModel
     * @param {ArticleLogModel} $ArticleLogModel
     * @param {YueLog} $YueLog
     * @param {JinbiLogModel} $JinbiLogModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function buy_file(UserModel $UserModel,ArticleLogModel $ArticleLogModel,YueLog $YueLog,JinbiLogModel $JinbiLogModel,PayLogModel $PayLogModel,Shuchu $Shuchu)
    {
        //获取付费内容
        $result = $ArticleLogModel->field('uid,file_info,file_content')->where('id',input('post.id'))->find();
        //查看自身已付费的内容,判断文章是否已购买
        $articleFile = $PayLogModel->where('uid',request()->userInfo->uid)->value('article_file');
        if(isset($articleFile)){
            //反转数组，最新购买的先判断
            $articleFile = array_reverse($articleFile);
            foreach ($articleFile as $key => $value) {
                //如果等于说明已购买
                if($value['id'] == input('post.id')){
                    $result = $result['file_content'];
                    return $Shuchu->json($result);
                }
            }
        }
        Db::startTrans();
        try {
            //扣除用户余额
            $UserModel->where('uid',request()->userInfo->uid)->dec('yue_num',(float) $result['file_info']['price'])->update();
            $YueLog->save([
                'uid' => request()->userInfo->uid,
                'num' => (float) $result['file_info']['price'],
                'type' => 2,
                'mark' => '付费帖子ID：' . input('post.id')
            ]);
            //增加帖子用户金币
            $UserModel->where('uid',$result['uid'])->inc('jinbi_num',(float) $result['file_info']['price'])->update();
            $JinbiLogModel->save([
                'uid' => $result['uid'],
                'num' => (float) $result['file_info']['price'],
                'type' => 1,
                'mark' => '付费帖子ID:' . input('post.id') . ',用户ID:' . request()->userInfo->uid
            ]);
            //加入付费记录
            if(isset($articleFile)){
                $data = array("article_file" => Db::raw('JSON_ARRAY_APPEND(article_file,"$",JSON_OBJECT("id", '.input('post.id').',"time",'.time().',"expire",0))'));
                $PayLogModel->where('uid',request()->userInfo->uid)->update($data);
            }else{
                $data = array("uid" => request()->userInfo->uid,"article_file" => Db::raw('JSON_ARRAY_APPEND("[]","$",JSON_OBJECT("id", '.input('post.id').',"time",'.time().',"expire",0))'));
                $PayLogModel->duplicate($data)->insert($data);
            }
            //返回付费内容
            $result = $result['file_content'];
            // 提交事务
            Db::commit();
        } catch (\Exception $e) {
            $result = '抱歉,您的余额不足。请充值后重试!';
            // 回滚事务
            Db::rollback();
        }
        return $Shuchu->json($result);
    }

    /**
     * @description: 删除帖子或评论
     * @param {ArticleLogModel} $ArticleLogModel
     * @param {ArticleCommentModel} $ArticleCommentModel
     * @param {Shuchu} $Shuchu
     * @return {*}
     */    
    public function del(ArticleLogModel $ArticleLogModel,ArticleCommentModel $ArticleCommentModel,Shuchu $Shuchu)
    {
        $articleId = Request::post('id','');
        $commentId = Request::post('commentId','');
        //如果存在指定评论ID，说明是删除自身评论，否则删除帖子
        if($commentId){
            $ArticleCommentModel->where('uid',request()->userInfo->uid)->where('id',$commentId)->delete();
        }else{
            $ArticleLogModel->where('uid',request()->userInfo->uid)->where('id',$articleId)->delete();
            //删除该帖子下的所有评论
            $ArticleCommentModel->where('uid',request()->userInfo->uid)->where('article_id',$articleId)->delete();
        }
        return $Shuchu->json('删除完成');
    }
}
