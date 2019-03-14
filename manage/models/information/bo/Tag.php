<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:03
 */

namespace manage\models\information\bo;

use manage\config\constant\Information;
use manage\library\BizException;
use manage\models\BaseBo;

/**
 * 主要处理tag表 和 tag_type表
 * Class Tag
 * @package manage\models\information\bo
 */
class Tag extends BaseBo
{
    protected $dao;

    function __construct()
    {
        parent::__construct();
        $this->dao = new \manage\models\information\dao\Tag();
    }

    /**
     * 废弃
     * @return array
     */
    public function getList()
    {
        return (new \manage\models\information\dao\Tag())->getList();
    }

    /**
     * 根据类型ID取tag标签列表
     * @param int $type_id
     * @return array
     */
    public function getListV2(int $type_id)
    {
        return (new \manage\models\information\dao\Tag())->getListV2($type_id);
    }

    /**
     * 转换标签的现实
     * @param array $data
     * @return array
     */
    public function convertTags(array $data): array
    {
        //解析tag
        $tagIds = explode(',', $data['tag']);
        $tags = (new \manage\models\information\dao\Tag())->getList();
        $tagObjs = [];
        $tag_names = [];
        foreach ($tags as $ttt) {
            if (in_array($ttt['id'], $tagIds)) {
                $tagObjs[] = $ttt;
                $tag_names[] = $ttt['tag_name'];
            }
        }
        $data['tags'] = $tagObjs;
        $data['tag'] = implode(',', $tag_names);
        return $data;
    }

    /**
     * V2 版本废弃这个方法
     * @param $tagNames
     * @param null $type_id
     * @return string
     */
    public function convertTagNamesToTagIdsString($tagNames, $type_id = null): string
    {
        $tagNames = trim($tagNames, ',');
        $tagNameArr = explode(',', $tagNames);
        $tags = (new \manage\models\information\dao\Tag())->getList();
        $tagList = array_column($tags, 'id', 'tag_name');
        $tagIds = [];
        foreach ($tagNameArr as $tag_name) {
            if (isset($tagList[$tag_name])) {
                $tag_id = $tagList[$tag_name];
            } else {
                //创建tag
                $tag_id = $this->addTagByName($tag_name);
            }
            $tagIds[] = $tag_id;
        }
        $tagIds = array_filter($tagIds);
        return implode(',', $tagIds);
    }


    /**
     * 按照标签名称 添加标签 并且 关联 type_id
     * @param $tagNames
     * @param null $type_id
     * @return string
     */
    public function convertTagNamesToTagIdsStringAndRelationWithTypeId($tagNames, $type_id): string
    {
        $tagNames = trim($tagNames, ',');
        $tagNameArr = explode(',', $tagNames);
        $tagTypeDao = (new \manage\models\information\dao\Tag());
        $tags = $tagTypeDao->getList();
        $tagList = array_column($tags, 'id', 'tag_name');
        $tagIds = [];
        foreach ($tagNameArr as $tag_name) {
            if (isset($tagList[$tag_name])) {
                $tag_id = $tagList[$tag_name];
            } else {
                //创建tag
                $tag_id = $this->addTagByName($tag_name);
            }
            $tagTypeDao->insertOrUpdateTagType($tag_id, $type_id, '', 1);
            $tagIds[] = $tag_id;
        }
        $tagIds = array_filter($tagIds);
        return implode(',', $tagIds);
    }


    /**
     * 通过标签名称添加标签
     * @param $name
     * @return int
     */
    public function addTagByName($name)
    {
        $creator = \Yii::$app->user->identity->realName;
        $dao = new \manage\models\information\dao\Tag();
        return $dao->addTagByName($name, $creator);
    }

    /**
     * tag_type分页
     * @param $data
     * @return array
     */
    public function pagination($data){

        $data = $this->dao->pagination($data);
        return $data;

    }

    /**
     * 获取tag_type表的一行
     * @param int $id
     * @return array|false
     */
    public function getById(int $id)
    {
        $result = $this->dao->getById($id);
        $data = Information::$typeInfo;
        $type_id = $result['type_id'];
        $result['type_name'] = $data[$type_id]['typeName'];
        return $result;
    }

    /**
     * 更新tag_type的一行数据
     * @param $id
     * @param $tag_name
     * @param $remark
     * @param $is_default
     * @param $type_id
     * @return int
     * @throws BizException
     */
    public function updateById($id, $tag_name, $remark, $is_default, $type_id)
    {
        $tagArr = $this->dao->getTagByName($tag_name);
        if (empty($tagArr)) {
            throw new BizException(0, "tag_name:$tag_name,不存在!", BizException::PARAM_ERROR);
        }
        $tag_id = $tagArr['id'];
        $res = $this->dao->updateTagType($id, $tag_id, $type_id, $remark, $is_default);
        return $res;
    }

    /**
     * 向tag_type添加数据
     * @param $tag_name
     * @param $remark
     * @param $type_josn
     * @return array
     * @throws \Exception
     */
    public function addTagType($tag_name, $remark, $type_josn)
    {
        $tagArr = $this->dao->getTagByName($tag_name);
        if (empty($tagArr)) {
            $creator = \Yii::$app->user->identity->realName;
            $tag_id = $this->dao->addTagByName($tag_name, $creator);
        }else {
            $tag_id = $tagArr['id'];
        }
        $typeArr = json_decode($type_josn, true);
        $trans = \Yii::$app->db->beginTransaction();
        $insertIds = [];
        try {
            foreach ($typeArr as $type_id => $is_default) {
                if (!isset(Information::$typeInfo[$type_id])) {
                    throw new BizException(BizException::INFO_TYPE_NOT_EXIST);
                }
                if ($this->dao->isTagIdTypeIdRowNotExist($tag_id, $type_id)) {
                    $insertIds[] = $this->dao->insertTagType($tag_id, $type_id, $remark, $is_default);
                }
            }
            $trans->commit();
        } catch (\Exception $e) {
            $trans->rollBack();
            throw  $e;
        }

        return $insertIds;
    }

    /**
     * 删除tag_type表的一行
     * @param $ids
     * @return mixed
     */
    public function deleteTagTypeByIds($ids)
    {
        $ids = explode(',', $ids);
        return $this->dao->deleteTagTypeByIds($ids);
    }
}