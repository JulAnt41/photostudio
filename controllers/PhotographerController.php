<?php

namespace app\controllers;

use Yii;
use app\models\Photographer;
use app\models\PhotographerSearch;
use app\models\Reservation;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class PhotographerController extends Controller
{
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

    public function actionCreate()
    {
        $model = new Photographer();

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            
            if ($model->imageFile === null) {
                Yii::$app->session->setFlash('error', 'Не выбран файл для загрузки');
            } elseif ($model->upload()) {
                if ($model->save(false)) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при сохранении данных');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла: ' . implode(', ', $model->getFirstErrors()));
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            
            // Если загружено новое изображение
            if ($model->imageFile !== null) {
                if ($model->upload()) {
                    // Сохраняем модель без валидации (false), так как мы уже проверили файл
                    if ($model->save(false)) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'Ошибка при загрузке файла');
                }
            } 
            // Если изображение не загружали, просто сохраняем модель
            elseif ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Photographer::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionMyPhotos()
    {
        // Получаем id фотографа (например, из сессии или Auth)
        $id_photographer = Yii::$app->user->identity->photographer->id; // если связь есть
        
        // Или, если id передаётся параметром:
        // $id_photographer = Yii::$app->request->get('id_photographer');
        
        $photos = Image::find()
            ->where(['id_photographer' => $id_photographer])
            ->all();
        
        return $this->render('my-photos', [
            'photos' => $photos,
        ]);
    }
}
