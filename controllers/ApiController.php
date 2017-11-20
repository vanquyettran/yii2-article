<?php
/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 9/20/2017
 * Time: 11:42 AM
 */

namespace common\modules\article\controllers;


use Yii;
use yii\web\Controller;
use common\helpers\MyInflector;
use common\modules\article\models\ArticleTag;

class ApiController extends Controller
{
    public function actionFindTagsByName($q = '', $page = 1)
    {
        /**
         * @var ArticleTag[] $tags
         */

        $tags = ArticleTag::find()
            ->where(['like', 'name', $q])
            ->offset($page - 1)
            ->limit(30)
            ->orderBy('id desc')
            ->allActive();

        $result = [
            'items' => [],
            'total_count' => ArticleTag::find()
                ->where(['like', 'name', $q])
                ->countActive()
        ];

        foreach ($tags as $item) {
            $result['items'][] = [
                'id' => $item->id,
                'name' => $item->name,
                'image_src' => $item->image ? $item->image->getImgSrc('50x50') : '',
                'create_time' => date('d/m/Y H:i'),
            ];
        }

        return json_encode($result);
    }

    public function actionFindTagsByKeywords()
    {
        $content = Yii::$app->request->getBodyParam('content');
        $textContent = MyInflector::slug(html_entity_decode(strip_tags($content)));
        $data_items = [];
        foreach (ArticleTag::find()->each() as $tag) {
            /**
             * @var $tag ArticleTag
             */
            $keywords = explode(',', $tag->meta_keywords);
            foreach ($keywords as $keyword) {
                $keyword = MyInflector::slug($keyword);
                if ($keyword) {
                    if (strpos($textContent, "-$keyword-") !== false) {
                        $data_items[] = [
                            'id' => $tag->id,
                            'name' => $tag->name,
                        ];
                        break;
                    }
                }
            }
        }
        $response = [
            'error_message' => '',
            'data' => [
                'items' => $data_items
            ]
        ];
        return json_encode($response);
    }
}