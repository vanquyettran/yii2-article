<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Image;
use yii\web\JsExpression;
use yii\helpers\Url;
use yii\web\View;
use yii\helpers\ArrayHelper;
use common\modules\article\models\ArticleCategory;
use common\modules\article\models\ArticleTag;

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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet"/>
<script src="<?= Yii::getAlias('@web/libs/ckeditor/ckeditor.js') ?>"></script>
<script src="<?= Url::to(['/cdn/ckeditor/index']) ?>"></script>
<style>
    [name="submit-and-goto"] {
        display: none;
    }
    #auto-tag-btn > * {
        display: inline-block;
        vertical-align: middle;
    }
    #auto-tag-btn > .loading {
        display: none;
    }
    #auto-tag-btn.loading > .loading {
        display: inline-block;
    }

</style>
<?php
$label = '<span class="text">' . Yii::t('app', 'Auto tag') . '</span>';
$loading = '<svg class="loading" version="1.1" id="loader-1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
           width="1.2em" height="1.2em" viewBox="0 0 40 40" enable-background="new 0 0 40 40" xml:space="preserve">
              <path opacity="0.2" fill="#000" d="M20.201,5.169c-8.254,0-14.946,6.692-14.946,14.946c0,8.255,6.692,14.946,14.946,14.946
                s14.946-6.691,14.946-14.946C35.146,11.861,28.455,5.169,20.201,5.169z M20.201,31.749c-6.425,0-11.634-5.208-11.634-11.634
                c0-6.425,5.209-11.634,11.634-11.634c6.425,0,11.633,5.209,11.633,11.634C31.834,26.541,26.626,31.749,20.201,31.749z"/>
              <path fill="#000" d="M26.013,10.047l1.654-2.866c-2.198-1.272-4.743-2.012-7.466-2.012h0v3.312h0
                C22.32,8.481,24.301,9.057,26.013,10.047z">
                <animateTransform attributeType="xml"
                  attributeName="transform"
                  type="rotate"
                  from="0 20 20"
                  to="360 20 20"
                  dur="0.5s"
                  repeatCount="indefinite"/>
            </path>
          </svg>';
$auto_tag_btn = Html::button(
    "$label $loading",
    [
        'id' => 'auto-tag-btn',
        'class' => 'btn btn-xs btn-default'
    ]
);
?>
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

            <?php

            echo $form
                ->field(
                    $model,
                    'article_tag_ids',
                    ['template' => "{label} $auto_tag_btn {input} {error} {hint}"]
                )
                ->dropDownList(
                    ArrayHelper::map(
                        ArticleTag::find()
                            ->where(['in', 'id', $model->article_tag_ids ? $model->article_tag_ids : []])
                            ->allActive(),
                        'id',
                        'name'
                    ),
                    ['multiple' => true]
                );
            ?>
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
    var contentEditor = ckeditor("<?= Html::getInputId($model, 'content') ?>");
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
                    "onClick": function (current) {
                    }
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
                event.target !== widget && !checkIsContains(widget, event.target) &&
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

<!-- Tag select -->
<script>
    <?php $this->beginBlock('tag_select') ?>
    var tag_select = $("#<?= Html::getInputId($model, 'article_tag_ids') ?>");
    var tag_formatRepo = function (repo) {
        if (repo.loading) {
            return repo.text;
        }
        var markup =
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<img src="' + repo.image_src + '" class="img-rounded" style="width:50px" />' +
            '<b style="margin-left:5px">' + repo.name + '</b>' +
            '</div>' +
            '</div>';
        return '<div style="overflow:hidden;">' + markup + '</div>';
    };
    var tag_formatRepoSelection = function (repo) {
        console.log(tag_select.val());
        var text = repo.name || repo.text;
        return '<span style="color:#333">' + text + '</span>';
    };
    tag_select.select2({
        multiple: true,
        ajax: {
            url: "<?= Url::to(['api/find-tags-by-name']) ?>",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
        minimumInputLength: 0,
        templateResult: tag_formatRepo, // omitted for brevity, see the source of this page
        templateSelection: tag_formatRepoSelection // omitted for brevity, see the source of this page
    });

    /**
     * Auto fill
     */
    auto_tag_btn = document.getElementById("auto-tag-btn");
    auto_tag_btn.addEventListener("click", function () {
        if (auto_tag_btn.classList.contains("loading")) {
            return false;
        }
//        tag_select.append('<option value="1">Test 1</option>');
//        tag_select.append('<option value="2">Test 2</option>');
//        tag_select.val(["1", "2"]).trigger("change");
        /**
         * @var contentEditor CKEditor Instance
         */
//        console.log(contentEditor.getData());
        auto_tag_btn.classList.add("loading");

        var fd = new FormData();
        console.log("content editor", contentEditor.getData());
        fd.append('content', contentEditor.getData());
        fd.append('<?= Yii::$app->request->csrfParam ?>', '<?= Yii::$app->request->csrfToken ?>');
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '<?= Url::to(['api/find-tags-by-keywords'], true) ?>', true);
        xhr.onload = function() {
            auto_tag_btn.classList.remove("loading");
            if (this.status == 200) {
                var resp = JSON.parse(this.response);
                console.log('Server got:', resp);
                if (!resp.error_message) {
                    tag_select.empty();
                    var option;
                    resp.data.items.forEach(function (item) {
                        option = document.createElement("option");
                        option.value = item.id;
                        option.innerHTML = item.name;
                        tag_select.append(option);
                    });
                    option = undefined;
                    tag_select
                        .val(resp.data.items.map(function (item) { return item.id; }))
                        .trigger("change");
                } else {
                    alert(resp.error_message);
                }
            } else {
                alert("Request failed!");
            }
        };
        xhr.send(fd);
    });
    <?php $this->endBlock() ?>
</script>
<?php
$this->registerJs($this->blocks['tag_select'], \yii\web\View::POS_READY);

