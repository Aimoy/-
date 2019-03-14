<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:34
 */

namespace manage\models\information\dao;

use manage\library\HtmlContent;
use manage\library\mongoDB\MongoDB;
use manage\models\BaseDao;
use yii\db\Query;

class InfoPublish extends BaseDao
{

    private $_column = 'id, type_id, title,description, content, coverage, origin_link, source,come_from, tag, share_count,
                       like_count,comment_count,read_count,updated_at, created_at,creator,display_type,video_uri';

    private $_table = 'info_published';
    private $_mongodb_collection_content = 'published';

    public function init()
    {
        $this->column = $this->_column;
        $this->listColumn = $this->_column;
        parent::init();
    }

    public function getListByPage($offset,$pageNum)
    {
        $params = ['offset' => $offset, 'pageNum' => $pageNum];
        $result = $this->queryExecute('information.infoPublish.sql_get_list_by_page', $params)->queryAll();
        return $result;
    }

    public function getInfoById($id)
    {
        $params = ['id' => $id];
        $result = $this->queryExecute('information.infoPublish.sql_get_info_by_id', $params)->queryOne();
        return $result;
    }

    public function getTotalCount()
    {
        $params = [1 => 1];
        $result = $this->queryExecute('information.infoPublish.sql_get_total_count', $params)->queryOne();
        return $result;
    }

    public function updateInfoStatus($id,$status)
    {
        $params = compact('id', 'status');
        $ret = $this->writeExecute('information.infoPublish.sql_update_status_by_id', $params);

        return $ret;
    }

    public function deleteInfoById($id)
    {
        $params = ['id' => $id];

        $ret = $this->writeExecute('information.infoPublish.sql_delete_info_by_id', $params);

        return $ret;
    }

    public function updateInfoById(
        $id,
        $type_id,
        $title,
        $content,
        $coverage,
        $source,
        $share_count,
        $like_count,
        $comment_count,
        $read_count,
        $tag,
        $display_type,
        $video_uri,
        $created_at
    ) {

        $coverage = HtmlContent::convertCoverageToOss($coverage);
        //编辑的时候自动设置成已下架
        $status = 2;
        $updated_at = date('Y-m-d H:i:s');
        $params = compact('id', 'type_id', 'title', 'content', 'coverage', 'source', 'share_count', 'like_count',
            'comment_count', 'read_count', 'tag', 'updated_at', 'display_type', 'video_uri', 'created_at', 'status');
        $ret = $this->writeExecute('information.infoPublish.sql_update_info_by_id', $params);

        return $ret;
    }

    public function insertInfo(
        $type_id,
        $title,
        $content,
        $description,
        $coverage,
        $origin_link,
        $source,
        $come_from,
        $share_count,
        $like_count,
        $comment_count,
        $status,
        $tag,
        $creator,
        $display_type,
        $video_uri,
        $created_at = null
    ) {

        $coverage = HtmlContent::convertCoverageToOss($coverage);
        $created_at = $created_at ?? date('Y-m-d H:i:s');
        $params = compact('type_id', 'title', 'content', 'description', 'coverage', 'origin_link', 'source',
            'come_from', 'share_count', 'like_count', 'comment_count', 'status', 'tag', 'creator', 'created_at',
            'display_type', 'video_uri');
        $ret = $this->writeExecute('information.infoPublish.sql_insert_info', $params);
        if($ret) {
            $ret = $this->getInsertId();
        }
        return $ret;
    }

    /**
     * 对mysql数据库进行分页
     * @param $page
     * @param $pageNum
     * @param null $createdAt
     * @param null $typeId
     * @param null $source
     * @return array
     */
    public function getPagination($data)
    {
        $page = $data['page'];
        $pageNum = $data['pageNum'];
        $rangeType = $data['rangeType'];
        $typeId = $data['typeId'];
        $source = $data['source'];

        $offset = ($page - 1) * $pageNum;

        $query = (new Query())->from($this->_table)->orderBy(['id' => SORT_DESC]);

        switch ($rangeType){
            case 1:
                $fromDate = (new \DateTime())->setTime(0, 0, 0)->format('Y-m-d H:i:s');
                $toDate = (new \DateTime())->setTime(23, 59, 59)->format('Y-m-d H:i:s');
                $query->andWhere(['>=', 'updated_at', $fromDate])->andWhere(['<=', 'updated_at', $toDate]);
                break;
            case 2:
                $fromDate = date('Y-m-d H:i:s', strtotime('-1 week'));
                $toDate = date('Y-m-d H:i:s');
                $query->andWhere(['>=', 'updated_at', $fromDate])->andWhere(['<=', 'updated_at', $toDate]);
                break;
            case 3:
                $fromDate = date('Y-m-d H:i:s', strtotime('-1 month'));
                $toDate = date('Y-m-d H:i:s');
                $query->andWhere(['>=', 'updated_at', $fromDate])->andWhere(['<=', 'updated_at', $toDate]);
                break;
            case 4:
                $fromDate = date('Y-m-d H:i:s', strtotime('-1 year'));
                $toDate = date('Y-m-d H:i:s');
                $query->andWhere(['>=', 'updated_at', $fromDate])->andWhere(['<=', 'updated_at', $toDate]);
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

    /**
     * 向已发布mongoDB wait(collection)中插入一条数据
     * @param string $content
     * @return string
     */
    public function insertContentFromHtml($content = '')
    {
        //提换正文图片到oss图片
        $content = HtmlContent::removeImageMiddleManHost($content);
        $content = HtmlContent::saveContentImageToSunlandsOssAndReplaceContentSrc($content);

        $mongoDB = new MongoDB($this->_mongodb_collection_content);
        $result = $mongoDB->insert(compact('content'));
        return $result;
    }

    public function getContentByMongoId($monogoId)
    {
        $mongoDB = new MongoDB($this->_mongodb_collection_content);
        return $mongoDB->getContentById($monogoId);
    }

    /**
     * 更新待发布MongoDB content 正文
     * @param $_id
     * @param string $content_html
     * @return bool|int
     */
    public function updateMongoContentById($_id, $content_html = '')
    {
        $content_html = HtmlContent::removeImageMiddleManHost($content_html);
        $content_html = HtmlContent::saveContentImageToSunlandsOssAndReplaceContentSrc($content_html);

        $mongoDB = new MongoDB($this->_mongodb_collection_content);
        return $mongoDB->updateContentById($_id, $content_html);
    }

    public function updateLikeCount($id,$num)
    {
        $params = ['id' => $id,'like_count'=>$num,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->prepareSql('information.infoPublish.sql_update_like_Count', $params)->executeWrite();
        return $result;
    }

    /**
     * 获取已发布文章来源
     * @return array
     */
    public function getSourceList()
    {
        $result = $this->queryExecute('information.infoPublish.sql_get_source_list', [])->queryAll();
        return $result;
    }
}