<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/20
 * Time: 下午1:42
 */

namespace manage\models\setting\dao;

use manage\models\BaseDao;

class Version extends BaseDao
{
    protected $_tableName = "version_control";
    protected $_column = 'id,version,status,remark,created_at,updated_at';

    public function init()
    {
        $this->column = $this->_column;
        parent::init();
    }

    public function create($version,$status,$remark)
    {
        $params = ['version'=>$version,'status' => $status,'remark'=>$remark];
        $result = $this->insertReturnId($this->_tableName,$params);
        return $result;
    }

    public function updateInfo($id,$version,$status,$remark)
    {
        $params = ['id' => $id,'version'=>$version,'status' => $status,'remark'=>$remark,'updated_at'=>date("Y-m-d H:i:s")];
        $result = $this->prepareSql('setting.version.sql_update_by_id', $params)->executeWrite();
        return $result;
    }

    public function del($ids)
    {
        $params = ['ids' => $ids];
        $result = $this->prepareSql('setting.version.sql_delete_by_ids', $params)->executeWrite();
        return $result;
    }

    public function exists($id)
    {
        $params = ['id'=>$id];
        $result = $this->prepareSql('setting.version.sql_get_count_by_id', $params)->find();
        return $result['count']>0 ? true : false;
    }

    public function getTotal()
    {
        $params = [];
        $result = $this->prepareSql('setting.version.sql_get_total', $params)->find();
        return $result['count'];
    }

    public function getById($id)
    {
        $params = ['id' => $id];
        $result = $this->prepareSql('setting.version.sql_get_by_id', $params)->find();
        return $result;
    }

    public function existByVersion($version)
    {
        $params = ['version' => $version];
        $result = $this->prepareSql('setting.version.sql_get_count_by_version', $params)->find();
        return $result['count']>0 ? true : false;
    }


    public function getAllList($page,$pageSize)
    {
        $result = $this->prepareSql('setting.version.sql_get_all_list', [])->paginate($page,$pageSize)->select();
        return $result;
    }
}