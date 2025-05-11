<?php

namespace app\controllers;

use Yii;
use app\models\Photographer;
use app\models\PhotographerSearch;
use app\models\Reservation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PhotographerController implements the CRUD actions for Photographer model.
 */
class PhotographerController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Photographer models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PhotographerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserIndex()
    {
        $searchModel = new PhotographerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('user-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPhotographerIndex()
    {
        $searchModel = new PhotographerSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('photographer-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        
    }

    /**
     * Displays a single Photographer model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUserView($id)
    {
        return $this->render('user-view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPhotographerView()
    {
        $userId = Yii::$app->user->identity->id; // Получаем ID текущего пользователя
        $upcomingReservations = Reservation::find()
            ->where(['id_photographer' => $userId])
            ->andWhere(['>=', 'date', date('Y-m-d')]) // Фильтруем только предстоящие фотосессии
            ->all();

        return $this->render('photographer-view', [
            'upcomingReservations' => $upcomingReservations,
        ]);
    }


    /**
     * Creates a new Photographer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Photographer();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Photographer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Photographer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Photographer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Photographer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Photographer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
