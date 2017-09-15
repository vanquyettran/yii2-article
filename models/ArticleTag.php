<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 9/15/2017
 * Time: 2:19 PM
 */

namespace common\modules\article\models;

use common\models\User;
use common\models\Image;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class ArticleTag extends \common\modules\article\baseModels\ArticleTag
{
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['long_description'], 'string'],
            [['active', 'visible', 'featured', 'shown_on_menu', 'doindex', 'dofollow', 'type', 'status', 'sort_order', 'image_id'], 'integer'],
            [['name', 'slug', 'heading', 'page_title', 'meta_title', 'menu_label'], 'string', 'max' => 255],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
        ];
    }
}