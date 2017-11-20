<?php

use yii\helpers\Html;
use yii\grid\GridView;
use \common\modules\article\models\ArticleTag;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\article\searchModels\ArticleTag */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Article Tags';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-tag-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Article Tag', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'image_id',
                'format' => 'raw',
                'value' => function ($model) {
                    /**
                     * @var $model ArticleTag
                     */
                    return $model->img('50x50');
                }
            ],
            'name',
            'slug',
//            'heading',
//            'page_title',
            // 'meta_title',
            // 'meta_keywords',
            // 'meta_description',
            // 'description',
            // 'long_description:ntext',
            // 'menu_label',
             'active:boolean',
             'visible:boolean',
            // 'featured',
            // 'shown_on_menu',
            // 'doindex',
            // 'dofollow',
            // 'type',
            // 'status',
            // 'sort_order',
            // 'create_time:datetime',
            // 'update_time:datetime',
            // 'creator_id',
            // 'updater_id',
            // 'image_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
