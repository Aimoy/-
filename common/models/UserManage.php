<?php
namespace common\models;

use manage\library\Cache;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 */
class UserManage extends ActiveRecord implements IdentityInterface
{
    public $id;
    public $account;
    public $role;
    public $unionId;
    public $realName;
    public $avatar;
    public $teamId;
    public $groupId;
    public $squareId;
    public $divisionId;
    public $regional;
    public $status;
    public $createdAt;
    public $token;

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        $userInfo = json_decode((new Cache())->get('login.login.admin_info',$id),true);
        return new self($userInfo);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token,$type = null)
    {
        $cache = new Cache();
        $userId = $cache->get('login.login.user_login',$token);
        if($userId && $cache->exists('login.login.admin_info',$userId)){
            $user = self::findIdentity($userId);
            $user->token = $token;
            return $user;
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

}
