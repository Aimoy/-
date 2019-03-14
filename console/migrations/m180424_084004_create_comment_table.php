<?php

use yii\db\Migration;

/**
 * Handles the creation of table `comment`.
 */
class m180424_084004_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('comment', [
            'id' => $this->bigPrimaryKey()->unsigned(),
            'content'=>$this->string(1000)->defaultValue('')->comment('评论信息'),
            'user_id'=>$this->bigInteger()->unsigned()->notNull()->comment('评论者id'),
            'nickname'=>$this->string(100)->defaultValue('')->comment('冗余昵称'),
            'thumb_img'=>$this->string(300)->defaultValue('')->comment('冗余头像'),
            'article_id'=>$this->bigInteger()->unsigned()->notNull()->comment('文章id'),
            'like_num'=>$this->integer()->unsigned()->defaultValue(0)->comment('点赞数'),
            'reply_num'=>$this->integer()->unsigned()->defaultValue(0)->comment('回复数'),
            'reply_ids'=>$this->string(500)->defaultValue("")->comment('记录该评论的所有回复id'),
            'is_hidden'=>$this->tinyInteger(2)->unsigned()->defaultValue(0)->comment('是否隐藏'),
            'created_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('创建时间'),
            'updated_at' => $this->dateTime()->defaultExpression("CURRENT_TIMESTAMP")->comment('更新时间'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('comment');
    }
}
