<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\article\searchModels\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // $form->field($model, 'id') ?>

    <?php // $form->field($model, 'name') ?>

    <?php // $form->field($model, 'slug') ?>

    <?php // $form->field($model, 'heading') ?>

    <?php // $form->field($model, 'page_title') ?>

    <?php // echo $form->field($model, 'meta_title') ?>

    <?php // echo $form->field($model, 'meta_keywords') ?>

    <?php // echo $form->field($model, 'meta_description') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'sub_content') ?>

    <?php // echo $form->field($model, 'menu_label') ?>

    <?php // echo $form->field($model, 'active') ?>

    <?php // echo $form->field($model, 'visible') ?>

    <?php // echo $form->field($model, 'featured') ?>

    <?php // echo $form->field($model, 'shown_on_menu') ?>

    <?php // echo $form->field($model, 'doindex') ?>

    <?php // echo $form->field($model, 'dofollow') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'sort_order') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'publish_time') ?>

    <?php // echo $form->field($model, 'view_count') ?>

    <?php // echo $form->field($model, 'comment_count') ?>

    <?php // echo $form->field($model, 'like_count') ?>

    <?php // echo $form->field($model, 'share_count') ?>

    <?php // echo $form->field($model, 'creator_id') ?>

    <?php // echo $form->field($model, 'updater_id') ?>

    <?php // echo $form->field($model, 'image_id') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'create_date_range')->textInput([
                'class' => 'form-control daterange disable-counter'
            ]) ?>
        </div>
        <div class="col-md-6">
            <label>&nbsp;</label>
            <div class="form-group">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?= $this->render('dateRangePicker', ['selector' => 'input.daterange']) ?>