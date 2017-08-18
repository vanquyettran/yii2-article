<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;
use common\modules\article\models\Article;
use common\modules\article\models\ArticleCategory;
use common\models\Image;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\article\searchModels\Article */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Articles';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'creator_id',
//            'updater_id',
            [
                'attribute' => 'image_id',
                'format' => 'raw',
                'value' => function (Article $model) {
                    return $model->img('50x50');
                }
            ],
            'name',
            'slug',
//            'category.name',
            [
                'attribute' => 'category_id',
                'format' => 'raw',
                'value' => function (Article $model) {
                    return ($category = $model->category) ? $category->name : $model->category_id;
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'category_id',
                    ArticleCategory::dropDownListData(),
                    ['class'=>'form-control', 'prompt' => '']
                )
            ],
            // 'meta_title',
             'meta_keywords',
            // 'meta_description',
            // 'description',
            // 'content:ntext',
//            [
//                'attribute' => 'content',
//                'format' => 'raw',
//                'value' => function ($model) {
//                    return $model->getContentWithTemplates();
//                }
//            ],
            // 'sub_content:ntext',
            // 'hot',
            // 'status',
            // 'type',
            // 'sort_order',
            // 'create_time:datetime',
            // 'update_time:datetime',
            'publish_time:datetime',
            // 'views',
            // 'likes',
            // 'comments',
            // 'shares',
            [
                'attribute' => 'active',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->active) {
                        return '<span class="label label-success">active</span>';
                    }
                    return '<span class="label label-default">inactive</span>';
                }
            ],

            'shown_on_menu:boolean',

            [
                'class' => ActionColumn::className(),
                'template' => '{view} {update} {delete}',
//                'buttons' => [
//                    'delete' => function ($url, $model, $key) {
//                    }
//                ]
            ],
        ],
    ]); ?>
</div>
