<?php 
use yii\helpers\Html; 
use yii\data\ActiveDataProvider; 
use app\models\Image; 
use app\models\Photographer; 

$this->title = $model->user->name; 
$this->registerJs('
    document.querySelectorAll(".photo-square").forEach(item => {
        item.addEventListener("click", function() {
            const imgSrc = this.querySelector("img").src;
            const modal = document.createElement("div");
            modal.style.position = "fixed";
            modal.style.top = "0";
            modal.style.left = "0";
            modal.style.width = "100%";
            modal.style.height = "100%";
            modal.style.backgroundColor = "rgba(0,0,0,0.9)";
            modal.style.display = "flex";
            modal.style.alignItems = "center";
            modal.style.justifyContent = "center";
            modal.style.zIndex = "1000";
            modal.style.cursor = "pointer";
            
            const img = document.createElement("img");
            img.src = imgSrc;
            img.style.maxWidth = "90%";
            img.style.maxHeight = "90%";
            img.style.objectFit = "contain";
            
            modal.appendChild(img);
            document.body.appendChild(modal);
            
            modal.addEventListener("click", function() {
                document.body.removeChild(modal);
            });
        });
    });
');
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
                <?= Html::a('Назад', ['/photographer/user-index'], ['class' => 'btn']) ?>
                <?php if (Yii::$app->user->isGuest): ?>
                    <?= Html::a('Нанять', ['/user/create', 'message' => 'Чтобы нанять фотографа, необходимо зарегистрироваться.'],
                        ['class' => 'btn']) ?>
                <?php elseif (Yii::$app->user->identity->role == 1): ?>
                    <?= Html::a('Нанять', ['/reservation/create', 'id' => $model->id], ['class' => 'btn']) ?>
                <?php else: ?>
                    <?= Html::a('Нанять', ['/user/create', 'message' => 'Только пользователи могут нанять фотографа.'], 
                        ['class' => 'btn']) ?>
                <?php endif; ?>
            </div> 
        </div>
    </div>

    <h2>Работы</h2>    
    <?php    
    $dataProvider = new ActiveDataProvider([        
        'query' => Image::find()->where(['id_photographer' => $model->id]),    
    ]);    
    ?>    

    <div class="square-gallery">        
        <?php foreach ($dataProvider->getModels() as $image): ?>            
            <div class="photo-square">                
                <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($image->img)), ['alt' => 'Изображение', 'class' => 'square-img']) ?>            
            </div>        
        <?php endforeach; ?>    
    </div>
</div>

<style>
    .photographer-view {    
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    
    .photographer-info {
        display: flex;
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .photographer-image img {
        width: 300px;
        height: 300px;
        object-fit: cover;
        border-radius: 15px;
    }
    
    .info p {
        margin: 10px 0;
    }
    
    .square-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }
    
    .photo-square {
        aspect-ratio: 1/1;
        overflow: hidden;
        border-radius: 8px;
        cursor: pointer;
    }
    
    .square-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s;
    }
    
    .photo-square:hover .square-img {
        transform: scale(1.05);
    }
    
    .actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }
    
    .btn {
        background: #9e693a;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
    }

    .btn:hover {
        background-color: rgb(126, 83, 45) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        color: white;
    }
    
    @media (max-width: 768px) {
        .photographer-info {
            flex-direction: column;
        }
        
        .photographer-image img {
            width: 100%;
        }
        
        .square-gallery {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 480px) {
        .square-gallery {
            grid-template-columns: 1fr;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            margin-left: -10px;
            margin-right: -10px;
            padding-left: 10px;
            padding-right: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transform: translateZ(0);
            backface-visibility: hidden;
            perspective: 1000px;
            transform-style: preserve-3d;
            will-change: transform;
        }
    }
</style>