<?php

namespace backend\controllers\quiz;

use backend\models\quiz\StudentAnswers;
use backend\models\quiz\Students;
use Yii;
use backend\models\quiz\search\StudentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StudentsController implements the CRUD actions for StudentsCrud model.
 */
class StudentsController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all StudentsCrud models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel  = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/quiz/students/index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StudentsCrud model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->redirect([
                                   '/quiz/students/view',
                                   'model' => $model,
                               ]);
    }

    /**
     * Creates a new StudentsCrud model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Students();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->saveStudent();
            Yii::$app->session->addFlash('success', 'done');
            return $this->redirect(['quiz/students/index']);
        }

        return $this->render('/quiz/students/create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing StudentsCrud model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->saveStudent();
            Yii::$app->session->addFlash('success', 'done');
            return $this->redirect(['quiz/students/index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing StudentsCrud model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        $this->findModel($id)->delete();
        StudentAnswers::deleteAll(['student_id' => $id]);
        return $this->redirect(['quiz/students/index']);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionDeleteNotCompletedStudent()
    {
        Students::deleteAll(['is_complete' => 0]);

        return $this->redirect(['quiz/students/index']);
    }

    /**
     * Finds the StudentsCrud model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Students the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {
        if (($model = Students::findOne($id)) !== null)
        {
            return $model;
        }
        else
        {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
