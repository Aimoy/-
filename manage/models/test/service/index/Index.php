<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/21
 * Time: 上午11:20
 */

namespace manage\models\test\service\index;

use manage\library\weChat\WTemplate;
use manage\library\weChat\WeChat;

class Index
{

    public function execute($data)
    {
        header('content-type:image/gif');
        echo WeChat::getQrCode('xxxx','pages/index1/index1',430);die;
        //var_dump(WTemplate::pushReplyMessage("o1XVc5U0K8Fqi0XX3eAttngMBRAo",1,"1529561463369","你们好",date("Y-m-d H:i:s"),""));
        //var_dump(WTemplate::pushArticle("o1XVc5U0K8Fqi0XX3eAttngMBRAo",1,"1529648435423","阿根廷出线形势分析",date("Y-m-d H:i:s"),""));
        //var_dump(WTemplate::getList(1,5));
        die;
    }
}