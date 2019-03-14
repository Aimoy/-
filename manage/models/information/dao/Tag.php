<?php
/**
 * Created by PhpStorm.
 * User: zhouiqng
 * Date: 2018/5/22
 * Time: 下午2:34
 */

namespace manage\models\information\dao;

use manage\config\constant\Information;
use manage\models\BaseDao;
use yii\db\Query;

class Tag extends BaseDao
{

    private $_column = 'id, tag_name';

    private $_table = 'tag';
    private $_relation_table = 'tag_type';


    public function init()
    {
        $this->column = $this->_column;
        $this->listColumn = $this->_column;
        parent::init();
    }

    public function getList()
    {
        $params = [];
        $result = $this->queryExecute('information.tag.sql_get_list', $params)->queryAll();
        return $result;
    }
    public function getListV2(int $type_id)
    {
        $params = compact('type_id');
        $result = $this->queryExecute('information.tag.sql_get_list_v2', $params)->queryAll();
        return $result;
    }

    /**
     * update or create tag_type 关系表
     * @param $tag_id
     * @param $type_id
     * @param string $remark
     * @param int $is_default
     * @return array|false|int
     */
    public function insertOrUpdateTagType($tag_id, $type_id, $remark = '', $is_default = 1)
    {
        $result = $this->queryExecute('information.tagType.sql_get_by_tag_id_type_id',
            compact('tag_id', 'type_id'))->queryOne();
        if (empty($result)) {
            $result = $this->insertTagType($tag_id, $type_id, $remark, $is_default);
        }
        return $result;
    }
    public function addTagByName($tag_name, $creator = '')
    {
        $params = compact('tag_name', 'creator');
        $ret = $this->writeExecute('information.tag.sql_insert_tag', $params);
        if ($ret < 1) {
            return 0;
        }
        return $this->getInsertId();
    }

    public function pagination($data){
        $page = $data['page'];
        $pageNum = $data['pageNum'];
        $tag_name = $data['tag_name'];
        $type_id = $data['type_id'];
        $is_default = $data['is_default'];

        $offset = ($page - 1) * $pageNum;
        $query = (new Query())->from($this->_relation_table)
            ->join('INNER JOIN','tag','tag_type.tag_id = tag.id')
            ->select('tag_type.id,tag.tag_name,tag_type.type_id,tag_id,is_default,remark')
            ->orderBy(['tag_type.updated_at' => SORT_DESC]);
        if (!empty($tag_name)) {
            $query->andWhere(['tag.tag_name'=>$tag_name]);
        }

        if (!empty($type_id)) {
            $query->andWhere(['tag_type.type_id'=>$type_id]);
        }
        if ($is_default == 1 or $is_default === 0 or $is_default === '0') {
            $is_default = intval($data['is_default']);
            $query->andWhere(['tag_type.is_default'=>$is_default]);
        }
        $count = $query->count();
        $result = $query->offset($offset)->limit($pageNum)->all();

        $data = Information::$typeInfo;


        foreach ($result as $kk => $vv) {
            $type_id = $vv['type_id'];
            $result[$kk]['type_name'] = $data[$type_id]['typeName'];
        }

        return compact('page', 'pageNum', 'result', 'count');
    }

    public function getById(int $id)
    {
        $params = compact('id');
        $result = $this->queryExecute('information.tagType.sql_get_by_id', $params)->queryOne();
        return $result;
    }

    public function getTagByName(string $tag_name)
    {
        $params = compact('tag_name');
        $result = $this->queryExecute('information.tag.sql_get_tag_by_name', $params)->queryOne();
        return $result;
    }

    public function updateTagType($id, $tag_id, $type_id, $remark, $is_default)
    {
        $params = compact('id', 'tag_id', 'type_id', 'remark', 'is_default');
        $ret = $this->writeExecute('information.tagType.sql_update_by_id', $params);
        return $ret;
    }

    public function insertTagType($tag_id, $type_id, $remark, $is_default)
    {
        $params = compact('tag_id', 'type_id', 'remark', 'is_default');
        $ret = $this->writeExecute('information.tagType.sql_tag_type_insert', $params);
        if ($ret > 0) {
            $ret = $this->getInsertId();
        }
        return $ret;
    }

    public function deleteTagTypeByIds($ids){
        $params = ['ids' => $ids];
        $ret = $this->prepareSql('information.tagType.sql_delete_tag_type_by_ids', $params)->daoDelete();
        return $ret;
    }

    public function isTagIdTypeIdRowNotExist($tag_id, $type_id): bool
    {
        $params = compact('tag_id', 'type_id');
        $result = $this->queryExecute('information.tagType.sql_get_row_from_type_id_tag_id', $params)->queryOne();
        return !$result;
    }

}