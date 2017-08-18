<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\modules\article\models\ArticleCategory;

/* @var $this yii\web\View */
/* @var $model common\modules\article\models\ArticleCategory */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile(
    'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js',
    ['depends' => \yii\web\JqueryAsset::className()]
);
$this->registerJsFile(
    \yii\helpers\Url::to(['/cdn/image-upload/index']),
    ['depends' => \yii\web\JqueryAsset::className()]
);
$this->registerJs(
    'imageUpload("' . Html::getInputId($model, 'image_id') . '", "image-preview-wrapper", "image-file-input")',
    \yii\web\View::POS_READY
);
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="<?= Yii::getAlias('@web/libs/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= Url::to(['/cdn/ckeditor/index']) ?>"></script>
<?php
// @TODO: Default value for some boolean attributes
if ($model->isNewRecord) {
    foreach (['doindex', 'dofollow', 'active', 'visible'] as $attribute) {
        $model->$attribute = true;
    }
}
?>
<div class="article-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->field($model, 'parent_id')->dropDownList(
                ArticleCategory::dropDownListData(),
                ['prompt' => Yii::t('app', 'Select one...')])
            ?>

            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

            <?php
            $image_uploader = '<div class="clearfix">' .
                '<div id="image-preview-wrapper">'
                . $model->img() .
                (($image = $model->image) ? "<div>{$image->width}x{$image->height}; {$image->aspect_ratio}</div>" : '') .
                '</div>' .
                '<input type="file" id="image-file-input" name="image_file" accept="image/*">' .
                '</div>';

            echo $form->field($model, 'image_id', [
                'template' => "{label}$image_uploader{input}{error}{hint}"])->dropDownList(
                $model->image ? [$model->image->id => $model->image->name] : []);
            ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'heading')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>


            <?= $form->field($model, 'menu_label')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'sort_order')->textInput() ?>

        </div>
    </div>

    <div class="row">

        <div class="col-md-6">
            <?php echo $form->field($model, 'active')->checkbox() ?>

            <?php echo $form->field($model, 'visible')->checkbox() ?>

            <?php echo $form->field($model, 'featured')->checkbox() ?>

        </div>
        <div class="col-md-6">
            <?php echo $form->field($model, 'doindex')->checkbox() ?>

            <?php echo $form->field($model, 'dofollow')->checkbox() ?>

            <?php echo $form->field($model, 'shown_on_menu')->checkbox() ?>

        </div>
        <div class="col-md-12">
            <?php echo $form->field($model, 'long_description')->textarea(['rows' => 20]) ?>

        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    !function (editor) {
        editor && ckeditor(editor);
    }(document.getElementById("<?= Html::getInputId($model, 'long_description') ?>"));
</script>
