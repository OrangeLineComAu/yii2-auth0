<?php

use yii\db\Schema;
use yii\db\Migration;

class m150805_092256_create_tenant_tables extends Migration
{

    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        /* BEGIN tenant */
		$this->createTable('{{%tenant}}', [
			'id'    			   => Schema::TYPE_PK,
			'name'  			   => Schema::TYPE_STRING . '(255) NOT NULL',
			'created_at'           => Schema::TYPE_DATETIME . ' DEFAULT NULL',
			'create_user_id'  	   => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'updated_at'           => Schema::TYPE_DATETIME . ' DEFAULT NULL',
			'update_user_id'  	   => Schema::TYPE_INTEGER . ' DEFAULT NULL',
		]);
		/* END tenant */

		/* BEGIN tenant_user */
		$this->createTable('{{%tenant_user}}', [
			'id'    			   => Schema::TYPE_PK,
			'tenant_id'  		   => Schema::TYPE_INTEGER . ' NOT NULL',
			'user_id'  			   => Schema::TYPE_INTEGER . ' NOT NULL',
			'created_at'           => Schema::TYPE_DATETIME . ' DEFAULT NULL',
			'create_user_id'  	   => Schema::TYPE_INTEGER . ' DEFAULT NULL',
            'updated_at'           => Schema::TYPE_DATETIME . ' DEFAULT NULL',
			'update_user_id'  	   => Schema::TYPE_INTEGER . ' DEFAULT NULL',
		]);
		/* END tenant_user */

        /* BEGIN relationship */
		$this->addForeignKey('fk_tenant_tenant_user', '{{%tenant_user}}', 'tenant_id', '{{%tenant}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('fk_user_tenant_user', '{{%tenant_user}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
		/* END relationship */
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_tenant_tenant_user', '{{%tenant_user}}');
        $this->dropForeignKey('fk_user_tenant_user', '{{%tenant_user}}');
		$this->dropTable('{{%tenant}}');
		$this->dropTable('{{%tenant_user}}');
    }
}
