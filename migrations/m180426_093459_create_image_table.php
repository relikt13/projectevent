<?php

use yii\db\Migration;

/**
 * Handles the creation of table `image`.
 */
class m180426_093459_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'image'=>$this->string(),
            'content'=>$this->string()->null(),
            'page_id'=>$this->integer()
        ]);
        $this->addForeignKey('im_to_page','image','page_id','page','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('image');
    }
}
