<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 上午11:29
 */

namespace manage\models\information\service\publish;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\library\Validation;

class Update
{


    /**
     *
     * $param["id"] = $this->post("id");// 文章ID
     * $param["type_id"] = $this->post("type_id(4)");// 文章分类ID
     * $param["content_html"] = $this->post("content_html");// 文章正文
     * $param["coverage"] = $this->post("coverage");// 文章封面,多张以逗号分隔
     * $param["source"] = $this->post("source",string(255));// 文章来源
     * $param["like_count"] = $this->post("like_count");// 点赞数量
     * $param["comment_count"] = $this->post("comment_count");// 评论数量
     * $param["read_count"] = $this->post("read_count");// 阅读数量
     * $param["tag"] = $this->post("tag");// 文章tagID多个以逗号分隔
     * $param["display_type"] = $this->post("display_type");// 显示样式 1:无图 2:一张大图 3:左图右文 4:视频 5:三张图片
     * $param["video_uri"] = $this->post("video_uri");// 视频的URI
     */

    public function execute($data)
    {
        $valid = new Validation($data);
        $valid->add_rules('id', 'required', 'integer', 'gtlt[0,9999999999]');
        $valid->add_rules('type_id', 'required', 'integer', 'gt:0');

        $valid->add_rules('title', 'required', 'mb_length[1,255]');
        $valid->add_rules('coverage', 'length[0,1024]');
        $valid->add_rules('source', 'required', 'mb_length[1,20]');

        $valid->add_rules('share_count', 'required', 'integer', 'length[1,11]');
        $valid->add_rules('like_count', 'required', 'integer', 'length[1,11]');
        $valid->add_rules('comment_count', 'required', 'integer', 'length[1,11]');
        $valid->add_rules('read_count', 'required', 'integer', 'length[1,11]');
        $valid->add_rules('created_at', 'required', 'mysqlDatetime');

        $valid->add_rules('tag', 'required', 'mb_length[1,255]');
        $valid->add_rules('display_type', 'required', 'in[1,2,3,4,5]');
        $data['status'] = 2; //编辑修改文章为下架状态
        if ($data['display_type'] == 4) {
            $valid->add_rules('video_uri', 'required', 'length[1,255]');
        } else {
            $valid->add_rules('content_html', 'required');
            $data['video_uri'] = '';
        }
        if ($data['display_type'] != 1) {
            $valid->add_rules('coverage', 'required');
        }

        if (!$valid->validate()) {
            throw new BizException(0, $valid->getErrorMsg(), BizException::PARAM_ERROR);
        }

        if ($data['display_type'] == 5) {
            $coverageArr = explode(',', $data['coverage']);
            if (count($coverageArr) !== 3) {
                throw new BizException(0, '三图模式,请选择三张图片!', BizException::PARAM_ERROR);
            }
        }

        if (!isset(Information::$typeInfo[$data['type_id']])) {
            throw new BizException(0, 'type_id参数错误', BizException::PARAM_ERROR);
        }
        if (stripos($data['tag'], '，') !== false) {
            throw new BizException(0, 'tag分隔符必须是英文半角逗号', BizException::PARAM_ERROR);
        }

        $publishBo = new \manage\models\information\bo\Publish();

        $result = $publishBo->updateInfoById(
            $data['id'],
            $data['type_id'],
            $data['title'],
            $data['content_html'],
            $data['coverage'],
            $data['source'],
            $data['share_count'],
            $data['like_count'],
            $data['comment_count'],
            $data['read_count'],
            $data['tag'],
            $data['display_type'],
            $data['video_uri'],
            $data['created_at']
        );
        if ($result == 0) {
            throw new BizException(BizException::INFO_UPDATE_FAIL);
        }
        return $result;
    }

}