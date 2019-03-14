<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:03
 */

namespace manage\models\information\bo;

use manage\library\BizException;
use manage\library\HtmlContent;
use manage\models\BaseBo;
use manage\models\information\dao\InfoOperation;

class Operation extends BaseBo
{

    public function getOperationArticlePagination($page, $pageNum, $rangeType = null, $typeId = null, $source = null)
    {
        return (new InfoOperation())->getOperationPagination($page, $pageNum, $rangeType, $typeId, $source);
    }


    public function getInfoById($id)
    {
        $infoWaitDao = new InfoOperation();
        $waitInfo = (new InfoOperation())->getInfoById($id);
        if (empty($waitInfo)) {
            throw new BizException(BizException::INFO_IS_NOT_EXIST);
        }
        $mongoContent = $infoWaitDao->getContentByMongoId($waitInfo['content']);
        $mongoContent = $mongoContent ?? '';
        $waitInfo['content_html'] = HtmlContent::changeImageSrcToMiddleManServer($mongoContent);


        return $waitInfo;
    }

    public function getInfoByIds($ids)
    {
        return (new InfoOperation())->getInfoByIds($ids);
    }

    public function getTotalCount()
    {
        return (new InfoOperation())->getTotalCount();
    }

    public function updateInfoStatus($id)
    {
        return (new InfoOperation())->updateInfoStatus($id);
    }

    public function deleteInfoById($id)
    {
        return (new InfoOperation())->deleteInfoById($id);
    }

    public function deleteInfoByIds($ids)
    {
        $waitInfos = $this->getInfoByIds($ids);
        if (empty($waitInfos)) {
            throw new BizException(BizException::INFO_IS_NOT_EXIST);
        }
        $infoWaitDao = new InfoOperation();
        foreach ($waitInfos as $info) {
            $mongoId = $info['content'];
            $infoWaitDao->deleteMongoContent($mongoId);
        }
        return $infoWaitDao->deleteInfoByIds($ids);
    }

    public function updateInfoById(
        $id,
        $type_id,
        $title,
        $content_html,
        $description,
        $coverage = '',
        $origin_link,
        $source = '',
        $tag = '',
        $creator = '',
        $display_type = 1,
        $video_uri = '',
        $created_at
    )
    {
        //检查文章是否存在
        $infoWaitDao = new InfoOperation();
        $waitInfo = $infoWaitDao->getInfoById($id);
        if (!$waitInfo) {
            throw new BizException(BizException::INFO_IS_NOT_EXIST);
        }
        if ($waitInfo['status'] == 1) {
            throw new BizException(BizException::INFO_CAN_NOT_UPDATE_FOR_PUBLISHED);
        }
        //更新MongoDB
        $content = $waitInfo['content'];
        $res = $infoWaitDao->updateMongoContentById($content, $content_html);
        if ($res === false) {
            throw new BizException(BizException::INFO_UPDATE_MONGO_CONTENT_FAIL);
        }
        //$tag = (new Tag())->convertTagNamesToTagIdsString($tag);
        $tag = (new Tag())->convertTagNamesToTagIdsStringAndRelationWithTypeId($tag, $type_id);
        return $infoWaitDao->updateInfoById($id, $type_id, $title, $content, $description, $coverage, $origin_link,
            $source, $tag, $creator, $display_type, $video_uri, $created_at);
    }

    /**
     * 返回插入的ID
     * @param $type_id
     * @param $title
     * @param $content_html
     * @param $description
     * @param string $coverage
     * @param $origin_link
     * @param string $source
     * @param int $status
     * @param string $tag
     * @param string $creator
     * @param int $display_type
     * @param string $video_uri
     * @return int
     */
    public function insertInfo(
        $type_id,
        $title,
        $content_html,
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
        $content_html = str_ireplace('data-src', 'src', $content_html);
        $content_html = preg_replace('/<(script.*?)>(.*?)<(\/script.*?)>/si', '', $content_html);

        $InfoWaitDao = new InfoOperation();
        $content = $InfoWaitDao->insertContentToMongoWait($content_html);

        //$tag = (new Tag())->convertTagNamesToTagIdsString($tag);
        $tag = (new Tag())->convertTagNamesToTagIdsStringAndRelationWithTypeId($tag, $type_id);
        return $InfoWaitDao->insertInfo(
            $type_id,
            $title,
            $content,
            $description,
            $coverage,
            $origin_link,
            $source,
            $status,
            $tag,
            $creator,
            $display_type,
            $video_uri
        );
    }

    public function getSourceList()
    {
        $dao = new InfoOperation();
        return $dao->getSourceList();
    }
}