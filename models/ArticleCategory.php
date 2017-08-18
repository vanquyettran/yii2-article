<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 6/24/2017
 * Time: 12:05 PM
 */

namespace common\modules\article\models;

use Yii;
use common\models\Image;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

class ArticleCategory extends \common\modules\article\baseModels\ArticleCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['long_description'], 'string'],
            [['active', 'visible', 'featured', 'shown_on_menu', 'doindex', 'dofollow',
                'type', 'status', 'sort_order', 'image_id', 'parent_id'], 'integer'],
            [['name', 'slug', 'heading', 'page_title', 'meta_title', 'menu_label'], 'string', 'max' => 255],
            [['meta_keywords', 'meta_description', 'description'], 'string', 'max' => 511],
            [['slug'], 'unique'],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArticleCategory::className(), 'targetAttribute' => ['parent_id' => 'id'], 'except' => 'test'],
        ];
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

    /**
     * @return array
     */
    public static function dropDownListData()
    {
        /**
         * @param self[] $categories
         * @param bool $isRoot
         * @return array
         */
        $arrange = function ($categories, $isRoot = true) use (&$arrange) {
            $result = [];
            foreach ($categories as $category) {
                $children = $category->getArticleCategories()->all();
                if (!empty($children)) {
                    $result[$category->name] = [
                        "$category->id" => $category->name,
                        '__________' => $arrange($children, false),
                        '' => '',
                    ];
                } else {
                    if ($isRoot) {
                        $result['(No Children)']["$category->id"] = $category->name;
                    } else {
                        $result["$category->id"] = $category->name;
                    }
                }
            }
            return $result;
        };

        $result = array_merge(
            [0 => Yii::t('yii', '(not set)')],
            $arrange(self::find()->where(['parent_id' => null])->all())
        );
        return $result;
    }
}