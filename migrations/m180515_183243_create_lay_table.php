<?php

use yii\db\Migration;

/**
 * Handles the creation of table `lay`.
 */
class m180515_183243_create_lay_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('lay', [
            'id' => $this->primaryKey(),
            'user_id'=>$this->integer(),
            'page_id'=>$this->integer()
        ]);
        $this->addForeignKey('lay_to_us','lay','user_id','user','id');
        $this->addForeignKey('lay_to_page','lay','page_id','page','id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('lay');
    }
}
