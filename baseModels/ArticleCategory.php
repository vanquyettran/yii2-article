<?php

namespace common\modules\article\baseModels;

use Yii;
use common\models\User;
use common\models\Image;

/**
 * This is the model class for table "article_category".
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
 * @property string $long_description
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
 * @property integer $creator_id
 * @property integer $updater_id
 * @property integer $image_id
 * @property integer $parent_id
 *
 * @property Article[] $articles
 * @property User $creator
 * @property Image $image
 * @property ArticleCategory $parent
 * @property ArticleCategory[] $articleCategories
 * @property User $updater
 */
class ArticleCategory extends \common\db\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'create_time', 'creator_id'], 'required'],
            [['long_description'], 'string'],
            [['active', 'visible', 'featured', 'shown_on_menu', 'doindex', 'dofollow', 'type', 'status', 'sort_order', 'create_time', 'update_time', 'creator_id', 'updater_id', 'image_id', 'parent_id'], 'integer'],
            [['name', 'slug', 'heading', 'page_title', 'meta_title', 'menu_label'], 'string', 'max' => 255],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['creator_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator_id' => 'id'], 'except' => 'test'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['parent_id' => 'id'], 'except' => 'test'],
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
            'long_description' => 'Long Description',
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
            'creator_id' => 'Creator ID',
            'updater_id' => 'Updater ID',
            'image_id' => 'Image ID',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticles()
    {
        return $this->hasMany(Article::className(), ['category_id' => 'id']);
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
    public function getParent()
    {
        return $this->hasOne(ArticleCategory::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleCategories()
    {
        return $this->hasMany(ArticleCategory::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdater()
    {
        return $this->hasOne(User::className(), ['id' => 'updater_id']);
    }
}
