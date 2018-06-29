<?php

use yii\db\Migration;

/**
 * Handles the creation of table `formline`.
 */
class m180520_210712_create_formline_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('formline', [
            'id' => $this->primaryKey(),
            'form_id'=>$this->integer(),
            'type'=>$this->string(),
            'annotation'=>$this->string(),

        ]);
        $this->addForeignKey('line_to_form','formline','form_id','formtable','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('formline');
    }
}
