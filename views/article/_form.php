<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Image;
use yii\web\JsExpression;
use yii\helpers\Url;
use common\modules\article\models\ArticleCategory;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model backend\models\Article */
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
<!--
<?= $model->templateLogMessage ?>
-->
<?php
// @TODO: Default value for some boolean attributes
if ($model->isNewRecord) {
    foreach (['doindex', 'dofollow', 'active', 'visible'] as $attribute) {
        $model->$attribute = true;
    }
}
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="<?= Yii::getAlias('@web/libs/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= Url::to(['/cdn/ckeditor/index']) ?>"></script>
<style>
    [name="submit-and-goto"] {
        display: none;
    }
</style>
<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">
            <?php //echo $form->field($model, 'category_id')->textInput() ?>

            <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

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

            <?php echo $form->field($model, 'category_id')->dropDownList(
                ArticleCategory::dropDownListData(),
                ['prompt' => Yii::t('app', 'Select one...')])
            ?>

            <?php echo $form->field($model, 'publish_time_timestamp')->textInput(['type' => 'datetime']);
            ?>

        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'heading')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'page_title')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_title')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_keywords')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'meta_description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'description')->textarea(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'menu_label')->textInput(['maxlength' => true]) ?>

            <?php echo $form->field($model, 'sort_order')->textInput() ?>
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
            <?php echo $form->field($model, 'content')->textarea(['rows' => 20]) ?>

        </div>
    </div>
    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <label class="btn btn-default">
            <input type="radio" name="submit-and-goto" value="list">
            <span>Submit & show list</span>
        </label>
        <label class="btn btn-default">
            <input type="radio" name="submit-and-goto" value="prev-list">
            <span>Submit & show prev list</span>
        </label>
        <label class="btn btn-default">
            <input type="radio" name="submit-and-goto" value="form">
            <span>Submit & edit</span>
        </label>
        <label class="btn btn-default">
            <input type="radio" name="submit-and-goto" value="view">
            <span>Submit & view</span>
        </label>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
    // Submit and goto ...
    !function (inputs) {
        [].forEach.call(inputs, function (input) {
            input.addEventListener("click", function () {
                input.form.submit();
            });
        })
    }(document.querySelectorAll("input[name=submit-and-goto]"));

    // CKEditor
    <?php
    if (!Yii::$app->request->get('code_editor')) {
    ?>
    !function (editor) {
        editor && ckeditor(editor);
    }(document.getElementById("<?= Html::getInputId($model, 'content') ?>"));
    <?php
    }
    ?>
</script>

<!-- Datetime picker -->
<link href="<?= Yii::getAlias('@web/libs/datetimepicker/datetimepicker.css') ?>" rel="stylesheet">
<script src="<?= Yii::getAlias('@web/libs/datetimepicker/datetimepicker.js') ?>"></script>
<style>
    .datetimePicker__widget {
        display: none;
        position: absolute;
        z-index: 999;
        background: #fff;
    }
    .datetimePicker__widget.active {
        display: table;
    }
</style>
<script>
    !function (datetimeInput) {
        if (!datetimeInput) {
            throw Error();
        }
        datetimeInput.picker = new DatetimePicker(
            new Date(datetimeInput.value),
            {
                "weekdays": ["CN", "T2", "T3", "T4", "T5", "T6", "T7"],
                "months": ["Giêng", "Hai", "Ba", "Tư", "Năm", "Sáu", "Bảy", "Tám", "Chín", "Mười", "Mười Một", "Mười Hai"],
                "onChange": function (current) {
                    exportValue();
                },
                "classNamePrefix": "datetimePicker__"
            }
        );
        var widget = datetimeInput.picker.widget(
            {
                "yearMonthBlock": {
                    "items": ["yearCell", "monthCell"]
                },
                "dateBlock": {
                    "onClick": function (current) {}
                },
                "timeBlock": {
                    "items": ["hoursCell", "minutesCell", "secondsCell"]
                },
                "controlBlock": {
                    "items": ["set2nowCell", "resetCell", "submitCell"],
                    "onSubmit": function (current) {
                        widget.classList.remove("active");
                    }
                },
                "items": ["yearMonthBlock", "dateBlock", "timeBlock", "controlBlock"]
            }
        );
        datetimeInput.addEventListener("input", function () {
            var time = (new Date(datetimeInput.value)).getTime();
            if (!isNaN(time)) {
                datetimeInput.picker.current.time = time;
            } else {
                exportValue();
            }
        });
        datetimeInput.parentNode.insertBefore(widget, datetimeInput.nextElementSiblings);
        datetimeInput.addEventListener("focusin", function () {
            datetimeInput.picker.current.time = (new Date(datetimeInput.value)).getTime();
            widget.classList.add("active");
        });
        document.addEventListener("click", function (event) {
            if (event.target !== datetimeInput &&
                event.target !== widget &&
                !checkIsContains(widget, event.target) &&
                checkIsContains(document.body, event.target)
            ) {
                widget.classList.remove("active");
            }
        });
        function exportValue() {
            var current = datetimeInput.picker.current;
            datetimeInput.value = "Y-m-d H:i:s"
                .replace(/Y/g, current.year)
                .replace(/m/g, pad(current.month + 1))
                .replace(/d/g, pad(current.date))
                .replace(/H/g, pad(current.hours))
                .replace(/i/g, pad(current.minutes))
                .replace(/s/g, pad(current.seconds))
            ;
        }
        function pad(number) {
            return (number < 10 ? "0" : "") + number;
        }
        function checkIsContains(root, elem) {
            if (root.contains(elem)) {
                return true;
            } else {
                return [].some.call(root.children, function (child) {
                    return checkIsContains(child, elem);
                });
            }
        }
    }(document.getElementById("<?= Html::getInputId($model, 'publish_time_timestamp') ?>"));
</script>
