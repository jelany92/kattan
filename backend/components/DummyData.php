<?php

namespace backend\components;

use Yii;
use yii\db\Expression;

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
                "category_name"  => Yii::t('app', 'Electronic'),
                "category_photo" => '37_nQ85Fomh-ltv7FtkJqUscrkx20Nwl0w_',
                "created_at"     => new Expression('NOW()'),
                "updated_at"     => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * dummy data for category table
     *
     * @param int $userId
     * @param int $categoryId
     *
     * @return array
     * @throws \Exception
     */
    public static function getDummyDateArticleInfo(int $userId, int $categoryId)
    {
        return [
            [
                "company_id"        => $userId,
                "category_id"       => $categoryId,
                "article_name_ar"   => "حاسوب شخصي",
                "article_name_en"   => "Laptop",
                "article_quantity"  => null,
                "article_unit"      => null,
                "article_photo"     => "12_E01odVcW3gNj2UzoexBL8fIegSMYdfig.jpg",
                "article_buy_price" => null,
                "created_at"        => new Expression('NOW()'),
                "updated_at"        => new Expression('NOW()'),
            ],
            [
                "company_id"        => $userId,
                "category_id"       => $categoryId,
                "article_name_ar"   => "حاسوب منزلي",
                "article_name_en"   => "Desktop",
                "article_quantity"  => null,
                "article_unit"      => null,
                "article_photo"     => "12_H5A_1vhVRMfUdd_NvjqkF9ZjNHAsxT5m.jpg",
                "article_buy_price" => null,
                "created_at"        => new Expression('NOW()'),
                "updated_at"        => new Expression('NOW()'),
            ],
            [
                "company_id"        => $userId,
                "category_id"       => $categoryId,
                "article_name_ar"   => "Mobile",
                "article_name_en"   => "جوال",
                "article_quantity"  => null,
                "article_unit"      => null,
                "article_photo"     => "12_oF_INRZa_gvYvVXWpHjCFoHy6BzzfbB2.png",
                "article_buy_price" => null,
                "created_at"        => new Expression('NOW()'),
                "updated_at"        => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getDummyDataCapital(int $userId)
    {
        return [
            [
                "company_id"    => $userId,
                "name"          => 'Test',
                "amount"        => 15000,
                "selected_date" => "2020-04-30",
                "status"        => "Entry",
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "name"          => "Ahmad",
                "amount"        => 500,
                "selected_date" => "2020-04-18",
                "status"        => "Entry",
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "name"          => 'Test',
                "amount"        => 1000,
                "selected_date" => new Expression('NOW()'),
                "status"        => "Withdrawal",
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "name"          => 'Ahmad',
                "amount"        => 200,
                "selected_date" => "2020-04-01",
                "status"        => "Withdrawal",
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getDummyDataIncomingRevenue(int $userId)
    {
        return [
            [
                "company_id"             => $userId,
                "daily_incoming_revenue" => 150,
                "selected_date"          => "2020-05-04",
                "created_at"             => new Expression('NOW()'),
                "updated_at"             => new Expression('NOW()'),
            ],
            [
                "company_id"             => $userId,
                "daily_incoming_revenue" => 150,
                "selected_date"          => '2020-05-05',
                "created_at"             => new Expression('NOW()'),
                "updated_at"             => new Expression('NOW()'),
            ],
            [
                "company_id"             => $userId,
                "daily_incoming_revenue" => 150,
                "selected_date"          => new Expression('NOW()'),
                "created_at"             => new Expression('NOW()'),
                "updated_at"             => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getDummyDataMarketExpense(int $userId)
    {
        return $market_expense = [
            [
                "company_id"    => $userId,
                "expense"       => 850,
                "reason"        => "اجار محل",
                "selected_date" => '2020-05-04',
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "expense"       => 30,
                "reason"        => "راتب عمال",
                "selected_date" => '2020-05-02',
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "expense"       => 30,
                "reason"        => "راتب عمال",
                "selected_date" => '2020-05-05',
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "expense"       => 26,
                "reason"        => "الرخصة",
                "selected_date" => new Expression('NOW()'),
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "expense"       => 50,
                "reason"        => "مخالفة",
                "selected_date" => new Expression('NOW()'),
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getDummyDataPurchases(int $userId)
    {
        return [
            [
                "company_id"    => $userId,
                "purchases"     => 150,
                "reason"        => "شراء بضاعة Sony",
                "selected_date" => "2020-05-04",
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "purchases"     => 150,
                "reason"        => "DEll شراء بضاعة",
                "selected_date" => '2020-05-05',
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
            [
                "company_id"    => $userId,
                "purchases"     => 150,
                "reason"        => "شراء بضاعة MEG",
                "selected_date" => new Expression('NOW()'),
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getDummyDataPurchaseInvoices(int $userId)
    {
        return [
            [
                "company_id"          => $userId,
                "seller_name"         => 'Sony',
                "invoice_name"        => '6171917096',
                "invoice_description" => 'Sony شركة',
                "amount"              => '850',
                "selected_date"       => "2020-05-04",
                "created_at"          => new Expression('NOW()'),
                "updated_at"          => new Expression('NOW()'),
            ],
            [
                "company_id"          => $userId,
                "seller_name"         => 'Dell',
                "invoice_name"        => '55885',
                "invoice_description" => 'Dell شركة',
                "amount"              => '420',
                "selected_date"       => '2020-05-05',
                "created_at"          => new Expression('NOW()'),
                "updated_at"          => new Expression('NOW()'),
            ],
            [
                "company_id"          => $userId,
                "seller_name"         => 'MGA',
                "invoice_name"        => '112445',
                "invoice_description" => 'MGA شركة',
                "amount"              => '850',
                "selected_date"       => new Expression('NOW()'),
                "created_at"          => new Expression('NOW()'),
                "updated_at"          => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @param int $userId
     *
     * @return array
     */
    public static function getDummyDataTaxOffice(int $userId)
    {
        return [
            [
                "company_id"    => $userId,
                "income"        => '525',
                "selected_date" => new Expression('NOW()'),
                "created_at"    => new Expression('NOW()'),
                "updated_at"    => new Expression('NOW()'),
            ],
        ];
    }

}