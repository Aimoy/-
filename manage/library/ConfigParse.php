<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午3:36
 */

namespace manage\library;

use yii\db\Exception;

class ConfigParse
{

    public static function parseSql($sid, $column = '',$autoReplace=true)
    {
        $pos = strrpos($sid, '.');
        if (false === $pos) {
            throw new Exception('no such sql id');
        }
        $filePath = SQL_MAP.str_replace('.', '/', substr($sid, 0, $pos));

        $sqlMap = require $filePath.'.php';

        $key = substr($sid, $pos+1);
        $sql = $sqlMap[$key];

        return $column && $autoReplace ? str_replace('#COLUMN#', $column, $sql) : $sql;
    }

    public static function parseCache($configKey, $key)
    {
        $pos = strrpos($configKey, '.');
        if (false === $pos) {
            throw new Exception('no such cache id');
        }

        $filePath = CACHE.str_replace('.', '/', substr($configKey, 0, $pos));

        $cacheConf = require $filePath.'.php';

        $processKey = $cacheConf[substr($configKey, $pos+1)];

        $processKey['key'] = sprintf($processKey['key'], $key);

        return $processKey;
    }

    /**
     * 字符串替换方式绑定参数，没有过滤参数
     * @param $sid
     * @param string $column
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public static function handleSql($sid, $column = '',$params)
    {
        $pos = strrpos($sid, '.');
        if (false === $pos) {
            throw new Exception('no such sql id');
        }
        $filePath = SQL_MAP.str_replace('.', '/', substr($sid, 0, $pos));

        $sqlMap = require $filePath.'.php';

        $key = substr($sid, $pos + 1);
        $sql = $sqlMap[$key];

        $sql = $column ? str_replace('#COLUMN#', $column, $sql) : $sql;

        foreach ($params as $k=>$v)
        {
            $sql = str_replace(':'.$k,$v,$sql);
        }

        return $column ? str_replace('#COLUMN#', $column, $sql) : $sql;
    }


    /**
     * 未完成，测试代码，新增数组传参绑定参数,代码待优化
     * @param Command $st
     * @param $params
     * @return Command
     */
    public static function bindValues(Command $st,$params)
    {
        $sql = $st->getRawSql();
        foreach ($params as $k=>$v)
        {
            $pdoType = self::getPdoType($v);

            if($pdoType == 999){
                $a = [];
                for($i=0;$i<count($v);$i++)
                {
                    array_push($a,":".$k.$i);
                }
                $sql = str_replace(":".$k,implode(",",$a),$sql);
                $st->setRawSql($sql);

                foreach ($v as $m=>$n)
                {
                    $type = self::getPdoType($n);
                    if($type>=0 && $type<999)
                    {
                        $st->bindValue(":".$k.$m,$n,$type);
                    }
                }
            }elseif($pdoType){
                $st->bindValue(":".$k,$pdoType);
            }
        }
        return $st;
    }

    public static function getPdoType($v)
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

    public static function parseQueue($configKey)
    {
        $pos = strrpos($configKey, '.');
        if (false === $pos) {
            throw new Exception('no such queue id');
        }

        $filePath = QUEUE . str_replace('.', '/', substr($configKey, 0, $pos));

        $queueConf = require $filePath . '.php';

        return $queueConf[substr($configKey, $pos + 1)];
    }
}