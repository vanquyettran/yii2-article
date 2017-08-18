<?php

namespace common\modules\article\baseModels;

use Yii;
use common\models\User;
use common\models\Image;

/**
 * This is the model class for table "article".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $heading
 * @property string $page_title
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $description
 * @property string $content
 * @property string $sub_content
 * @property string $menu_label
 * @property integer $active
 * @property integer $visible
 * @property integer $featured
 * @property integer $shown_on_menu
 * @property integer $doindex
 * @property integer $dofollow
 * @property integer $type
 * @property integer $status
 * @property integer $sort_order
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $publish_time
 * @property integer $view_count
 * @property integer $comment_count
 * @property integer $like_count
 * @property integer $share_count
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $image_id
 * @property integer $category_id
 *
 * @property ArticleCategory $category
 * @property User $creator
 * @property Image $image
 * @property User $updater
 * @property ArticleRelation[] $articleRelations
 * @property ArticleRelation[] $articleRelations2
 * @property Article[] $relatedArticles
 * @property Article[] $articles
 */
class Article extends \common\db\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'content', 'create_time', 'creator_id'], 'required'],
            [['content', 'sub_content'], 'string'],
            [['active', 'visible', 'featured', 'shown_on_menu', 'doindex', 'dofollow', 'type', 'status', 'sort_order', 'create_time', 'update_time', 'publish_time', 'view_count', 'comment_count', 'like_count', 'share_count', 'creator_id', 'updater_id', 'image_id', 'category_id'], 'integer'],
            [['name', 'slug', 'heading', 'page_title', 'meta_title', 'menu_label'], 'string', 'max' => 255],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['category_id' => 'id'], 'except' => 'test'],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id'], 'except' => 'test'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
            [['updater_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updater_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'slug' => 'Slug',
            'heading' => 'Heading',
            'page_title' => 'Page Title',
            'meta_title' => 'Meta Title',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'description' => 'Description',
            'content' => 'Content',
            'sub_content' => 'Sub Content',
            'menu_label' => 'Menu Label',
            'active' => 'Active',
            'visible' => 'Visible',
            'featured' => 'Featured',
            'shown_on_menu' => 'Shown On Menu',
            'doindex' => 'Doindex',
            'dofollow' => 'Dofollow',
            'type' => 'Type',
            'status' => 'Status',
            'sort_order' => 'Sort Order',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'publish_time' => 'Publish Time',
            'view_count' => 'View Count',
            'comment_count' => 'Comment Count',
            'like_count' => 'Like Count',
            'share_count' => 'Share Count',
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'image_id' => 'Image ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(Image::className(), ['id' => 'image_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleRelations()
    {
        return $this->hasMany(ArticleRelation::className(), ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleRelations2()
    {
        return $this->hasMany(ArticleRelation::className(), ['related_article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelatedArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'related_article_id'])->viaTable('article_relation', ['article_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['id' => 'article_id'])->viaTable('article_relation', ['related_article_id' => 'id']);
    }
}
