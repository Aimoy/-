<?php
/**
 * Created by PhpStorm.
 * User: duanwei
 * Date: 2018/6/20
 * Time: 下午1:39
 */

namespace manage\models\setting\bo;


use manage\models\BaseBo;
use manage\models\setting\dao\Version as VersionDao;

class Version extends BaseBo
{
    protected $versionDao;

    public function __construct()
    {
        $this->versionDao = new VersionDao();
    }

    public function getTotal()
    {
        return $this->versionDao->getTotal();
    }

    public function getById($id)
    {
        return $this->versionDao->getById($id);
    }

    public function existByVersion($version)
    {
        return $this->versionDao->existByVersion($version);
    }

    public function exists($id)
    {
        return $this->versionDao->exists($id);
    }

    public function add($version, $status, $remark)
    {
        return $this->versionDao->create($version, $status, $remark);
    }

    public function update($id,$version,$status,$remark)
    {
        return $this->versionDao->updateInfo($id,$version,$status,$remark);
    }

    public function delete($ids)
    {
        return $this->versionDao->del($ids);
    }

    public function getAllList($page,$pageSize)
    {
        return $this->versionDao->getAllList($page,$pageSize);
    }

}