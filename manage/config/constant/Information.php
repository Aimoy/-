<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2018/4/20
 * Time: 13:46
 */

namespace manage\config\constant;

/**
 * Class Information
 * author chenqiao (chenqiao@sunlands.com )
 * date 2018-04-20
 */
class Information
{
    /**
     * @var array 信息分类列表
     */
    public static $typeInfo = array(
        0 => array(
            'typeName' => '默认',
            'typeSrc' => 'default.png'
        ),
        1 => array(
            'typeName' => '自考',
            'typeSrc' => 'zikao.png'
        ),
        2 => array(
            'typeName' => '资格证',
            'typeSrc' => 'MBA.png'
        ),
        3 => array(
            'typeName' => '职场',
            'typeSrc' => 'MBA.png'
        ),
        4 => array(
            'typeName' => '美文',
            'typeSrc' => 'MBA.png'
        ),
        5 => array(
            'typeName' => '文化',
            'typeSrc' => 'MBA.png'
        ),
        6 => array(
            'typeName' => '育儿',
            'typeSrc' => 'MBA.png'
        ),
        7 => array(
            'typeName' => '情感',
            'typeSrc' => 'MBA.png'
        ),
        8 => array(
            'typeName' => '读书',
            'typeSrc' => 'MBA.png'
        ),
        9 => array(
            'typeName' => '生活',
            'typeSrc' => 'MBA.png'
        ),
    );

    /**
     * @var int 信息来源
     */
    CONST INFO_EXTERNAL_CRAWL = 1;
    CONST INFO_INTERNAL_EDIT = 2;

    /**
     * @var array 待发布信息状态
     */
    CONST INFO_STATUS_WAIT = 0;
    CONST INFO_STATUS_PUBLISH = 1;


    const INFO_WAIT_STATUS_LIST = [
        0 => '待发布',
        1 => '已发布'
    ];
    const INFO_WAIT_COME_FROM_LIST = [
        1 => '外部抓取',
        2 => '内部编辑'
    ];

    /**
     * 发布文章状态
     */
    const INFO_PUBLISHED_STATUS = [
        0 => '正常',
        1 => '删除',
        2 => '下架'
    ];


    /**
     * @var array 已发布信息状态
     */
    CONST INFO_PUBLISH_STATUS_NORMAL = 0;
    CONST INFO_PUBLISH_STATUS_DELETE = 1;
    CONST INFO_PUBLISH_STATUS_CANCEL = 2;

    /**
     * desc: 根据ID获取某个信息分类的名称
     * @param $id     分类ID
     * @return mixed  分类名称
     */
    public static function getTypeNameById($id)
    {
        try {
            return self::$typeInfo[$id]['typeName'];

        } catch (\Exception $e) {
            return self::$typeInfo[0]['typeName'];
        }

    }

    /**
     * desc: 获取所有的信息分类名称
     * @return array 返回所有的信息分类名称列表
     */
    public static function getTypeNames()
    {
        $ids = array_keys(self::$typeInfo);
        $typeNames = array_column(self::$typeInfo,'typeName');
        return array_combine($ids,$typeNames);
    }

}