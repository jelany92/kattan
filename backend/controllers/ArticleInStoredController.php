<?php

namespace backend\controllers;

use backend\models\ArticleInventory;
use backend\models\searchModel\ArticleInventorySearch;
use common\models\ArticleInfo;
use common\models\ArticlePrice;
use Yii;
use backend\models\ArticleInStored;
use backend\models\searchModel\ArticleInStoredSearch;
use yii\db\Expression;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ArticleInStoredController implements the CRUD actions for ArticleInStored model.
 */
class ArticleInStoredController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ArticleInStored models.
     *
     * @return mixed
     */
    public function actionIndexInventory()
    {
        $searchModel  = new ArticleInventorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/supermarket/article-in-stored/inventory', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all ArticleInStored models.
     *
     * @param int $id
     *
     * @return string|void
     * @throws NotFoundHttpException
     * @throws \yii\db\Exception
     */
    public function actionIndex(int $id)
    {
        $modelArticleInventory = ArticleInventory::find()->andWhere(['id' => $id])->one();
        $searchModel           = new ArticleInStoredSearch();
        $dataProvider          = $searchModel->search(Yii::$app->request->queryParams, $id);
        $result                = ArticleInStored::find()->select([
                                                                     'result' => new Expression(ArticleInStored::tableName() . '.count *' . ArticlePrice::tableName() . '.article_prise_per_piece'),
                                                                 ])->innerJoinWith('articlePrice')->andWhere([ArticleInStored::tableName() . '.article_inventory_id' => $id])->groupBy(ArticlePrice::tableName() . '.article_info_id')->createCommand()->queryAll(\PDO::FETCH_COLUMN);
        if (Yii::$app->request->post('hasEditable'))
        {
            $articleInventoryId = Yii::$app->request->post('editableKey');

            $model = $this->findModel($articleInventoryId);

            $out                     = Json::encode([
                                                        'output'  => '',
                                                        'message' => '',
                                                    ]);
            $post                    = [];
            $posted                  = current($_POST['ArticleInStored']);
            $post['ArticleInStored'] = $posted;

            // load model like any single model validation
            if ($model->load($post))
            {
                $model->save();
                $output = '';
                $out    = Json::encode([
                                           'output'  => $output,
                                           'message' => '',
                                       ]);
            }
            // return ajax json encoded response and exit
            echo $out;
            return;

        }
        return $this->render('/supermarket/article-in-stored/index', [
            'modelArticleInventory' => $modelArticleInventory,
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'result'                => array_sum($result),
        ]);
    }

    /**
     * Displays a single ArticleInStored model.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('/supermarket/article-in-stored/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ArticleInStored model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleInStored();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect([
                                       '/supermarket/article-in-stored/view',
                                       'id' => $model->id,
                                   ]);
        }

        return $this->render('/supermarket/article-in-stored/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ArticleInStored model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect([
                                       '/supermarket/article-in-stored/view',
                                       'id' => $model->id,
                                   ]);
        }

        return $this->render('/supermarket/article-in-stored/update', [
            'model' => $model,
        ]);
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $model = $this->findModel($id);
        $model->delete();
        Yii::$app->session->addFlash('success', Yii::t('app', 'تم حذف العنصر من المستودع'));
        return $this->redirect([
                                   'index',
                                   'id' => $model->article_inventory_id,
                               ]);
    }

    /**
     * @param int $id
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDeleteInventory(int $id)
    {
        ArticleInStored::deleteAll(['article_inventory_id' => $id]);
        ArticleInventory::deleteAll(['id' => $id]);
        Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
        return $this->redirect(['index-inventory']);
    }

    /**
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionInventory()
    {
        $modelArticleInfo = ArticleInfo::find()->andWhere(['company_id' => Yii::$app->user->id])->all();
        $date             = new \DateTime();
        $transaction      = Yii::$app->db->beginTransaction();
        try
        {
            $modelArticleInventory                 = new ArticleInventory();
            $modelArticleInventory->inventory_name = 'جرد' . ' ' . $date->format('Y-m-d');
            $modelArticleInventory->save();
            foreach ($modelArticleInfo as $articleInfo)
            {
                $modelArticleInStored                       = new ArticleInStored();
                $modelArticleInStored->article_info_id      = $articleInfo['id'];
                $modelArticleInStored->article_inventory_id = $modelArticleInventory->id;
                $modelArticleInStored->selected_date        = $date->format('Y-m-d');
                $modelArticleInStored->save();
            }
            Yii::$app->session->addFlash('success', Yii::t('app', 'done'));
            $transaction->commit();
        }
        catch (\Exception $e)
        {
            $transaction->rollBack();
            throw $e;
        }
        return $this->redirect([
                                   'index-inventory',
                                   'id' => $modelArticleInventory->id,
                               ]);
    }

    /**
     * Finds the ArticleInStored model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return ArticleInStored the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleInStored::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
