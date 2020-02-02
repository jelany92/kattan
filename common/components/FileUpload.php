<?php

namespace common\components;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;

class FileUpload extends \yii\helpers\StringHelper
{
    public $writtenFiles = [];

    public function getFileUpload($model, $file, $fileName)
    {
        $model->$file = UploadedFile::getInstances($model, $file);
        if ($model->$file != null)
        {
            if ($this->upload($model, $file))
            {
                foreach ($this->writtenFiles as $arrFileData)
                {
                    $model->$fileName = $arrFileData['fileName'];
                    if ($model->save() == false)
                    {
                        throw new \Exception('Rechnung File wurde nicht gespeichert');
                    }
                }
            }
        }
    }

    public function upload($model, $file)
    {
        if ($model->validate())
        {
            foreach ($model->$file as $file)
            {
                $randomNameString     = Yii::$app->security->generateRandomString() . '.' . $file->extension;
                $this->writtenFiles[] = [
                    'fileName'         => $model->id . '_' . $randomNameString,
                    'fileExtension'    => $file->extension,
                    'originalFileName' => $file->baseName . '.' . $file->extension,
                ];
                $fileName             = $randomNameString;
                $filePath             = Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . Yii::$app->params['uploadDirectoryArticle'] . DIRECTORY_SEPARATOR . $model->id . '_' . $fileName;
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
     * creates Url for the file
     *
     * @param        $path
     * @param string $fileName
     *
     * @return string the created URL
     */
    public static function getFileUrl($path, string $fileName)
    {
        return DIRECTORY_SEPARATOR . Url::to($path . DIRECTORY_SEPARATOR . $fileName);
    }
}