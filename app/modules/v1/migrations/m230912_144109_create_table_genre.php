<?php

use yii\db\Migration;

/**
 * Class m230912_144109_create_table_genre
 */
class m230912_144109_create_table_genre extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%genre}}', [
            'id' => $this->primaryKey(),
            'name'=> $this->string()->notNull(),
            'description'=> $this->string()->notNull(),
        ]);

        $this->batchInsert('{{%genre}}', ['name', 'description'], [
            ['Роман', 'Длинное произведение'],
            ['Поэма', 'Роман в стихах'],
            ['Фэнтези', 'Фантастика про альтернативные миры'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%genre}}');
    }
}
