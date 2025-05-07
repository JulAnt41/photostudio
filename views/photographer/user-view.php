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

    <div class="photographer-image">
        <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($model->img)), ['alt' => Html::encode($model->user->name), 'class' => 'img-responsive']) ?>
    </div>

    <?= DetailView::widget([        
        'model' => $model,        
        'attributes' => [            
            [
                'label' => 'Специализация',
                'attribute' => 'specialization',
            ],  
            [                
                'label' => 'Почта',                
                'value' => $model->user->email, 
            ],            
            [                
                'label' => 'Телефон',                
                'value' => $model->user->phone,
            ],    
            [                
                'label' => 'О фотографе',                
                'attribute' => 'description',            
            ],         
            [
                'label' => 'Стоимость, рублей/час',
                'attribute' => 'price',
            ],         
        ],    
    ]) ?>    

        <div class="studio-info">
            <p><strong>Местоположение:</strong> <?= Html::encode($model->user->name) ?></p>
            <p><strong>Описание:</strong> <?= Html::encode($model->description) ?></p>
            <p><strong>Цена:</strong> <?= Html::encode($model->price) ?> рублей</p>
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

    <div class="actions">
        <?= Html::a('Назад', ['/photographer/user-index'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Нанять', ['/reservation/create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>

<style>
.photographer-view {    
    margin: 20px;    
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

.photographer-image {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 20px 0; 
    border: 2px solid #ddd; 
    border-radius: 10px; 
    background-color: #f9f9f9; 
}

.photographer-image img {
    max-width: 100%; 
    height: auto; 
}

.actions {
    margin-top: 20px;
}
</style>
