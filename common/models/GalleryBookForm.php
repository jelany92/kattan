<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

/**
 * This is the model class for table "detail_gallery_article".
 *
 * @property int $id
 * @property int $author_name
 * @property string|null $book_photo
 * @property string|null $book_pdf
 * @property string|null $book_serial_number
 * @property int|null $company_id
 * @property int|null $category_id
 * @property string|null $article_name_ar
 * @property string|null $article_name_en
 * @property string|null $link_to_preview
 * @property string|null $description
 * @property string|null $type
 * @property string|null $selected_date
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property BookGallery[] $bookGalleries
 * @property Category $category
 * @property User $company
 */
class GalleryBookForm extends Model
{
    public $id;
    public $detail_gallery_article_id;
    public $author_name;
    public $company_id;
    public $category_id;
    public $description;
    public $link_to_preview;
    public $book_photo;
    public $file_book_photo;
    public $book_pdf;
    public $file_book_pdf;
    public $book_serial_number;
    public $selected_date;
    public $article_name_ar;
    public $article_name_en;
    public $type;

    public $writtenFiles = [];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['author_name'], 'required'],
            [['id', 'company_id', 'category_id', 'detail_gallery_article_id'], 'integer'],
            [['description', 'link_to_preview'], 'string'],
            [['book_photo', 'book_pdf', 'book_serial_number'], 'string', 'max' => 255],
            [['selected_date', 'file_book_photo', 'file_book_pdf'], 'safe'],
            [['article_name_ar', 'article_name_en'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 255],
            [['author_name'], 'string', 'max' => 100],
            //[['file_book_photo'], 'file', 'extensions' => ['jpg', 'jpeg', 'gif', 'png']],
            //[['file_book_pdf'], 'file', 'extensions' => ['pdf']],
            //[['file_book_photo'], 'file', 'maxSize' => BookGallery::MAX_FILE_SIZE_PHOTO],
            //[['file_book_pdf'], 'file', 'maxSize' => BookGallery::MAX_FILE_SIZE_PDF],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserModel::class, 'targetAttribute' => ['company_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'company_id'         => Yii::t('app', 'Company ID'),
            'category_id'        => Yii::t('app', 'Category ID'),
            'author_name'        => Yii::t('app', 'Author Name'),
            'article_name_ar'    => Yii::t('app', 'Article Name Ar'),
            'article_name_en'    => Yii::t('app', 'Article Name En'),
            'link_to_preview'    => Yii::t('app', 'Link To Preview'),
            'description'        => Yii::t('app', 'Description'),
            'book_photo'         => Yii::t('app', 'Book Photo'),
            'file_book_photo'    => Yii::t('app', 'Book Photo'),
            'book_pdf'           => Yii::t('app', 'Book Pdf'),
            'book_serial_number' => Yii::t('app', 'Book Serial Number'),
            'type'               => Yii::t('app', 'Type'),
            'selected_date'      => Yii::t('app', 'Selected Date'),
            'created_at'         => Yii::t('app', 'Created At'),
            'updated_at'         => Yii::t('app', 'Updated At'),
        ];
    }

    public function setAttributeForDetailGalleryArticle($model)
    {
        $this->company_id      = Yii::$app->user->id;
        $this->category_id     = $model->company_id;
        $this->article_name_ar = $model->article_name_ar;
        $this->article_name_en = $model->article_name_en;
        $this->link_to_preview = $model->link_to_preview;
        $this->description     = $model->description;
        $this->type            = $model->type;
        $this->selected_date   = $model->selected_date;
    }

    public function setAttributeForBookGallery($model, int $detailGalleryArticleId)
    {
        $this->detail_gallery_article_id = $detailGalleryArticleId;
        $this->author_name        = $model->author_name;
        $this->book_photo         = $model->book_photo;
        $this->book_pdf           = $model->book_pdf;
        $this->book_serial_number = $model->book_serial_number;
    }

    /**
     * $id
     * @return bool
     * @throws \yii\base\Exception
     */
    protected function upload()
    {
        if ($this->validate())
        {
            foreach ($this->file_book_pdf as $file)
            {
                $randomNameString  = Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $this->writtenFiles[] = [
                    'fileName'         => strtotime(date('Y-m-d')) . '_' . $randomNameString,
                    'fileExtension'    => $file->extension,
                    'originalFileName' => $file->baseName. '.' . $file->extension,
                ];
                $fileName          = $randomNameString;
                var_dump($fileName);die();
                $filePath          = Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryBookGalleryPdf']  . DIRECTORY_SEPARATOR . $id . '_' . $fileName;
                $file->saveAs($filePath);
            }
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function getFileName()
    {
        $this->file_book_pdf = UploadedFile::getInstances($this, 'file_book_pdf');
        if ($this->file_book_pdf != null)
        {
            if ($this->upload())
            {
                $fileName = '';
                foreach ($this->writtenFiles as $arrFileData)
                {
                    $fileName           = $arrFileData['fileName'];
                }
                return $fileName;
            }
        }
    }

}
