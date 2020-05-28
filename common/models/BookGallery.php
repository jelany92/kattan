<?php

namespace common\models;

use common\components\FileUpload;
use common\models\query\traits\TimestampBehaviorTrait;
use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "book_gallery".
 *
 * @property int                  $id
 * @property int|null             $detail_gallery_article_id
 * @property int                  $author_name
 * @property string|null          $book_photo
 * @property string|null          $book_pdf
 * @property string|null          $book_serial_number
 * @property string|null          $created_at
 * @property string|null          $updated_at
 *
 * @property DetailGalleryArticle $detailGalleryArticle
 */
class BookGallery extends \yii\db\ActiveRecord
{
    use TimestampBehaviorTrait;

    const MAX_FILE_SIZE_PHOTO = 5000000; // ~5 MB
    const MAX_FILE_SIZE_PDF   = 10000000; // ~10 MB

    public $file_book_photo;
    public $file_book_pdf;
    public $writtenFiles = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'book_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['detail_gallery_article_id'], 'integer',],
            [['author_name'], 'required',],
            [['created_at', 'updated_at', 'file_book_photo',], 'safe',],
            [['book_photo', 'book_pdf', 'book_serial_number',], 'string', 'max' => 255,],
            [['author_name'], 'string', 'max' => 100,],
            [['file_book_photo'], 'file', 'extensions' => ['jpg', 'jpeg', 'gif', 'png',],],
            [['file_book_pdf'], 'file', 'extensions' => ['pdf'],],
            [['file_book_photo'], 'file', 'maxSize' => self::MAX_FILE_SIZE_PHOTO,],
            [['file_book_pdf'], 'file', 'maxSize' => self::MAX_FILE_SIZE_PDF,],
            [['detail_gallery_article_id'], 'exist', 'skipOnError' => true, 'targetClass' => DetailGalleryArticle::class, 'targetAttribute' => ['detail_gallery_article_id' => 'id'],],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'                        => Yii::t('app', 'ID'),
            'detail_gallery_article_id' => Yii::t('app', 'Detail Gallery Article ID'),
            'author_name'               => Yii::t('app', 'Author Name'),
            'book_photo'                => Yii::t('app', 'Book Photo'),
            'book_pdf'                  => Yii::t('app', 'Book Pdf'),
            'book_serial_number'        => Yii::t('app', 'Book Serial Number'),
            'created_at'                => Yii::t('app', 'Created At'),
            'updated_at'                => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * Gets query for [[DetailGalleryArticle]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetailGalleryArticle()
    {
        return $this->hasOne(DetailGalleryArticle::class, ['id' => 'detail_gallery_article_id']);
    }

    /**
     * @param     $modelForm
     * @param int $detailGalleryArticleId
     */
    public function saveDetailBookGallery($modelForm, int $detailGalleryArticleId): void
    {
        $this->detail_gallery_article_id = $detailGalleryArticleId;
        $this->author_name               = $modelForm->author_name;
        $this->book_serial_number        = $modelForm->book_serial_number;
        $fileUpload                      = new FileUpload();
        if (isset($this->book_photo) && UploadedFile::getInstances($modelForm, 'file_book_photo'))
        {
            $filePath          = Yii::$app->params['uploadDirectoryBookGalleryPhoto'];
            $fileBookPhotoPath = $this->getAbsolutePath($filePath, $this->book_photo);
            if (file_exists($fileBookPhotoPath))
            {
                unlink($fileBookPhotoPath);
            }
        }
        if (isset($this->book_pdf) && UploadedFile::getInstances($modelForm, 'file_book_pdf'))
        {
            $filePath          = Yii::$app->params['uploadDirectoryBookGalleryPdf'];
            $fileBookPhotoPath = $this->getAbsolutePath($filePath, $this->book_pdf);
            if (file_exists($fileBookPhotoPath))
            {
                unlink($fileBookPhotoPath);
            }
        }
        if (UploadedFile::getInstances($modelForm, 'file_book_photo'))
        {
            $bookPdfName                     = $fileUpload->getFileUpload($modelForm, 'file_book_photo', 'book_pdf', Yii::$app->params['uploadDirectoryBookGalleryPhoto']);
            $this->book_photo                  = $bookPdfName;
        }
        if (UploadedFile::getInstances($modelForm, 'file_book_pdf'))
        {
            $bookPdfName                     = $fileUpload->getFileUpload($modelForm, 'file_book_pdf', 'book_pdf', Yii::$app->params['uploadDirectoryBookGalleryPdf']);
            $this->book_pdf                  = $bookPdfName;
        }
        $this->save();
    }

    /**
     * returns absolute local file path
     *
     * @param  string $params
     * @param  string $fileName
     * @return string
     */
    public function getAbsolutePath(string $params, string $fileName)
    {
        return Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $params . DIRECTORY_SEPARATOR . $fileName;
    }

}
