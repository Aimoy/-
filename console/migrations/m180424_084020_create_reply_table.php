<?php

use yii\db\Migration;

/**
 * Handles the creation of table `reply`.
 */
class m180424_084020_create_reply_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('reply', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'content'=>$this->string(1000)->defaultValue('')->comment('回复信息'),
            'user_id'=>$this->bigInteger()->unsigned()->notNull()->comment('回复人id'),
            'nickname'=>$this->string(100)->defaultValue('')->comment('冗余回复人昵称'),
            'thumb_img'=>$this->string(300)->defaultValue('')->comment('冗余回复人头像'),
            'comment_id'=>$this->integer()->unsigned()->notNull()->comment('记录该回复最上级评论的ID'),
            'reply_ids'=>$this->string(500)->defaultValue("")->comment('记录该回复下一级的所有回复id'),
            'like_num'=>$this->integer()->unsigned()->defaultValue(0)->comment('点赞数'),
            'is_hidden'=>$this->tinyInteger(2)->unsigned()->defaultValue(0)->comment('是否隐藏'),
            'to_id'=>$this->bigInteger()->unsigned()->defaultValue(0)->comment('回复对象的id'),
            'to_user_id'=>$this->bigInteger()->unsigned()->defaultValue(0)->comment('回复对象的用户id'),
            'to_nickname'=>$this->string(100)->unsigned()->defaultValue("")->comment('回复对象的昵称'),
            'to_content'=>$this->string(1000)->unsigned()->defaultValue("")->comment('回复对象的内容'),
            'created_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('创建时间'),
            'updated_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('reply');
    }
}
