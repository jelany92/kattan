<?php

namespace backend\controllers;

use common\controller\BaseController;
use common\models\auth\AuthItem;
use common\models\auth\search\AuthItemSearch;
use common\models\UserModel;
use Yii;
use yii\bootstrap4\Html;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * AuthItemController implements the CRUD actions for AuthItem model.
 */
class AuthItemController extends BaseController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        // GET is needed for functional test
        // in order to avoid confirmation box
        $deleteActions = ((YII_ENV != YII_ENV_PROD) ? ['POST', 'GET'] : ['POST']);
        return ['verbs' => ['class'   => VerbFilter::class,
                            'actions' => ['delete' => $deleteActions,],],];
    }

    /**
     * Lists all AuthItem models.
     * @return redirect to index view
     */
    public function actionIndex()
    {
        $searchModel  = new AuthItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $providerRole = new ActiveDataProvider(['query'      => AuthItem::find()
                                                                        ->role(),
                                                'pagination' => ['pageSize' => Yii::$app->params['pageSize'],],]);
        $providerTask = new ActiveDataProvider(['query'      => AuthItem::find()
                                                                        ->task(),
                                                'pagination' => ['pageSize' => Yii::$app->params['pageSize'],],]);

        $providerPermission = new ActiveDataProvider(['query'      => AuthItem::find()
                                                                              ->permission(),
                                                      'pagination' => ['pageSize' => Yii::$app->params['pageSize'],],]);


        return $this->render('index', ['searchModel'            => $searchModel,
                                       'dataProvider'           => $dataProvider,
                                       'dataProviderRole'       => $providerRole,
                                       'dataProviderPermission' => $providerPermission,
                                       'dataProviderTask'       => $providerTask,]);
    }

    /**
     * Displays a single AuthItem model.
     *
     * @param string $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model                        = $this->findModel($id);
        $userDataProvider             = new ActiveDataProvider();
        $userDataProvider->query      = UserModel::find()
                                                 ->role($model->name);
        $userDataProvider->pagination = false;

        return $this->render('view', ['model'              => $model,
                                      'dataProviderParent' => $this->getDataProviders($id)['dataProviderParent'],
                                      'dataProviderChild'  => $this->getDataProviders($id)['dataProviderChild'],
                                      'dataProviderUser'   => $userDataProvider,]);
    }

    /**
     * Finds the AuthItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param string $id
     *
     * @return AuthItem the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AuthItem::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'Seite nicht gefunden'));
    }

    /**
     *
     * Returns array of data providers
     *
     * @param $id
     *
     * @return array
     */
    private function getDataProviders($id)
    {
        $providerChild = new ActiveDataProvider(['query'      => AuthItem::find()
                                                                         ->child($id),
                                                 'pagination' => false]);

        $providerParent = new ActiveDataProvider(['query'      => AuthItem::find()
                                                                          ->parent($id),
                                                  'pagination' => false]);

        return ['dataProviderChild'  => $providerChild,
                'dataProviderParent' => $providerParent,];
    }

    /**
     * Creates a new AuthItem model.
     *
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionCreate()
    {
        $model           = new AuthItem();
        $model->scenario = AuthItem::SCENARIO_CREATE;

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->createAuthItem();
            Yii::$app->session->addFlash('success', Yii::t('app', 'Eintrag wurde erstellt'));
            return $this->redirect(['view',
                'id' => $model->name,]);
        }

        return $this->render('create', ['model'    => $model,
                                        'typeList' => $model->getTypeList(),]);
    }

    /**
     * Updates an existing AuthItem model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param string $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model           = $this->findModel($id);
        $model->scenario = AuthItem::SCENARIO_UPDATE;
        $typeList        = $model->getTypeList();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $authObject = $model->getAuthObject();
            Yii::$app->authManager->update($model->name, $authObject);
            Yii::$app->session->addFlash('success', Yii::t('app', 'Eintrag wurde aktualisiert'));
            return $this->redirect(['view',
                'id' => $model->name,]);
        }
        return $this->render('update', ['model'    => $model,
                                        'typeList' => $typeList,]);
    }

    /**
     * assigns a child AuthItem object to the current parent
     * the result of the assignment will be displayed in the detailed view
     *
     * @param string $id
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAssign($id)
    {
        $parent = $this->findModel($id);
        if (Yii::$app->request->post('item'))
        {
            $child = $this->findModel(Yii::$app->request->post('item'));

            // Prüfe ob child parent zugewiesen werden darf
            $availableItems = AuthItem::getNotYetAssigned($parent, [$child->type]);
            foreach ($availableItems AS $item)
            {
                if ($item->name == $child->name)
                {
                    Yii::$app->authManager->addChild($parent, $child);
                    break;
                }
            }
        }

        return $this->redirect(['view',
            'id' => $parent->name,]);
    }

    /**
     * removes child from parent object
     * the result of the unassignment will be displayed in the detailed view
     *
     * @param string $parent
     * @param string $child
     *
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUnassign($parent, $child)
    {
        try
        {
            $parentModel = $this->findModel($parent);
            $childModel  = $this->findModel($child);
            Yii::$app->authManager->removeChild($parentModel, $childModel);
            Yii::$app->session->addFlash('success', Yii::t('app', "Zuordnung von {child} zu {parent} wurde erfolgreich aufgehoben", ['child' => $child, 'parent' => $parent]));
        } catch (\Exception $e)
        {
            Yii::$app->session->addFlash('error', Yii::t('app', "Zuordnung von {child} zu {parent} konnte nicht aufgehoben werden", ['child' => $child, 'parent' => $parent]));
        }
        return $this->redirect(['view',
            'id' => $parent,]);
    }

    /**
     * Deletes an existing AuthItem model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param $id name of authItem to be deleted
     *
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if ($model->hasChildren() || $model->isAdminRole() || $model->isSuperPermission())
        {
            Yii::$app->session->addFlash('error', Yii::t('app', "{authItem} konnte nicht gelöscht werden", ['authItem' => Html::encode($model->name)]));
        }
        else
        {
            $model->delete();
            Yii::$app->session->addFlash('success', Yii::t('app', "{authItem} erfolgreich gelöscht", ['authItem' => Html::encode($model->name)]));
        }
        return $this->redirect(['index']);
    }
}
