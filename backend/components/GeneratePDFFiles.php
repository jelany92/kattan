<?php

namespace backend\components;

use backend\models\PdfDownloadSelectedAdditionalContent;
use backend\models\PurchaseInvoices;
use common\models\BaseData;
use Yii;

class GeneratePDFFiles
{
    private static $partials = [
        '_css'            => [
            'doNewPage'     => false,
            'alwaysDisplay' => true,
        ],
        '_cover_page'     => [
            'doNewPage'     => true,
            'alwaysDisplay' => false,
        ],
        '_base_data'      => [
            'doNewPage'     => true,
            'alwaysDisplay' => false,
        ],
        '_preface'        => [
            'doNewPage'     => true,
            'alwaysDisplay' => false,
        ],
        '_provider_data'  => [
            'doNewPage'     => true,
            'alwaysDisplay' => false,
        ],
        '_functions'      => [
            'doNewPage'     => true,
            'alwaysDisplay' => false,
        ],
        '_final_page'     => [
            'doNewPage'     => true,
            'alwaysDisplay' => false,
        ],
        '_functions_text' => [
            'doNewPage'     => true,
            'alwaysDisplay' => false,
        ],
    ];

    /**
     * helper function to reduce code size
     *
     * @param  int $purchaseInvoicesId
     *
     * @return string
     */
    public static function renderPartial(int $purchaseInvoicesId)
    {
        $model = PurchaseInvoices::find()->andWhere(['id' => $purchaseInvoicesId])->all();
        return Yii::$app->controller->renderPartial('@backend/components/view/pdf-file/price-per-invoices-pdf.php', [
            'model' => $model,
        ]);
    }

    /**
     * renders PDF
     *
     * @param BaseData $model
     *
     * @return mixed
     * @throws \Mpdf\MpdfException
     * @throws \yii\base\InvalidConfigException
     */
    public static function pdf($id)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        /* @var $mpdf \Mpdf\Mpdf */
        $date = date('d.m.Y');
        //$content = $this->actionView($id, '/pdf-file/price-per-invoices-pdf');
        $pdf  = Yii::$app->pdf;
        $mpdf = $pdf->api;
        $mpdf->SetHeader($date . ' Kattan Shop');
        print_r($content);
        die();
        $mpdf->WriteHtml($content);
        return $mpdf->Output($date, 'D');
    }

    /**
     * generatePdfFilename
     *
     * @param BaseData $model
     *
     * @return string
     */
    public static function generatePdfFilename(BaseData $model)
    {
        $model->company_name = preg_replace("/[^a-zA-Z0-9 ]/", "", $model->company_name);
        $model->company_name = str_replace(" ", "_", $model->company_name);
        return date('Y_m_d') . '_Leistungskatalog_' . $model->company_name . '.pdf';
    }

    /**
     * returns array of saved colors of the given answer Id
     *
     * @param BaseData $baseData
     * @param          $answerId
     *
     * @return array|false
     * @throws \yii\db\Exception
     */
    public static function getAnswerColorByAnswerId(BaseData $baseData, $answerId)
    {
        $command = Yii::$app->getDb()->createCommand("
        SELECT DISTINCT a.name, pdac.color, pdac.back_color 
        FROM pdf_download_answer_color AS pdac 
        INNER JOIN pdf_download AS pd ON pd.id = pdac.pdf_download_id
        INNER JOIN pdf_download_selected_answer AS pdsa ON pdsa.pdf_download_id = pd.id AND pdsa.answer_id = pdac.answer_id
        INNER JOIN answer AS a ON a.id = pdac.answer_id
        WHERE pdac.answer_id = :answerId AND pd.base_data_id = :baseData
        ", [
            'answerId' => $answerId,
            'baseData' => $baseData->id,
        ]);
        return $command->queryOne();
    }
}