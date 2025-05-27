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

/**
 * ImageController implements the CRUD actions for Image model.
 */
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
     * Lists all Image models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ImageSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Image model.
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

    /**
     * Creates a new Image model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    // public function actionCreate()
    // {
    //     $model = new Image();

    //     if ($this->request->isPost) {
    //         if ($model->load($this->request->post()) && $model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     } else {
    //         $model->loadDefaultValues();
    //     }

    //     return $this->render('create', [
    //         'model' => $model,
    //     ]);
    // }

//     public function actionCreate()
// {
//     $model = new Image();
//     $model->id_photographer = Yii::$app->photographer->id;

//     if ($model->load(Yii::$app->request->post())) {
//         $file = UploadedFile::getInstance($model, 'img');
        
//         if ($file) {
//             $path = Yii::getAlias('@webroot/images/');
//             $filename = 'img_' . time() . '.' . $file->extension;
            
//             if ($file->saveAs($path . $filename)) {
//                 $model->img = $filename;
                
//                 if ($model->save()) {
//                     return $this->redirect(['view', 'id' => $model->id]);
//                 }
//             }
//         }
//     }

//     return $this->render('create', [
//         'model' => $model,
//     ]);
// }

// controllers/ImageController.php
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

    /**
     * Updates an existing Image model.
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
     * Deletes an existing Image model.
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
     * Finds the Image model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Image the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Image::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
