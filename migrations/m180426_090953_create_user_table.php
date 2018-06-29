<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180426_090953_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'login'=>$this->string(),
            'password'=>$this->string(),
            'name'=>$this->string(),
            'last_name'=>$this->string(),
            'email'=>$this->string(),
            'image'=>$this->string(),
            'status'=>$this->integer()->defaultValue(0),
            'auth_token'=>$this->string()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
    }
}
