<?php

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;
use common\models\Category;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use dosamigos\tinymce\TinyMce;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\GalleryBookForm */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="detail-gallery-article-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>

    <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(Category::getCategoryList()) ?>

    <?= $form->field($model, 'article_name_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'article_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'file_book_photo')->widget(FileInput::class, [
        'options'       => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'       => ($fileUrlsPhoto) ? $fileUrlsPhoto : [],
            'maxFileCount'         => 1,
            'showUpload'           => false,
            'initialPreviewAsData' => true,
            'overwriteInitial'     => false,
            //'deleteUrl'            => Yii::$app->urlManager->createUrl('/purchase-invoices/delete-file'),
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
    ]); ?>

    <?= $form->field($model, 'file_book_pdf')->widget(FileInput::class, [
        'options'       => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'       => ($fileUrlsPdf) ? $fileUrlsPdf : [],
            'maxFileCount'         => 1,
            'showUpload'           => false,
            'initialPreviewAsData' => true,
            'overwriteInitial'     => false,
            //'deleteUrl'            => Yii::$app->urlManager->createUrl('/purchase-invoices/delete-file'),
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
    ]); ?>

    <?= $form->field($model, 'book_serial_number')->textInput() ?>

    <?= $form->field($model, 'link_to_preview')->textInput() ?>

    <?= $form->field($model, 'description')->widget(TinyMce::class, [
        'options'       => [
            'style' => 'display:none',
            'id'    => 'std_editor',
            'rows'  => 8,
        ],
        'language'      => Yii::$app->language,
        'clientOptions' => [
            'setup'        => new JsExpression("function(editor){
            $('#std_editor').show();
            }"),
            'branding'     => false,
            'plugins'      => [
                "advlist autolink lists link charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste",
            ],
            'toolbar'      => "fontselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor",
            'font_formats' => 'Arial=arial,helvetica,sans-serif;BerkeleyStd-Book=BerkeleyStd-Book;Rotsan=rotsan,rotsan,monospace;Rotsanl=rotsanl;Rotsanxb=rotsanxb;rotsanb=rotsanb;rotsani=rotsani;rotsanil=rotsanil',
        ],
    ]); ?>
    <?= $form->field($model, 'selected_date')->widget(DatePicker::class, [
        'options'       => ['placeholder' => 'Enter event time ...'],
        'pluginOptions' => [
            'autoclose'    => true,
            'showMeridian' => false,
            'endDate'      => '+0d',
            'format'       => 'yyyy-mm-dd'
            //'format'       => 'dd.mm.yyyy'
        ],
    ]) ?>
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
