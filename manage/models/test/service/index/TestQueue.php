<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/5/17
 * Time: 下午8:27
 */

namespace manage\models\test\service\index;

use manage\library\ConfigParse;
use manage\library\QueueJob;

class TestQueue
{

    public function execute($data)
    {
        $testChannel = ConfigParse::parseQueue('delayjob.msg_test');

        QueueJob::add($testChannel['channel'], $data['value'], $testChannel['delayTime']);
    }
}