<?php

namespace common\modules\article\baseModels;

use Yii;

/**
 * This is the model class for table "article_relation".
 *
 * @property integer $article_id
 * @property integer $related_article_id
 *
 * @property Article $article
 * @property Article $relatedArticle
 */
class ArticleRelation extends \common\db\MyActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['article_id', 'related_article_id'], 'required'],
            [['article_id', 'related_article_id'], 'integer'],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['article_id' => 'id'], 'except' => 'test'],
            [['related_article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::className(), 'targetAttribute' => ['related_article_id' => 'id'], 'except' => 'test'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'article_id' => 'Article ID',
            'related_article_id' => 'Related Article ID',
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
    public function getRelatedArticle()
    {
        return $this->hasOne(Article::className(), ['id' => 'related_article_id']);
    }
}
