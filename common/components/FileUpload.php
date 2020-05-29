<?php

namespace common\components;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\imagine\Image;

class FileUpload extends \yii\helpers\StringHelper
{
    const PREFIX_THUMBNAIL = 'prefixThumbnail';
    const PREFIX_ORIGINAL  = 'prefixOriginal';

    public $writtenFiles = [];

    public function getFileUpload($model, $file, $fileName, $folder)
    {
        $model->$file = UploadedFile::getInstances($model, $file);
        if ($model->$file != null)
        {
            if ($this->upload($model, $file, $folder))
            {
                foreach ($this->writtenFiles as $arrFileData)
                {
                    $model->$fileName = $arrFileData['fileName'];
                }
                return $model->$fileName;
            }
        }
    }

    public function upload($model, $file, $folder)
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
                $filePath             = Yii::getAlias('@backend') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $model->id . '_' . $fileName;
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

    /**
     * uploads logo image file to upload directory as specified in backend/config/params.php
     * generates random file name and saves original with this name in upload folder
     * creates thumbnail file for original image
     *
     * @param $isGroupMasterOrHasNoGroup boolean Ist der UserStamm für den des Logo hochgeladen wird ein Firmengruppen-Admin oder in keiner Firmengruppe? Wenn ja dann Logo farbig speichern ansonsten Schwarzweiß
     * @param $path
     *
     * @return string
     * @throws \yii\base\Exception
     */
    public static function logoUpload(UploadedFile $uploadedFile, $file, $path)
    {
        // Remove old files
        //self::removeFiles($file);
        // rename and save original file
        $mangeledFileName     = Yii::$app->security->generateRandomString() . '.' . $uploadedFile->extension;
        $originalFileMangeled = self::generateFilename($path, $mangeledFileName);
        return $originalFileMangeled;
        $imageToSave = Image::getImagine()->open($uploadedFile->tempName);
        $imageToSave->save($originalFileMangeled);

        // generate a thumbnail file
        //$thumbnailFileM = self::generateFilename(self::PREFIX_THUMBNAIL, $mangeledFileName);
        //Image::getImagine()->open($originalFileMangeled)->thumbnail(new Box(Yii::$app->params['thumbnailWidth'], Yii::$app->params['thumbnailHeight']))->save(Yii::getAlias($thumbnailFileM), ['quality' => 80]);
        return $mangeledFileName;
    }

    /**
     * Removes all created and original Files
     */
    public static function removeFiles($file)
    {
        $fileName   = $file;
        $fileList[] = self::generateFilename(self::PREFIX_ORIGINAL, $fileName);
        $fileList[] = self::generateFilename(self::PREFIX_THUMBNAIL, $fileName);
        foreach ($fileList as $file)
        {
            if (file_exists($file))
            {
                unlink($file);
            }
        }
    }

    /**
     * Generates the filename
     *
     * @param $path
     * @param $fileName
     *
     * @return string
     */
    private static function generateFilename($path, $fileName)
    {
        $file             = $path . DIRECTORY_SEPARATOR . $fileName;
        return $file;
    }
}