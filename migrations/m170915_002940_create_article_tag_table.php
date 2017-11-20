<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_tag`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `user`
 * - `image`
 * - `article_tag`
 */
class m170915_002940_create_article_tag_table extends Migration
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
        $this->createTable('article_tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull()->unique(),
            'heading' => $this->string(),
            'page_title' => $this->string(),
            'meta_title' => $this->string(),
            'meta_keywords' => $this->string(511),
            'meta_description' => $this->string(511),
            'description' => $this->string(511),
            'long_description' => $this->text(),
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
            'creator_id' => $this->integer()->notNull(),
            'updater_id' => $this->integer(),
            'image_id' => $this->integer(),
        ], $tableOptions);

        // creates index for column `creator_id`
        $this->createIndex(
            'idx-article_tag-creator_id',
            'article_tag',
            'creator_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-article_tag-creator_id',
            'article_tag',
            'creator_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `updater_id`
        $this->createIndex(
            'idx-article_tag-updater_id',
            'article_tag',
            'updater_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-article_tag-updater_id',
            'article_tag',
            'updater_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `image_id`
        $this->createIndex(
            'idx-article_tag-image_id',
            'article_tag',
            'image_id'
        );

        // add foreign key for table `image`
        $this->addForeignKey(
            'fk-article_tag-image_id',
            'article_tag',
            'image_id',
            'image',
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
            'fk-article_tag-creator_id',
            'article_tag'
        );

        // drops index for column `creator_id`
        $this->dropIndex(
            'idx-article_tag-creator_id',
            'article_tag'
        );

        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-article_tag-updater_id',
            'article_tag'
        );

        // drops index for column `updater_id`
        $this->dropIndex(
            'idx-article_tag-updater_id',
            'article_tag'
        );

        // drops foreign key for table `image`
        $this->dropForeignKey(
            'fk-article_tag-image_id',
            'article_tag'
        );

        // drops index for column `image_id`
        $this->dropIndex(
            'idx-article_tag-image_id',
            'article_tag'
        );

        $this->dropTable('article_tag');
    }
}
