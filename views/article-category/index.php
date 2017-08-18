<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\modules\article\models\ArticleCategory;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\article\searchModels\ArticleCategory */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Article Categories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-category-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article Category', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'creator_id',
//            'updater_id',
//            'image_id',
            [
                'attribute' => 'image_id',
                'format' => 'raw',
                'value' => function (ArticleCategory $model) {
                    return $model->img('50x50');
                }
            ],
            'name',
            'slug',
            [
                'attribute' => 'parent_id',
                'format' => 'raw',
                'value' => function (ArticleCategory $model) {
                    return ($parent = $model->parent) ? $parent->name : $model->parent_id;
                },
                'filter' => Html::activeDropDownList(
                    $searchModel,
                    'parent_id',
                    ArticleCategory::dropDownListData(),
                    ['class'=>'form-control', 'prompt' => Yii::t('app', 'Select one...')]
                )
            ],
            // 'meta_title',
            // 'meta_description',
            // 'meta_keywords',
            // 'description',
            // 'long_description:ntext',
            'active',
            'visible',
            'featured',
            'shown_on_menu',
            // 'type',
            // 'status',
            'sort_order',
            // 'create_time:datetime',
            // 'update_time:datetime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
