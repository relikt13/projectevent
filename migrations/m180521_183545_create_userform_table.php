<?php

use yii\db\Migration;

/**
 * Handles the creation of table `userform`.
 */
class m180521_183545_create_userform_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('userform', [
            'id' => $this->primaryKey(),
            'form_id'=>$this->integer(),
            'user_name'=>$this->string()
        ]);
        $this->addForeignKey('userform','userform','form_id','formtable','id');
        $this->addForeignKey('answer_to_line','formanswer','line_id','formline','id');
        $this->addForeignKey('answer_user','formanswer','userform_id','userform','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('userform');
    }
}
