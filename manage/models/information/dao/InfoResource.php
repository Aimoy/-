<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午2:34
 */

namespace manage\models\information\dao;

use manage\config\constant\Information;
use manage\library\mongoDB\MongoDB;
use yii\mongodb\Query;

class InfoResource
{
    /**
     * @var string  mongodb collection(table)的名称
     */
    protected $table = 'wechat_data';


    public function getInfoById($id)
    {
        $result = (new MongoDB($this->table))->getOne($id);
        return $result;
    }

    /**
     * 根据ids批量获取文章 ids 可以为单个或者数组
     * @param $ids
     * @return mixed
     */
    public function getInfoByIds($ids)
    {
        $query = new Query;
        $result = $query->from($this->table)->andWhere(['_id' => $ids])->all();
        return $result;
    }

    /**
     * 资源池类列表
     * @param $data
     * @return array
     */
    public function getPagination($data)
    {
        $page = $data['page'];
        $pageNum = $data['pageNum'];
        $source = $data['source'];
        $rangeType = $data['rangeType'];

        $offset = ($page - 1) * $pageNum;
        $query = (new Query())->from($this->table)->orderBy(['_id' => SORT_DESC])->andWhere(['<>', 'status', 1]);
        if (!empty($source)) {
            $query->andWhere(['source' => $source]);
        }
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
        if ($data['typeId'] > 0) {
            $query->andWhere(['type_id' => $data['typeId']]);
        }

        $count = $query->count();
        $result = $query->offset($offset)->limit($pageNum)->select([
            '_id',
            'title',
            'type_id',
            'source',
            'created_at',
            'status'
        ])->all();
        foreach ($result as $key => $row) {
            $result[$key]['_id'] = $row['_id']->__toString();
            $result[$key]['status'] = empty($row['status']) ? 0 : $row['status'];
            $result[$key]['created_at'] = substr($row['created_at'], 0, 16);

            $typeId = empty($row['type_id']) ? 0 : $row['type_id'];
            //$result[$key]['type_id'] = $typeId;
            $result[$key]['type_name'] = $typeId === 0 ? '' : (Information::$typeInfo[$typeId]['typeName']);


            //$result[$key]['desciption'] = HtmlContent::getDescriptionFrom($row['content'], 100);
            //unset($result[$key]['content']);
        }
        return compact('page', 'pageNum', 'result', 'count');
    }

    /** 获取爬去公众号的列表(来源) */
    public function getSourceList()
    {
        $query = (new Query())->from($this->table);
        return $query->distinct('source');
    }


    public function updateById($data)
    {
        $mg = new MongoDB($this->table);
        $_id = $data['_id'];
        unset($data['_id']);
        return $mg->updateById($_id, $data);
    }

    /**
     * 删除抓取池文章
     * @param array $ids
     * @return int
     */
    public function deleteByIds(array $ids)
    {
        $mongoDB = new MongoDB($this->table);
        $result = 0;
        foreach ($ids as $_id) {
            $result += $mongoDB->delete($_id);
        }
        return $result;
    }

    public function markEdited($id)
    {
        $mongoDB = new MongoDB($this->table);
        return $mongoDB->updateById($id, ['status' => 2]);
    }

}