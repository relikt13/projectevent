<?php

use yii\db\Migration;

/**
 * Handles the creation of table `opinion`.
 */
class m180426_092803_create_opinion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('opinion', [
            'id' => $this->primaryKey(),
            'content'=>$this->text(),
            'user_id'=>$this->integer(),
            'page_id'=>$this->integer(),
            'date'=>$this->date(),
        ]);
        $this->addForeignKey('op_to_user','opinion','user_id','user','id');
        $this->addForeignKey('op_to_page','opinion','page_id','page','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('opinion');
    }
}
