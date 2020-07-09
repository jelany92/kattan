<?php

namespace backend\controllers\quiz;

use backend\models\quiz\Excercise;
use backend\models\quiz\StudentAnswers;
use backend\models\quiz\StudentAnswersCrud;
use backend\models\quiz\StudentsCrud;
use backend\models\quiz\SubmitForm;
use common\models\LoginForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class TokenController extends Controller
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model   = new SubmitForm();
        $session = Yii::$app->session;
        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $session->set('token', $model->token);
            return $this->redirect(['start-excercise']);
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
        {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays Summerize page.
     *
     * @return Response|string
     */
    public function actionSummary()
    {
        $summary  = StudentsCrud::find()->select('COUNT(id) total_siswa, AVG(score) rata_rata')->where(['is_complete' => true])->asArray()->one();
        $nilaiMin = StudentsCrud::find()->select('score, name')->asArray()->orderBy('score DESC')->one();
        $nilaiMax = StudentsCrud::find()->select('score, name')->asArray()->orderBy('score ASC')->one();
        $deviasi  = 0;
        if ($summary['total_siswa'] > 1)
        {
            foreach (StudentsCrud::find()->select('score')->asArray()->all() as $list)
            {
                $sDev    = pow(($list['score'] - $summary['rata_rata']), 2);
                $deviasi += ($sDev / ($summary['total_siswa'] - 1));
            }
        }
        return $this->render('summary', [
            'summary' => $summary,
            'min'     => $nilaiMax,
            'max'     => $nilaiMin,
            'deviasi' => $deviasi,
        ]);
    }

    /**
     * Displays excercise page.
     *
     * @return string
     */
    public function actionStartExcercise()
    {
        $student = StudentsCrud::findOne(['token' => Yii::$app->session->get('token')]);
        if (!Yii::$app->session->get('token') || $student->is_complete)
        {
            Yii::$app->getSession()->setFlash('submit', 'Submit was completed');
            return $this->redirect('index');
        }

        $post           = Yii::$app->request->post();
        $modelForm      = [];
        $errorMessage   = [];
        $successMessage = [];
        foreach ($models = Excercise::find()->all() as $model)
        {
            $studentAnswer = StudentAnswersCrud::find()->where([
                                                                   'student_id'   => $student->id,
                                                                   'excercise_id' => $model->id,
                                                               ])->one();
            if (!$studentAnswer)
            {
                $studentAnswer = new StudentAnswersCrud();
            }
            if ($studentAnswer->load($post, $model->id))
            {
                $studentAnswer->student_id   = $student->id;
                $studentAnswer->excercise_id = $model->id;
                if ($studentAnswer->save())
                {
                    $successMessage[] = $model->id;
                }
                else
                {
                    $errorMessage[] = $model->id;
                }
            }

            $modelForm[$model->id] = $studentAnswer;
        }
        if ($successMessage)
        {
            Yii::$app->getSession()->setFlash('success', 'Submit number ' . implode(', ', $successMessage) . ' data was success');
        }
        if (count($successMessage) == Excercise::find()->count())
        {
            $student->sumCorrect();
            Yii::$app->getSession()->setFlash('submit', 'Submit was completed');
            return $this->redirect('index');
        }

        return $this->render('excercise', [
            'models'    => $models,
            'modelForm' => $modelForm,
        ]);
    }

    /**
     * Displays excercise page.
     *
     * @return string
     */
    public function _actionStartExcercise()
    {
        $successMessage = [];
        $models = new StudentAnswers();
        $excercise = Excercise::find()->andWhere(['main_category_exercise_id' => 1])->createCommand()->queryAll();

        if ($models->load(Yii::$app->request->post()) && $models->validate())
        {
            var_dump('tes');die();
            $student->sumCorrect();
            Yii::$app->getSession()->setFlash('submit', 'Submit was completed');
            return $this->redirect('index');
        }

        return $this->render('excercise', [
            'models'    => $models,
            'excercise' => $excercise,
        ]);
    }

}
