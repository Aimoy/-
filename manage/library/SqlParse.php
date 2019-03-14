<?php
/**
 * Created by PhpStorm.
 * User: charlie
 * Date: 2018/4/8
 * Time: 下午3:36
 */

namespace manage\library;


use yii\db\Exception;

class SqlParse
{
    public static function parseSql($sid, $column = '')
    {
        $pos = strrpos($sid, '.');
        if (false === $pos) {
            throw new Exception('no such sql id');
        }
        $filePath = SQL_MAP.str_replace('.', '/', substr($sid, 0, $pos));

        $sqlMap = require $filePath.'.php';

        $key = substr($sid, $pos + 1);
        $sql = $sqlMap[$key];

        return $column ? str_replace('#COLUMN#', $column, $sql) : $sql;
    }
}