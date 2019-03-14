<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:34
 */

namespace manage\models\information\dao;

use manage\library\mongoDB\MongoDB;
use manage\models\BaseDao;
use yii\db\Query;

class InfoOperation extends BaseDao
{

    private $_column = 'id, type_id, title, content,coverage, origin_link, source, status, tag, 
                       updated_at, created_at,creator,display_type,video_uri';

    private $_table = 'info_operation';

    private $_mongodb_collection_content = 'operation';



    public function init()
    {
        $this->column = $this->_column;
        $this->listColumn = $this->_column;
        parent::init();
    }

    public function getOperationPagination($page, $pageNum, $rangeType = null, $typeId = null, $source = null)
    {
        $offset = ($page - 1) * $pageNum;

        $query = (new Query())->from($this->_table)->select($this->column)->orderBy(['updated_at' => SORT_DESC])->andWhere(['status' => 0]);
        switch ($rangeType) {
            case 1:
                $fromDate = (new \DateTime())->setTime(0, 0, 0)->format('Y-m-d H:i:s');
                $toDate = (new \DateTime())->setTime(23, 59, 59)->format('Y-m-d H:i:s');
                $query->andWhere(['>=', 'created_at', $fromDate])->andWhere(['<=', 'created_at', $toDate]);
                break;
            case 2:
                $fromDate = date('Y-m-d H:i:s', strtotime('-1 week'));
                $toDate = date('Y-m-d H:i:s');
                $query->andWhere(['>=', 'created_at', $fromDate])->andWhere(['<=', 'created_at', $toDate]);
                break;
            case 3:
                $fromDate = date('Y-m-d H:i:s', strtotime('-1 month'));
                $toDate = date('Y-m-d H:i:s');
                $query->andWhere(['>=', 'created_at', $fromDate])->andWhere(['<=', 'created_at', $toDate]);
                break;
            case 4:
                $fromDate = date('Y-m-d H:i:s', strtotime('-1 year'));
                $toDate = date('Y-m-d H:i:s');
                $query->andWhere(['>=', 'created_at', $fromDate])->andWhere(['<=', 'created_at', $toDate]);
                break;
        }

        if (!empty($typeId)) {
            $query->andWhere(['type_id' => $typeId]);
        }
        if (!empty($source)) {
            $query->andWhere(['source' => $source]);
        }
        $count = $query->count();
        $result = $query->offset($offset)->limit($pageNum)->all();

        return compact('page', 'pageNum', 'result', 'count');
    }

    public function getInfoById($id)
    {
        $params = ['id' => $id];
        $result = $this->queryExecute('information.infoOperation.sql_get_info_by_id', $params)->queryOne();
        return $result;
    }

    public function getInfoByIds($ids)
    {
        $params = ['ids' => $ids];
        $result = $this->prepareSql('information.infoOperation.sql_get_info_by_ids', $params)->select();
        return $result;
    }

    public function getTotalCount()
    {
        $params = [1 => 1];
        $result = $this->queryExecute('information.infoOperation.sql_get_total_count', $params)->queryOne();
        return $result;
    }

    public function updateInfoStatus($id)
    {
        $params = ['id' => $id, 'infoStatus' => 1];
        $ret = $this->writeExecute('information.infoOperation.sql_update_status_by_id', $params);

        return $ret;
    }

    public function deleteInfoById($id)
    {
        $params = ['id' => $id];
        $ret = $this->writeExecute('information.infoOperation.sql_delete_info_by_id', $params);

        return $ret;
    }

    public function deleteInfoByIds($ids)
    {
        $params = ['ids' => $ids];
        $ret = $this->prepareSql('information.infoOperation.sql_delete_info_by_ids', $params)->daoDelete();

        return $ret;
    }

    public function updateInfoById(
        $id,
        $type_id,
        $title,
        $content,
        $description,
        $coverage = '',
        $origin_link,
        $source = '',
        $tag = '',
        $creator = '',
        $display_type = 1,
        $video_uri = '',
        $created_at
    ) {
        $updated_at = date('Y-m-d H:i:s');
        $params = compact('id', 'type_id', 'title', 'content', 'description', 'coverage', 'origin_link', 'source',
            'tag', 'creator', 'display_type', 'video_uri', 'updated_at', 'created_at');
        $ret = $this->writeExecute('information.infoOperation.sql_update_info_by_id', $params);

        return $ret;
    }

    public function insertInfo(
        $type_id,
        $title,
        $content,
        $description,
        $coverage = '',
        $origin_link,
        $source = '',
        $status = 0,
        $tag = '',
        $creator = '',
        $display_type = 1,
        $video_uri = ''
    )
    {
        $params = compact('type_id', 'title', 'content', 'description', 'coverage', 'origin_link', 'source',
            'status', 'tag', 'creator', 'display_type', 'video_uri');
        $ret = $this->writeExecute('information.infoOperation.sql_insert_info', $params);
        if ($ret) {
            $ret = $this->getInsertId();
        }
        return $ret;
    }

    public function insertContentToMongoWait($content = '')
    {
        $mongoDB = new MongoDB($this->_mongodb_collection_content);
        if (empty($content)) {
            $content = '<p></p>';
        }
        $mongoObjectIdString = $mongoDB->insert(compact('content'));
        return $mongoObjectIdString;
    }

    public function getContentByMongoId($monogoId)
    {
        $mongoDB = new MongoDB($this->_mongodb_collection_content);
        return $mongoDB->getContentById($monogoId);
    }

    /**
     * 根据mongoId删除mongodb 正文
     * @param $mongoId
     * @return int
     */
    public function deleteMongoContent($mongoId)
    {
        $mongoDB = new MongoDB($this->_mongodb_collection_content);
        return $mongoDB->delete($mongoId);
    }

    /**
     * 更新待发布MongoDB content 正文
     * @param $_id
     * @param string $content_html
     * @return bool|int
     */
    public function updateMongoContentById($_id, $content_html = '')
    {
        if (empty($content_html)) {
            $content_html = '<p></p>';
        }
        $mongoDB = new MongoDB($this->_mongodb_collection_content);
        return $mongoDB->updateContentById($_id, $content_html);
    }

    /**
     * 获取已发布文章来源
     * @return array
     */
    public function getSourceList()
    {
        $result = $this->queryExecute('information.infoOperation.sql_get_source_list', [])->queryAll();
        return $result;
    }

}