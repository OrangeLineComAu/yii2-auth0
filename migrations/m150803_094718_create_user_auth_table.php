<?php

use yii\db\Schema;
use yii\db\Migration;

class m150803_094718_create_user_auth_table extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ]);

        $this->createTable('{{%auth}}', [
            'id'    			   	=> Schema::TYPE_PK,
            'user_id'       	   	=> Schema::TYPE_INTEGER . ' NOT NULL',
            'source'	   			=> Schema::TYPE_STRING . '(255) NOT NULL',
            'source_id'	   			=> Schema::TYPE_STRING . '(255) NOT NULL',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%auth}}');
    }
}
