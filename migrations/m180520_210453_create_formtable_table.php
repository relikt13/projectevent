<?php

use yii\db\Migration;

/**
 * Handles the creation of table `formtable`.
 */
class m180520_210453_create_formtable_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('formtable', [
            'id' => $this->primaryKey(),
            'page_id'=>$this->integer(),
            'to_guest'=>$this->integer(),
            'title'=>$this->string()
        ]);
        $this->addForeignKey('form_to_page','formtable','page_id','page','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('formtable');
    }
}
