<?php

use yii\db\Migration;

/**
 * Handles the creation of table `userInfo`.
 */
class m180504_020443_create_user_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_info', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'user_id'=>$this->bigInteger()->unsigned()->notNull()->comment('user_id'),
            'nickname' => $this->string()->notNull()->comment("昵称"),
            'gender'=>$this->tinyInteger(2)->unsigned()->defaultValue(0)->comment("性别"),
            'city'=>$this->string(20)->defaultValue("")->comment("城市"),
            'province'=>$this->string(20)->defaultValue("")->comment("省"),
            'country'=>$this->string(20)->defaultValue("")->comment("国家"),
            'avatar_url'=>$this->string(300)->defaultValue("")->comment("头像"),
            'created_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('创建时间'),
            'updated_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_info');
    }
}
