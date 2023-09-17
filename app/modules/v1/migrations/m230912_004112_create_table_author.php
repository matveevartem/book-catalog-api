<?php

use yii\db\Migration;

/**
 * Class m230912_004112_create_table_author
 */
class m230912_004112_create_table_author extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%author}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(45)->notNull()->unique(),
        ]);

        $this->batchInsert('{{%author}}', ['name'], [
            ['Лев Толстой'],
            ['Сергей Есенин'],
            ['Andrzej Sapkowski'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%author}}');
    }
}
