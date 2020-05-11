<?php

namespace backend\components;

use common\components\FileUpload;
use Yii;
use yii\db\Expression;
use yii\db\Query;

class DummyData
{

    /**
     * dummy data for category table
     *
     * @param int $userId
     *
     * @return array
     * @throws \Exception
     */
    public static function getDummyDateCategory(int $userId)
    {
        return [
            [
                "company_id"     => $userId,
                "category_name"  => Yii::t('app', 'Laptop'),
                "category_photo" => '12_E01odVcW3gNj2UzoexBL8fIegSMYdfig.jpg',
                "created_at"     => new Expression('NOW()'),
                "updated_at"     => new Expression('NOW()'),
            ],
            [
                "company_id"     => $userId,
                "category_name"  => Yii::t('app', 'Desktop'),
                "category_photo" => '12_H5A_1vhVRMfUdd_NvjqkF9ZjNHAsxT5m',
                "created_at"     => new Expression('NOW()'),
                "updated_at"     => new Expression('NOW()'),
            ],
            [
                "company_id"     => $userId,
                "category_name"  => Yii::t('app', 'Mobile'),
                "category_photo" => '12_oF_INRZa_gvYvVXWpHjCFoHy6BzzfbB2.png',
                "created_at"     => new Expression('NOW()'),
                "updated_at"     => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * dummy data for category table
     *
     * @param int $userId
     *
     * @return array
     * @throws \Exception
     */
    public static function getDummyDateArticleInfo(int $userId)
    {
        return [
            [
                "company_id"        => $userId,
                "category_id"       => 3,
                "article_name_ar"   => "باميه",
                "article_name_en"   => "",
                "article_quantity"  => null,
                "article_unit"      => "G",
                "article_photo"     => "",
                "article_buy_price" => null,
                "created_at"        => "2020-01-25 12:24:31",
                "updated_at"        => "2020-05-10 01:08:28",
            ],
        ];
    }
}