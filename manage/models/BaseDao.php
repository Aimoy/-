<?php
/***
 * @author laosun
 *
 */

namespace manage\models;

use manage\library\ConfigParse;
use yii;
use yii\db\Command;

class BaseDao extends Command
{

    protected $column;
    protected $_tableName;
    protected $_pk = 'id';
    protected $listColumn;
    protected $_statement;
    protected $bind = [];

    /*****
     * @param string $sid
     * @param $params
     * @return $this
     * @add  queryOne
     * @add  queryAll
     */
    protected function queryExecute($sid, array $params)
    {
        return Yii::$app->db->createCommand(ConfigParse::parseSql($sid, $this->column))
            ->bindValues($params);
    }

    /***
     * @param string $sid
     * @param array $params
     * @return int
     */
    protected function writeExecute($sid, array $params)
    {
        return Yii::$app->db->createCommand(ConfigParse::parseSql($sid))
            ->bindValues($params)
            ->execute();
    }

    /***
     * @param string $table
     * @param array $data
     * @return $this
     */
    protected function insertBatch($table, array $data)
    {
        return Yii::$app->db->createCommand()
            ->batchInsert($table, $this->column, $data);
    }

    protected function insertReturnId($table, array $data)
    {
        return Yii::$app->db->schema->insert($table, $data);
    }

    /**
     * 转化sql语句,预处理参数
     * @param $sid
     * @param array $params
     * @return $this
     */
    protected function prepareSql($sid, array $params)
    {
        $this->bind = [];
        $this->_statement = Yii::$app->db->createCommand(ConfigParse::parseSql($sid, $this->column,false));
        $this->getBind($params);

        return $this;
    }

    /**
     * 获取绑定参数值
     * @param $params
     * @return Command
     */
    private function getBind($params)
    {
        foreach ($params as $k=>$v)
        {
            $pdoType = $this->getPdoType($v);
            if($pdoType == 999){    //数组
                $v = array_values($v);
                $replace = "";
                for($i=count($v)-1;$i>=0;$i--)
                {
                    $type = $this->getPdoType($v[$i]);
                    if($type>=0 && $type<999)
                    {
                        $this->bind[":".$i.$k] = [$v[$i], $type];
                        $replace .= ":".$i.$k.",";
                    }
                }
                $this->_statement->setRawSql(str_replace(":".$k,rtrim($replace,","),$this->_statement->rawSql));

            }elseif($pdoType){
                $this->bind[":".$k] = [$v, $pdoType];
            }
        }
        return $this;
    }

    /**
     * @param $v
     * @return bool|int
     */
    private function getPdoType($v)
    {
        if (is_int($v))
            $param = \PDO::PARAM_INT;
        elseif (is_bool($v))
            $param = \PDO::PARAM_BOOL;
        elseif (is_null($v))
            $param = \PDO::PARAM_NULL;
        elseif (is_string($v))
            $param = \PDO::PARAM_STR;
        elseif (is_array($v))
            $param = 999;
        else
            $param = false;

        return $param;
    }

    /**
     * 单个order在sql中以:order替换，多个order以:0order,:1order替换
     * @param $orderBy
     * @return $this
     */
    protected function order($orderBy)
    {
        $orderBy = is_array($orderBy) && count($orderBy)==1 ? array_shift($orderBy) : $orderBy;
        if(is_string($orderBy) && !empty($orderBy))
        {
            $this->_statement->setRawSql(str_replace(":order",rtrim($orderBy),$this->_statement->rawSql));
        }elseif(is_array($orderBy)){
            foreach ($orderBy as $k=>$v)
            {
                $this->_statement->setRawSql(str_replace(":".$k."order",rtrim($v),$this->_statement->rawSql));
            }
        }else{
            $this->_statement->setRawSql(str_replace(":order",1,$this->_statement->rawSql));
        }
        return $this;
    }

    /**
     * @param $page
     * @param $pageSize
     * @return $this
     */
    protected function paginate($page,$pageSize)
    {
        $offset = $page>=1 ? ($page-1)*$pageSize : 0;
        $replace = $offset.",".(int)$pageSize;
        $this->_statement->setRawSql(str_replace(":limit",$replace,$this->_statement->rawSql));
        return $this;
    }

    /**
     * 绑定参数
     */
    private function bindVal()
    {
        foreach ($this->bind as $field=>$val)
        {
            if(strstr($this->_statement->rawSql,$field) !== false){
                $this->_statement->bindValue($field,$val[0],$val[1]);
            }
        }
    }

    /**
     * 查询列表
     * @param $field
     * @return mixed
     */
    protected function select($field="")
    {
        $this->bindVal();
        $columns = is_array($field) && !empty($field) ? implode(",",$field) : ($field ? $field : $this->column);
        $this->_statement->setRawSql(str_replace('#COLUMN#', $columns, $this->_statement->rawSql));
        return $this->_statement->queryAll();
    }

    /**
     * 查找单个
     * @param $field
     * @return mixed
     */
    protected function find($field="")
    {
        $this->bindVal();
        $columns = is_array($field) && !empty($field) ? implode(",",$field) : ($field ? $field : $this->column);
        $this->_statement->setRawSql(str_replace('#COLUMN#', $columns, $this->_statement->rawSql));
        return $this->_statement->queryOne();
    }

    /**
     * 执行更新或删除
     * @return mixed
     */
    protected function executeWrite()
    {
        $this->bindVal();
        return $this->_statement->execute();
    }

    /***
     * 获取插入数据的ID
     * @return int
     */
    protected function getInsertId()
    {
        return Yii::$app->db->getLastInsertID();
    }

    /**
     * 使用prepareSql之后 当执行delete,update,insert连贯操作执行
     * @return mixed
     */
    protected function daoDelete()
    {
        $this->bindVal();
        return $this->_statement->execute();
    }

    /**
     * 获取待执行sql
     * @return mixed
     */
    protected function getExecuteSql()
    {
        $this->bindVal();
        return $this->_statement->getRawSql();
    }

    /**
     * 记录是否存在
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function exists($id)
    {
        if(intval($id) && $this->_tableName && $this->_pk){
            $st = Yii::$app->db->createCommand("select count(1) as num from ".$this->_tableName." where ".$this->_pk."=".intval($id));
            $rs = $st->queryOne();
            return $rs['num']>0 ? true : false;
        }
        throw new \Exception("id or tableName or primary key error");
    }

    /**
     * where 条件匹配
     * @param $condition
     * @return $this
     */
    public function where($condition)
    {
        foreach ($condition as $k=>$v)
        {
            $this->_statement->setRawSql(str_replace(":".$k,$v,$this->_statement->rawSql));
        }
        return $this;
    }
}