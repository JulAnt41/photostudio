<?php

namespace app\controllers;

use Yii;
use app\models\Image;
use app\models\Photographer;
use app\models\ImageSearch;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ImageController extends Controller
{

    public function actionCheckEnvironment()
{
    echo '<h3>Проверка окружения:</h3>';
    echo '<ol>';
    echo '<li>Папка images существует: '.(is_dir(Yii::getAlias('@webroot/images/')) ? '✅' : '❌').'</li>';
    echo '<li>Папка доступна для записи: '.(is_writable(Yii::getAlias('@webroot/images/')) ? '✅' : '❌').'</li>';
    echo '<li>Размер upload_max_filesize: '.ini_get('upload_max_filesize').'</li>';
    echo '<li>Размер post_max_size: '.ini_get('post_max_size').'</li>';
    echo '</ol>';
    echo '<p>Проверьте <a href="'.Url::to(['create']).'">форму загрузки</a></p>';
}

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
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Устанавливаем заголовок
        $this->view->title = 'Ваше портфолио';
        
        // Проверяем, является ли пользователь фотографом
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->photographer) {
            $this->view->title = 'Портфолио фотографа: ' . Yii::$app->user->identity->name;
        }

        return $this->render('index', [
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
    $model = new Image();
    
    // Получаем фотографа
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }
    
    $photographer = Photographer::findOne(['id_user' => Yii::$app->user->id]);
    if (!$photographer) {
        Yii::$app->session->setFlash('error', 'Только фотографы могут загружать изображения');
        return $this->redirect(['index']);
    }
    
    $model->id_photographer = $photographer->id;

    if (Yii::$app->request->isPost) {
        $model->load(Yii::$app->request->post());
        $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
        
        if ($model->imageFile === null) {
            Yii::$app->session->setFlash('error', 'Не выбран файл для загрузки');
        } elseif ($model->validate()) {
            $filename = 'img_'.time().'_'.Yii::$app->security->generateRandomString(6).'.'.$model->imageFile->extension;
            $path = Yii::getAlias('@webroot/images/'.$filename);
            
            if ($model->imageFile->saveAs($path)) {
                $model->img = $filename;
                if ($model->save(false)) { // false - пропускаем повторную валидацию
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
            Yii::$app->session->setFlash('error', 'Ошибка при сохранении файла');
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
        if (($model = Image::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
