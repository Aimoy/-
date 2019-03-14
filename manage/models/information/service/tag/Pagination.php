<?php
/**
 * Created by PhpStorm.
 * User: zhouqing
 * Date: 2018/06/01
 * Time: 上午11:29
 */

namespace manage\models\information\service\tag;

use manage\library\BizException;
use manage\library\Validation;
use manage\models\information\bo\Tag;

class Pagination
{

    /**
     * desc:获取信息类型列表
     * @param $data
     * @return array|false
     */
    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('page', 'integer', 'egt:1');
        $valid->add_rules('pageNum', 'integer', 'egt:1');
        $valid->add_rules('type_id', 'integer', 'egt:1');
        $valid->add_rules('is_default', 'integer', 'in[0,1]');
        $valid->add_rules('tag_name', 'length[0,255]');
        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }
        $tagBo = new Tag();
        $data = $tagBo->pagination($data);
        return $data;
    }

}