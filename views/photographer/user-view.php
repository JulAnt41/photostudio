<?php 
use yii\helpers\Html; 
use yii\widgets\DetailView; 
use yii\data\ActiveDataProvider; 
use app\models\Image; 
use app\models\Photographer; 

$this->title = $model->user->name; 
?>

<div class="photographer-view">    
    <h1><?= Html::encode($this->title) ?></h1>  

    <div class="photographer-info">
        <div class="photographer-image">
            <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($model->img)), ['alt' => Html::encode($model->user->name), 'class' => 'img-responsive']) ?>
        </div>  
        <div class="info_actions">
            <div class="info">
                <p><strong>Специализация:</strong> <?= Html::encode($model->specialization) ?></p>
                <p><strong>Почта:</strong> <?= Html::encode($model->user->email) ?></p>
                <p><strong>Телефон:</strong> <?= Html::encode($model->user->phone) ?></p>
                <p><strong>Стоимость услуг:</strong> <?= Html::encode($model->price) ?> рублей/час</p>
                <p><strong>О фотографе:</strong> <?= Html::encode($model->description) ?></p>
            </div>
            <div class="actions">
                <?= Html::a('Назад', ['/photographer/user-index'], ['class' => 'photog-card-btn']) ?>
                <?= Html::a('Нанять', ['/reservation/create'], ['class' => 'photog-card-btn']) ?>
            </div>
        </div>
    </div>

    <h2>Работы</h2>    
    <?php    
    $dataProvider = new ActiveDataProvider([        
        'query' => Image::find()->where(['id_photographer' => $model->id]),    
    ]);    
    ?>    

    <div class="images-gallery">        
        <?php foreach ($dataProvider->getModels() as $image): ?>            
            <div class="image-card">                
                <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($image->img)), ['alt' => 'Изображение', 'class' => 'img-responsive']) ?>            
            </div>        
        <?php endforeach; ?>    
    </div>

</div>

<style>
    .photographer-view {    
        margin: 20px; 
        color: rgba(54, 51, 47, 1);   
    }

    .photographer-info {
        display: flex;
        gap: 20px;
        background-color: rgba(235, 234, 237, 1);
        border-radius: 30px;
        padding: 20px;
        position: relative;
    }

    .info_actions {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .info p {
        font-size: 18px;
    }

    .images-gallery {    
        display: flex;    
        flex-wrap: wrap;    
        justify-content: space-between; /* Отображение карты изображений с помощью пространства */
    }

    .image-card {    
        margin: 10px;    
        border: 1px solid #ccc;    
        padding: 10px;    
        width: calc(33.333% - 20px);    
        box-sizing: border-box;    
    }

    .image-card img {    
        max-width: 100%;    
        height: auto;    
    }

    .photographer-image img {
        border-radius: 30px; 
        max-width: auto; 
        height: 400px; 
    }

    .actions {
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        align-self: flex-end; /* Выравнивание по правому краю родительского контейнера */
        width: 100%; /* Занимает всю доступную ширину */
        padding-right: 20px; /* Отступ от правого края */
    }

    .photog-card-btn {
        background-color: rgba(158, 105, 58, 1) !important;
        color: white !important;
        border-radius: 50px !important;
        padding: 15px 40px !important;
        border: none !important;
        text-decoration: none !important;
        letter-spacing: 1px;
        transition: background-color 0.3s ease;
        font-size: 15px;
    }

    .photog-card-btn:hover {
        background-color: rgb(126, 83, 45) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    h2 {
        margin-top: 20px;
    }
</style>
