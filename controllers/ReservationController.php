<?php

namespace app\controllers;

use Yii;
use app\models\Reservation;
use app\models\ReservationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use app\models\Studio;
use app\models\Photographer;
use yii\data\ActiveDataProvider;
use app\models\Review;

class ReservationController extends Controller
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
        $searchModel = new ReservationSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionUserIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Reservation::find()->where(['id_user' => Yii::$app->user->id])->orderBy(['date' => SORT_DESC]),
        ]);
        
        $reviewModel = new Review();
        
        return $this->render('user-index', [
            'dataProvider' => $dataProvider,
            'reviewModel' => $reviewModel,
        ]);
    }

    public function actionPhotographerIndex()
    {
        // Проверяем, является ли пользователь фотографом
        if (Yii::$app->user->isGuest || !Yii::$app->user->identity->photographer) {
            throw new \yii\web\ForbiddenHttpException('Доступ только для фотографов');
        }

        $searchModel = new ReservationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Фильтруем только предстоящие съемки (по желанию)
        $dataProvider->query->andWhere(['>=', 'date', date('Y-m-d')]);

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

    public function actionCreate()
    {
        $model = new Reservation();
        $model->id_user = Yii::$app->user->id; // Автоматически подставляем текущего пользователя

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['user-index', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Reservation::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);
        
        // Обновляем только статус, минуя валидацию
        if ($model->updateAttributes(['id_status' => $status])) {
            Yii::$app->session->setFlash('success', 'Статус успешно изменен');
        } else {
            Yii::$app->session->setFlash('error', 'Ошибка при изменении статуса');
        }
        
        return $this->redirect(['view', 'id' => $id]);
    }

public function actionCalculatePrice()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    try {
        $id_studio = (int)Yii::$app->request->get('id_studio');
        $id_photographer = (int)Yii::$app->request->get('id_photographer');
        $hours = (int)Yii::$app->request->get('hours');
        
        if (!$id_studio || !$id_photographer || !$hours) {
            throw new \Exception('Укажите студию, фотографа и длительность');
        }
        
        $studio = Studio::findOne($id_studio);
        $photographer = Photographer::findOne($id_photographer);
        
        if (!$studio) throw new \Exception('Студия не найдена');
        if (!$photographer) throw new \Exception('Фотограф не найден');
        
        $price = ($studio->price + $photographer->price) * $hours;
        return ['price' => $price . ' руб.'];
        
    } catch (\Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

public function actionCheckAvailability()
{
    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
    $id_studio = Yii::$app->request->get('id_studio');
    $id_photographer = Yii::$app->request->get('id_photographer');
    $date = Yii::$app->request->get('date');
    
    if (empty($id_studio) || empty($id_photographer) || empty($date)) {
        return ['error' => 'Не все параметры указаны', 'busyTimes' => []];
    }
    
    try {
        $busyTimes = [];
        $reservations = Reservation::find()
            ->where(['date' => $date])
            ->andWhere(['or', 
                ['id_studio' => $id_studio],
                ['id_photographer' => $id_photographer]
            ])
            ->all();
        
        foreach ($reservations as $reservation) {
            $start = strtotime($reservation->start_time);
            $end = strtotime($reservation->end_time);
            
            if ($start === false || $end === false) {
                continue;
            }
            
            for ($time = $start; $time < $end; $time += 3600) {
                $timeStr = date('H:i', $time);
                if (!in_array($timeStr, $busyTimes)) {
                    $busyTimes[] = $timeStr;
                }
            }
        }
        
        return ['busyTimes' => $busyTimes];
    } catch (\Exception $e) {
        Yii::error("Error checking availability: " . $e->getMessage());
        return ['error' => $e->getMessage(), 'busyTimes' => []];
    }
}
    
}
