<?php

use yii\db\Migration;

/**
 * Handles the creation of table `page`.
 */
class m180426_091029_create_page_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'title'=>$this->string(),
            'description'=>$this->string(),
            'content'=>$this->text(),
            'image'=>$this->string(),
            'category_id'=>$this->integer(),
            'active'=>$this->boolean()->defaultValue(false),
            'user_id'=>$this->integer(),
            'date'=>$this->date(),
            'slug'=>$this->string(),
        ]);
        $this->addForeignKey('page_to_cat','page','category_id','category','id');
        $this->addForeignKey('page_to_user','page','user_id','user','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page');
    }
}
