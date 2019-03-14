<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:03
 */

namespace manage\models\information\bo;

use manage\library\BizException;
use manage\library\Cache;
use manage\library\HtmlContent;
use manage\library\QueueJob;
use manage\models\BaseBo;
use manage\models\information\dao\InfoPublish;

class Publish extends BaseBo
{

    public function getPublishList($offset,$pageNum)
    {
        return (new InfoPublish())->getListByPage($offset,$pageNum);
    }

    public function getInfoById($id)
    {
        $infoPublishedDao = new InfoPublish();
        $infoPublished = $infoPublishedDao->getInfoById($id);
        if (empty($infoPublished)) {
            throw new BizException(BizException::INFO_IS_NOT_EXIST);
        }

        $mgContent = $infoPublishedDao->getContentByMongoId($infoPublished['content']);
        $mgContent = $mgContent ?? '';
        $infoPublished['content_html'] = HtmlContent::changeImageSrcToMiddleManServer($mgContent);

        return $infoPublished;
    }

    public function getTotalCount()
    {
        return (new InfoPublish())->getTotalCount();
    }

    public function updateInfoStatus($id,$status)
    {
        //如果是发布状态
        if ($status == 0) {
            QueueJob::addQueueJobOfGenerateArticleOssContentImage($id);
        }


        return (new InfoPublish())->updateInfoStatus($id,$status);
    }
    public function updateInfoById(
        $id,
        $type_id,
        $title,
        $content_html,
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
        $infoPublishDao = new InfoPublish();
        //检查文章是否存在
        $publishInfo = $infoPublishDao->getInfoById($id);
        if (!$publishInfo) {
            throw new BizException(BizException::INFO_IS_NOT_EXIST);
        }
        //更新MongoDB
        $content = $publishInfo['content'];
        $res = $infoPublishDao->updateMongoContentById($content, $content_html);
        if ($res === false) {
            throw new BizException(BizException::INFO_UPDATE_MONGO_CONTENT_FAIL);
        }

        //$tag = (new Tag())->convertTagNamesToTagIdsString($tag);
        $tag = (new Tag())->convertTagNamesToTagIdsStringAndRelationWithTypeId($tag, $type_id);

        //更新推荐redis 只有在发布的时候调用
        //$this->addInfoRecommendIds($id, $tag);
        return $infoPublishDao->updateInfoById($id, $type_id, $title, $content, $coverage,
            $source, $share_count, $like_count, $comment_count, $read_count, $tag, $display_type, $video_uri,
            $created_at);
    }

    /** 待发布文章添加到已发布文章会被调用 */
    public function insertInfo(
        $type_id,
        $title,
        $content_html,
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


        $infoPublishDao = new InfoPublish();
        //插入正文到mongodb
        $content = $infoPublishDao->insertContentFromHtml($content_html);
        //插入返回的mongodb id 到数据库正文中

        //

        return $infoPublishDao->insertInfo(
            $type_id, $title,
            $content, $description,
            $coverage, $origin_link,
            $source, $come_from, $share_count,
            $like_count, $comment_count, $status,
            $tag, $creator, $display_type, $video_uri, $created_at
        );
    }

    public function getPagination($data)
    {
        return (new InfoPublish())->getPagination($data);
    }

    /**
     * 添加新发布的文章id到推荐集合
     */
    public function addInfoRecommendIds($published_id, $tagIdsString)
    {
        $configKey = "recommond.info.tag_recommond_set_ids";
        $cache = new Cache();
        $tagArray = explode(',', $tagIdsString);
        foreach ($tagArray as $tagID) {
            $cache->sadd($configKey, $tagID, $published_id);
        }
    }

    public function getSourceList()
    {
        $dao = new InfoPublish();
        return $dao->getSourceList();
    }


}