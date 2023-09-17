<?php

use yii\db\Migration;

/**
 * Class m230912_144129_create_table_book
 */
class m230912_144129_create_table_book extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title'=> $this->string()->notNull(),
            'description'=> $this->string()->notNull(),
            'author_id' => $this->integer(11)->notNull(),
            'language_id' => $this->integer()->notNull(),
            'genre_id' => $this->integer()->notNull(),
            'pages' => $this->integer(11)->notNull(),
        ]);

        $this->addForeignKey('author_fk', '{{%book}}', '{{author_id}}', '{{%author}}', 'id');
        $this->addForeignKey('language_fk', '{{%book}}', '{{language_id}}', '{{%language}}', 'id');
        $this->addForeignKey('genre_fk', '{{%book}}', '{{genre_id}}', '{{%genre}}', 'id');

        $this->createIndex('author_idx', '{{%book}}', 'author_id');
        $this->createIndex('language_idx', '{{%book}}', 'language_id');
        $this->createIndex('genre_idx', '{{%book}}', 'genre_id');

        $this->batchInsert('{{%book}}', ['title', 'description', 'author_id', 'language_id', 'genre_id', 'pages'], [
            ['Война и мир', 'Страшный сон школьников', 1, 1, 1, 1000],
            ['Анна Снегина', 'Хорошая поэма', 2, 1, 1, 150],
            ['The Witcher', 'Отличный фэнтези роман', 3, 2, 3, 5000],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230912_144129_create_table_book cannot be reverted.\n";

        return false;
    }
    */
}
