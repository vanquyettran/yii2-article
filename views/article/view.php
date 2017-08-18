<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\article\models\Article */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'slug',
            'heading',
            'page_title',
            'meta_title',
            'meta_keywords',
            'meta_description',
            'description',
            'content:ntext',
            'sub_content:ntext',
            'menu_label',
            'active',
            'visible',
            'featured',
            'shown_on_menu',
            'doindex',
            'dofollow',
            'type',
            'status',
            'sort_order',
            'create_time:datetime',
            'update_time:datetime',
            'publish_time:datetime',
            'view_count',
            'comment_count',
            'like_count',
            'share_count',
            'creator_id',
            'updater_id',
            'image_id',
            'category_id',
        ],
    ]) ?>

</div>
