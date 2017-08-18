<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 7/30/2017
 * Time: 6:04 AM
 */
class m170730_060400_create_article_relation_table extends \yii\db\Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('article_relation', [
            'article_id' => $this->integer(),
            'related_article_id' => $this->integer(),
            'PRIMARY KEY(article_id, related_article_id)',
        ], $tableOptions);

        // creates index for column `article_id`
        $this->createIndex(
            'idx-article_relation-article_id',
            'article_relation',
            'article_id'
        );

        // add foreign key for table `article`
        $this->addForeignKey(
            'fk-article_relation-article_id',
            'article_relation',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

        // creates index for column `related_article_id`
        $this->createIndex(
            'idx-article_relation-related_article_id',
            'article_relation',
            'related_article_id'
        );

        // add foreign key for table `article`
        $this->addForeignKey(
            'fk-article_relation-related_article_id',
            'article_relation',
            'related_article_id',
            'article',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `article`
        $this->dropForeignKey(
            'fk-article_relation-related_article_id',
            'article_relation'
        );

        // drops index for column `related_article_id`
        $this->dropIndex(
            'idx-article_relation-related_article_id',
            'article_relation'
        );

        // drops foreign key for table `article`
        $this->dropForeignKey(
            'fk-article_relation-article_id',
            'article_relation'
        );

        // drops index for column `article_id`
        $this->dropIndex(
            'idx-article_relation-article_id',
            'article_relation'
        );

        $this->dropTable('article_relation');
    }
}