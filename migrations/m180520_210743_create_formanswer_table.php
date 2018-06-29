<?php

use yii\db\Migration;

/**
 * Handles the creation of table `formanswer`.
 */
class m180520_210743_create_formanswer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('formanswer', [
            'id' => $this->primaryKey(),
            'line_id'=>$this->integer(),
            'value'=>$this->string(),
            'userform_id'=>$this->integer()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('formanswer');
    }
}
