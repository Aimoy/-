<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\interaction\service\review;

use manage\library\BizException;
use manage\library\Validation;

class WarningList
{

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('page','required','integer','gt:0');
        $valid->add_rules('pageSize','required','integer','gt:0');
        if (!$valid->validate()) {
            throw new BizException(BizException::PARAM_ERROR );
        }
        $result = ['count'=>0,'page'=>$data['page'],'pageSize'=>$data['pageSize'],'list'=>[]];
        $replyBo = new \manage\models\interaction\bo\Review();
        $startDate = date('Y-m-d H:i:s', strtotime('-7 days'));
        $endDate = date('Y-m-d H:i:s');

        $result['count'] = $replyBo->getWarningListCount($startDate,$endDate);
        $warningList = $replyBo->getWarningList($data['page'],$data['pageSize'],$startDate,$endDate);
        $infoBo = new \manage\models\information\bo\Publish();
        foreach ($warningList as $k=>$v)
        {
            $result['list'][$k] = $v;
            if($v['article_id']){
                $article = $infoBo->getInfoById($v['article_id']);
                $result['list'][$k]['title'] = $article ? $article['title'] : "暂无标题";
            }else{
                $result['list'][$k]['title'] = "暂无标题";
            }

            $result['list'][$k]['type'] = $v['comment_id']==0 ? 1 : 2;
        }
        return $result;
    }


}