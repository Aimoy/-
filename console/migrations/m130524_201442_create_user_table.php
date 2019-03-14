<?php

use yii\db\Migration;

class m130524_201442_create_user_table extends Migration
{
    public function safeUp()
    {

        $this->createTable('user', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'openid'=>$this->string(50)->defaultValue("")->unique()->comment("openid"),
            'unionid'=>$this->string(50)->defaultValue("")->comment("unionid"),
            'session_key'=>$this->string(32)->defaultValue("")->comment("session_key"),
            'status'=>$this->tinyInteger(2)->unsigned()->defaultValue(0)->comment("用户身份"),
            'recent_active' => $this->dateTime()->comment("最近访问时间"),
            'created_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('创建时间'),
            'updated_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('更新时间'),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('user');
    }
}
