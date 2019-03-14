<?php

use yii\db\Migration;

/**
 * Handles the creation of table `agree`.
 */
class m180425_144754_create_agree_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('agree', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'type_id'=>$this->bigInteger()->unsigned()->notNull()->comment("信息id"),
            'user_id'=>$this->bigInteger()->unsigned()->notNull()->comment("用户id"),
            'type'=>$this->tinyInteger(2)->unsigned()->notNull()->comment("类型id 1信息 2评论 3回复"),
            'nickname'=>$this->string(32)->notNull()->defaultValue("")->comment("昵称"),
            'avatarUrl'=>$this->string(300)->notNull()->defaultValue("")->comment("头像"),
            'created_at'=>$this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('创建时间'),
            'updated_at'=>$this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('更新时间'),
        ]);
        $this->createIndex("type_id_type_user","agree",["type_id","type","user_id"]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('agree');
    }
}
