<?php

use common\models\BookGallery;
use common\models\MainCategory;
use common\models\Subcategory;
use dosamigos\tinymce\TinyMce;
use kartik\date\DatePicker;
use kartik\file\FileInput;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\bootstrap4\Html;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model common\models\GalleryBookForm */
/* @var $modelGalleryBookForm common\models\GalleryBookForm */
/* @var $form yii\widgets\ActiveForm */
/* @var $photoFileList array */
/* @var $pdfFileList array */
?>

<div class="detail-gallery-article-form">

    <?php $form = ActiveForm::begin([
                                        'type' => ActiveForm::TYPE_HORIZONTAL,
                                    ]) ?>

    <?= $form->field($modelGalleryBookForm, 'article_name_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelGalleryBookForm, 'article_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelGalleryBookForm, 'author_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($modelGalleryBookForm, 'main_category_id')->dropDownList(MainCategory::getMainCategoryList(), ['prompt' => Yii::t('app', 'please Choose'),]) ?>

    <?= $form->field($modelGalleryBookForm, 'subcategory_id', [])->widget(Select2::class, [
        'model'         => $modelGalleryBookForm,
        'attribute'     => 'name',
        'options'       => [
            'placeholder' => 'please Choose ...',
            'multiple'    => true,
        ],
        'pluginOptions' => [
            'allowClear'         => true,
            'tags'               => true,
            'maximumInputLength' => false,
        ],
        'size'          => Select2::LARGE,
        'data'          => Subcategory::getSubcategoryList(),
    ]) ?>
    <?= $form->field($modelGalleryBookForm, 'file_book_photo')->widget(FileInput::class, [
        'options'       => ['accept' => 'image/*'],
        'pluginOptions' => [
            'initialPreview'       => ($fileUrlsPhoto) ? $fileUrlsPhoto : [],
            'maxFileCount'         => 1,
            'maxFileSize'          => BookGallery::MAX_FILE_SIZE_PHOTO,
            'showUpload'           => false,
            'initialPreviewAsData' => true,
            'overwriteInitial'     => true,
            'initialPreviewConfig' => $photoFileList,
            'deleteUrl'            => Yii::$app->urlManager->createUrl([
                                                                           '/detail-gallery-article/delete-file',
                                                                           'id'       => isset($model->bookGalleries->detail_gallery_article_id) ? $model->bookGalleries->detail_gallery_article_id : '',
                                                                           'fileName' => isset($model->bookGalleries->book_photo) ? $model->bookGalleries->book_photo : '',
                                                                           'column'   => isset($model->bookGalleries->book_photo) ? 'book_photo' : '',
                                                                       ]),
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
    ]); ?>

    <?= $form->field($modelGalleryBookForm, 'file_book_pdf')->widget(FileInput::class, [
        'options'       => [
            'accept' => 'pdf/*',
        ],
        'pluginOptions' => [
            'initialPreview'       => ($fileUrlsPdf) ? $fileUrlsPdf : [],
            'maxFileCount'         => 1,
            'maxFileSize'          => BookGallery::MAX_FILE_SIZE_PDF,
            'showUpload'           => false,
            'initialPreviewAsData' => true,
            'overwriteInitial'     => false,
            'initialPreviewConfig' => $pdfFileList,
            'deleteUrl'            => Yii::$app->urlManager->createUrl([
                                                                           '/detail-gallery-article/delete-file',
                                                                           'id'       => isset($model->bookGalleries->detail_gallery_article_id) ? $model->bookGalleries->detail_gallery_article_id : '',
                                                                           'fileName' => isset($model->bookGalleries->book_pdf) ? $model->bookGalleries->book_pdf : '',
                                                                           'column'   => isset($model->bookGalleries->book_pdf) ? 'book_pdf' : '',
                                                                       ]),
            'initialCaption'       => Yii::t('app', 'Datei auswählen'),
            'browseLabel'          => Yii::t('app', 'Auswählen'),
            'removeLabel'          => Yii::t('app', 'Löschen'),
        ],
        'pluginEvents'  => [
            'filepredelete' => "function(event, key) { return (!confirm('" . Yii::t('app', 'Sind Sie sicher, dass Sie den Anhang löschen möchten?') . "')); }",
        ],
    ]); ?>
    <?= $form->field($modelGalleryBookForm, 'book_serial_number')->textInput() ?>

    <?= $form->field($modelGalleryBookForm, 'link_to_preview')->textInput() ?>

    <?= $form->field($modelGalleryBookForm, 'description')->widget(TinyMce::class, [
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
    <?= $form->field($modelGalleryBookForm, 'selected_date')->widget(DatePicker::class, [
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
