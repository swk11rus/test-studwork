<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%note}}`.
 */
class m211125_033808_create_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%note}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text(),
            'user_id' => $this->integer()->notNull(),
            'date_created' => $this->dateTime()->notNull()->defaultValue(new \yii\db\Expression('NOW()')),
            'date_updated' => $this->dateTime()->notNull()->defaultValue(new \yii\db\Expression('NOW()')),
            'date_publication' => $this->dateTime()->notNull()->defaultValue(new \yii\db\Expression('NOW()')),
            'date_deleted' => $this->dateTime(),
        ]);

        $this->addForeignKey(
            'fk-note-user_id-user-id',
            'note',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->insert(
            'note',
            [
                'title' => 'Tittle1',
                'text' => 'You know, when this surgery is through, I will write a love poem to this machine',
                'user_id' => 1,
            ]
        );
        $this->insert(
            'note',
            [
                'title' => 'Tittle2',
                'text' => ' You have only to write a letter, and send it with them if they have to go without you. ',
                'user_id' => 1,
                'date_publication' => '2022-11-25 09:35:41',
            ]
        );
        $this->insert(
            'note',
            [
                'title' => 'Tittle3',
                'text' => ' That C.I.D. man has gone rushing back to the hospital to write a brand-new report on you about that tomato.' ,
                'user_id' => 2,
                'date_publication' => '2020-11-25 09:35:41',
            ]
        );
        $this->insert(
            'note',
            [
                'title' => 'Tittle4',
                'text' => ' Then the clerk began to write; then he handed a long parch-ment to the president. ',
                'user_id' => 2,
            ]
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-note-user_id-user-id',
            'note',
        );
        $this->dropTable('{{%note}}');
    }
}
