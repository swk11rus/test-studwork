<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'access_token' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
        ], $tableOptions);

        $this->insert(
            'user',
            [
                'username' => 'user1',
                'auth_key' => 'auth',
                'password_hash' => 'passwdhsh',
                'access_token' => 'qwertyuiopasdfghjklzxcvbnm',
                'email' => 'user@user.ru',
            ]
        );
        $this->insert(
            'user',
            [
                'username' => 'user2',
                'auth_key' => 'auth1',
                'password_hash' => 'passwdhsh123',
                'access_token' => 'qwertyuiopasdfghjklzxcvbnmqwe',
                'email' => 'user2@user.ru',
            ]
        );
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
