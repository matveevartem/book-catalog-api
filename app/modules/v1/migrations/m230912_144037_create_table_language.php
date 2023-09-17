<?php

use yii\db\Migration;

/**
 * Class m230912_144037_create_table_languages
 */
class m230912_144037_create_table_language extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'code'=> $this->string()->notNull(),
            'description'=> $this->string()->notNull(),
        ]);

        $this->batchInsert('{{%language}}', ['code', 'description'], [
            ['RU', 'Русский'],
            ['EN', 'English'],
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
