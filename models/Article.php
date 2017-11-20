<?php

/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/24/2017
 * Time: 12:03 PM
 */

namespace common\modules\article\models;

use common\models\Image;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Article extends \common\modules\article\baseModels\Article
{
    public $article_tag_ids;
    public $related_article_ids;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug', 'content'], 'required'],
            [['content', 'sub_content'], 'string'],
            [['active', 'visible', 'featured', 'shown_on_menu',
                'doindex', 'dofollow', 'type', 'status', 'sort_order',
                'view_count', 'comment_count', 'like_count', 'share_count',
                'image_id', 'category_id'], 'integer'],
            ['publish_time_timestamp', 'date', 'format' => 'php:' . self::TIMESTAMP_FORMAT],
            ['publish_time', 'integer'],
            [['name', 'slug', 'heading', 'page_title', 'meta_title', 'menu_label'], 'string', 'max' => 255],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['category_id' => 'id'], 'except' => 'test'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
            [['related_article_ids', 'article_tag_ids'], 'each', 'rule' => ['integer']],
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => time(),
            ],
        ];
    }

    public $publish_time_timestamp;

    const TIMESTAMP_FORMAT = 'Y-m-d H:i:s';

    public function __construct(array $config = [])
    {
        // Init publish time for new record
        if ($this->isNewRecord) {
            $this->publish_time_timestamp = date(self::TIMESTAMP_FORMAT, $this->getDefaultPublishTime());
        }
        parent::__construct($config);
    }

    public function afterFind()
    {
        // Init publish time for record found
        $this->publish_time_timestamp = date(self::TIMESTAMP_FORMAT, $this->publish_time);
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (!$this->publish_time_timestamp) {
            $this->publish_time = $this->getDefaultPublishTime();
            $this->publish_time_timestamp = date(self::TIMESTAMP_FORMAT, $this->publish_time);
        } else {
            $this->publish_time = strtotime($this->publish_time_timestamp);
        }
        return parent::beforeSave($insert);
    }

    public function getDefaultPublishTime()
    {
        // Round up ten minute (600s)
        return 600 * ceil(time() / 600);
    }

}