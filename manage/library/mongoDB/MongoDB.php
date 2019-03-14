<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午3:36
 */

namespace manage\library\mongoDB;

use yii;
use yii\mongodb\Query;

class MongoDB
{

    /** @var \yii\mongodb\collection */
    private $_collection;
    private $_table;

    public function __construct($table)
    {
        $this->_collection = Yii::$app->mongodb->getCollection ($table);
        $this->_table = $table;
    }

    /**
     * 查询表中所有符合条件的数据
     * @param array $where  ['name'=>'新闻分类']
     * @param string $orderBy   'id DESC'
     * @param int $limit
     * @param int $offset
     * @return array|int
     */
    public function getList($where = array(), $orderBy = '', $offset = 0, $limit = 0) {
        $query = new Query;
        $query->from($this->_table);
        if($where) {
            $query->where($where);
        }
        if($orderBy) {
            $query->orderBy($orderBy);
        }
        if($offset || $limit) {
            $query->offset($offset)
                ->limit($limit);
        }
        $data = $query->all();
        $result = [];
        foreach ($data as $row) {
            $result[] = self::mongodbIdObjectToString($row);
        }

        return $result;
    }

    /**
     * 查询指定一条数据
     * @param $table
     * @param array $where
     * @return int
     */
    public function getOne($id) {
        if(!$id) {
            return false;
        }

        $where = ["_id" =>$id];
        $data = $this->_collection->findOne($where);
        if($data){
            $data = self::mongodbIdObjectToString($data);
        }

        return $data;
    }

    /**
     * 统计个数,只支持单一条件不支持多条件
     * @param $table
     * @param array $where
     * @return mixed
     */
    public function getCount($where = array()) {
        if (!empty($where)) {
            $data = $this->_collection->count($where);
        } else {
            $data = $this->_collection->count();
        }
        return $data;
    }

    /**
     * http://php.net/manual/zh/class.mongodb-bson-objectid.php
     * 把mongodb的行_id (objectId对象)转换成字符串;
     * @param $mongodbRow mongodb row
     * @return mixed $this
     */
    static function mongodbIdObjectToString($mongodbRow)
    {
        $mongodbRow['_id'] = $mongodbRow['_id']->__toString();
        return $mongodbRow;
    }

    /**
     * 向mongodb添加一行数据
     * @param $data array
     * @return string  返回mongodb 文档的id string
     */
    public function insert($data)
    {
        /** @var \yii\mongodb\collection $collection */
        $result = $this->_collection->insert($data);
        return $result->__toString();
    }

    /**
     * 删除一行根据id
     * @param $id
     * @return int
     */
    public function delete($_id)
    {
        /** @var int $result */
        $result = $this->_collection->remove(compact('_id'));
        return $result;
    }

    /**
     * 获取已发布和待发布文章的正文
     * @param $id mongoId
     * @return mixed
     */
    public function getContentById($_id)
    {
        $result = $this->_collection->findOne(compact('_id'));
        return $result['content'];
    }

    /**
     * 更新mongodb content
     * @param $_id
     * @param string $content
     * @return bool|int
     */
    public function updateContentById($_id, $content = '')
    {
        return $this->_collection->update(compact('_id'), compact('content'));
    }

    public function updateById($_id, array $data)
    {
        return $this->_collection->update(compact('_id'), $data);
    }
}