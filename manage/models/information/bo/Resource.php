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
use manage\models\information\dao\InfoPublish;
use manage\models\information\dao\InfoResource;

class Resource extends BaseBo
{


    public function getInfoById($id)
    {
        $info = (new InfoResource())->getInfoById($id);
        if (empty($info)) {
            throw  new BizException(BizException::INFO_IS_NOT_EXIST);
        }

        $info['type_id'] = empty($info['type_id']) ? 1 : $info['type_id'];
        $info['coverage'] = empty($info['coverage']) ? '' : $info['coverage'];
        $info['tag'] = empty($info['tag']) ? '' : $info['tag'];
        $info['video_uri'] = empty($info['video_uri']) ? '' : $info['video_uri'];
        $info['status'] = empty($info['status']) ? 0 : $info['status'];
        $info['display_type'] = empty($info['display_type']) ? 1 : $info['display_type'];
        unset($info['is_selected']);

        //移除gif图片
        $imgsss = isset($info['article_imgs']) ? $info['article_imgs'] : [];
        $imgsss = array_filter($imgsss, function ($vo) {
            $height = $vo['img_w'] * $vo['img_radio'];
            if ($height < 120) {
                return false;
            }
            if ($vo['img_radio'] < 0.2) {
                return false;
            }
            return !stripos($vo['img_url'], 'gif');
        });
        $info['article_imgs'] = array_values($imgsss);
        //提换data-src

        $info['content'] = HtmlContent::changeImageSrcToMiddleManServer($info['content']);


        return $info;
    }


    /**
     * 批量获取mongoDB的文章
     * @param array $ids
     */
    public function getInfoByIds($ids = [])
    {
        //TODO::需要过滤掉已筛选的
        return (new InfoResource())->getInfoByIds($ids);


    }

    /**
     * 资源池列表接口
     * @param array $data
     * @return array
     */
    public function getPagination($data)
    {
        $resourceDao = new InfoResource();
        return $resourceDao->getPagination($data);
    }

    /**
     * 获取爬虫的来源列表(爬取公众号列表)
     */
    public function getSourceList()
    {
        $resourceDao = new InfoResource();
        return $resourceDao->getSourceList();
    }

    public function updateById($data)
    {
        //$data['tag'] = (new Tag())->convertTagNamesToTagIdsString($data['tag']);
        $data['tag'] = (new Tag())->convertTagNamesToTagIdsStringAndRelationWithTypeId($data['tag'], $data['type_id']);

        $data['content'] = HtmlContent::removeImageMiddleManHost($data['content']);
        $resourceDao = new InfoResource();
        return $resourceDao->updateById($data);
    }


    public function updateStatus($_id, $status)
    {
        $data = compact('_id', 'status');
        $resourceDao = new InfoResource();
        return $resourceDao->updateById($data);
    }

    /**
     *
     * @param $mongoArticleData mongodb取出的文章内容
     * @return bool|int
     * @throws \yii\db\Exception
     */
    public function publishSpiderArticle($mongoArticleData)
    {
        $publishDao = new InfoPublish();

        //修改爬虫数据的状态,是否标记已发布已编辑
        $status = 1;//0:正常未发布状态 1:已发布,2:已删除,3:已标记编辑
        (new Resource())->updateStatus($mongoArticleData['_id'], $status);

        try {
            //复制数据到publish mysql 表中 复制文章正文到MongoDB publish 表中
            //富文本图片储存到自己oss
            //提换富文本和coverage
            $mongoContentId = $publishDao->insertContentFromHtml($mongoArticleData['content']);
            $result = $publishDao->insertInfo(
                $mongoArticleData['type_id'],
                $mongoArticleData['title'],
                $mongoContentId,
                $mongoArticleData['description'],
                $mongoArticleData['coverage'],
                $mongoArticleData['origin_link'],
                $mongoArticleData['source'],
                1, 0, 0, 0, 0,
                $mongoArticleData['tag'],
                $mongoArticleData['creator'],
                $mongoArticleData['display_type'],
                $mongoArticleData['video_uri'],
                $mongoArticleData['created_at']
            );
        } catch (\Exception $e) {
            //修改文章到正常未发布状态
            $status = 0;//0:正常未发布状态 1:已发布,2:已删除,3:已标记编辑
            (new Resource())->updateStatus($mongoArticleData['_id'], $status);
            throw $e;
        }

        if ($result > 0) {
            //添加文章到推荐redis里面
            $publishBo = new Publish();
            $publishBo->addInfoRecommendIds($result, $mongoArticleData['tag']);
        }

        return $result;
    }


    public function deleteByIds($ids)
    {
        $_idArray = explode(',', $ids);
        $resourceDao = (new InfoResource());
        return $resourceDao->deleteByIds($_idArray);

    }

    public function markEdited(string $id)
    {
        $resourceDao = (new InfoResource());
        return $resourceDao->markEdited($id);
    }
}