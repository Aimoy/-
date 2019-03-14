<?php
/**
 * Created by PhpStorm.
 * User:  zhouqing
 * Date: 2018/4/8
 * Time: 下午2:34
 */

namespace manage\models\oss\dao;

use manage\models\BaseDao;

class Media extends BaseDao
{

    private $_column = 'id, uri, format, mime_type, size, bucket, creator, created_at, updated_at';

    public function init()
    {
        $this->column = $this->_column;
        $this->listColumn = $this->_column;
        parent::init();
    }


    public function insertInfo($uri, $format, $mime_type, $size, $bucket, $creator)
    {
        $params = compact('uri', 'format', 'mime_type', 'size', 'bucket', 'creator');
        $ret = $this->writeExecute('oss.media.sql_insert_info', $params);
        if ($ret) {
            $ret = $this->getInsertId();
        }
        return $ret;
    }

    public function getMediaByKey($uri)
    {
        $params = ['uri' => $uri];
        $result = $this->queryExecute('oss.media.sql_get_media_by_uri', $params)->queryOne();
        return $result;

    }

}