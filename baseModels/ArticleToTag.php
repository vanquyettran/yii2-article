<?php

namespace common\modules\article\baseModels;

use Yii;

/**
 * This is the model class for table "article_to_tag".
 *
 * @property integer $article_id
 * @property integer $article_tag_id
 *
 * @property Article $article
 * @property ArticleTag $articleTag
 */
class ArticleToTag extends \common\db\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_to_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'article_tag_id'], 'required'],
            [['article_id', 'article_tag_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id'], 'except' => 'test'],
            [['article_tag_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleTag::className(), 'targetAttribute' => ['article_tag_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
            'article_tag_id' => 'Article Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'article_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArticleTag()
    {
        return $this->hasOne(ArticleTag::className(), ['id' => 'article_tag_id']);
    }
}
