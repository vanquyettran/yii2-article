<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 * - `image`
 * - `article_category`
 */
class m170730_003135_create_article_table extends Migration
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
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()->unique(),
            'heading' => $this->string(),
            'page_title' => $this->string(),
            'meta_title' => $this->string(),
            'meta_keywords' => $this->string(511),
            'meta_description' => $this->string(511),
            'description' => $this->string(511),
            'content' => $this->text()->notNull(),
            'sub_content' => $this->text(),
            'menu_label' => $this->string(),
            'active' => $this->smallInteger(1),
            'visible' => $this->smallInteger(1),
            'featured' => $this->smallInteger(1),
            'shown_on_menu' => $this->smallInteger(1),
            'doindex' => $this->smallInteger(1),
            'dofollow' => $this->smallInteger(1),
            'type' => $this->integer(),
            'status' => $this->integer(),
            'sort_order' => $this->integer(),
            'create_time' => $this->integer()->notNull(),
            'update_time' => $this->integer(),
            'publish_time' => $this->integer(),
            'view_count' => $this->integer(),
            'comment_count' => $this->integer(),
            'like_count' => $this->integer(),
            'share_count' => $this->integer(),
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'image_id' => $this->integer(),
            'category_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `creator_id`
        $this->createIndex(
            'idx-article-creator_id',
            'article',
            'creator_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-article-creator_id',
            'article',
            'creator_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-article-updater_id',
            'article',
            'updater_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-article-updater_id',
            'article',
            'updater_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `image_id`
        $this->createIndex(
            'idx-article-image_id',
            'article',
            'image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-article-image_id',
            'article',
            'image_id',
            'image',
            'id',
            'CASCADE'
        );

        // creates index for column `category_id`
        $this->createIndex(
            'idx-article-category_id',
            'article',
            'category_id'
        );

        // add foreign key for table `article_category`
        $this->addForeignKey(
            'fk-article-category_id',
            'article',
            'category_id',
            'article_category',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-article-creator_id',
            'article'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            'idx-article-creator_id',
            'article'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-article-updater_id',
            'article'
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-article-updater_id',
            'article'
        );

        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-article-image_id',
            'article'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-article-image_id',
            'article'
        );

        // drops foreign key for table `article_category`
        $this->dropForeignKey(
            'fk-article-category_id',
            'article'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            'idx-article-category_id',
            'article'
        );

        $this->dropTable('article');
    }
}
