<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Studio */

$this->title = Html::encode($model->name);
// $this->params['breadcrumbs'][] = ['label' => 'Студии', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="studio-view">
    <h1><?= $this->title ?></h1>

    <div class="studio-details">
    <div class="studio-image">
        <img src="<?= Yii::getAlias('@web/images/' . Html::encode($model->img)) ?>" alt="<?= Html::encode($model->name) ?>">
    </div>
        <div class="studio-info">
            <p><strong>Местоположение:</strong> 
                <?= Html::a(
                    Html::encode($model->location),
                    'https://yandex.ru/maps/?text=' . urlencode($model->location),
                    ['target' => '_blank']
                ) ?>
            </p>
            <p><strong>Описание:</strong> <?= Html::encode($model->description) ?></p>
            <p><strong>Цена:</strong> <?= Html::encode($model->price) ?> рублей/час</p>
            <p><strong>Размеры:</strong> <?= Html::encode($model->dimensions) ?> квадратных метров</p>
        </div>
    </div>

    <div class="buttons">
        <?= Html::a('Назад', ['user-index'], ['class' => 'studio-card-btn']) ?>
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Забронировать', ['/user/create', 'message' => 'Чтобы забронировать студию, необходимо зарегистрироваться.'],
                ['class' => 'studio-card-btn']) ?>
        <?php elseif (Yii::$app->user->identity->role == 1): ?>
            <?= Html::a('Забронировать', ['/reservation/create', 'id' => $model->id], ['class' => 'studio-card-btn']) ?>
        <?php else: ?>
            <?= Html::a('Забронировать', ['/user/create', 'message' => 'Только пользователи могут забронировать студию.'], 
                ['class' => 'studio-card-btn']) ?>
        <?php endif; ?>
    </div> 
    
</div>

<div class="studio-map">
    <iframe 
        src="https://yandex.ru/map-widget/v1/?text=<?= urlencode($model->location) ?>&z=15&mode=search" 
        width="100%" 
        height="400" 
        frameborder="1" 
        allowfullscreen="true">
    </iframe>
</div>

<style>
    .studio-view {
        position: relative;
        background-color: rgba(235, 234, 237, 1); /* Светлый фон для страницы */
        border-radius: 8px; /* Скруглённые углы */
        padding: 20px; /* Отступы внутри страницы */
        margin: 20px; /* Отступы снаружи */
        color: rgba(54, 51, 47, 1);
        /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); */
    }

    .studio-details {
        display: flex; /* Flexbox для расположения изображения и информации */
        margin-bottom: 20px; /* Отступ между деталями студии и кнопкой */
    }

    .studio-image {
        flex: 1; /* Занять одну часть от flex контейнера */
        margin-right: 20px; /* Отступ справа от изображения */
    }

    .studio-image img {
        width: 100%; /* Адаптивное изображение */
        border-radius: 10px; /* Скруглённые углы для изображений */
    }

    .studio-info {
        flex: 2; /* Занять две части от flex контейнера */
    }

    .studio-info p {
        font-size: 1.2em; /* Размер текста информации */
        line-height: 1.5; /* Межстрочный интервал */
    }

    .studio-info a {
        color: rgba(145, 44, 47, 1);
        text-decoration: underline;
        cursor: pointer;
    }

    .studio-info a:hover {
        text-decoration: none;
    }

    .buttons {
        position: absolute; /* Установка абсолютного позиционирования */
        bottom: 15px; /* Отступ от низа карточки */
        right: 20px; /* Отступ от правого края */
        display: flex;
        gap: 10px; /* Интервал между кнопками */
    }
    
    .studio-card-btn {
        background-color: rgba(158, 105, 58, 1) !important;
        color: white !important;
        border-radius: 50px !important;
        padding: 10px 35px !important;
        border: none !important;
        text-decoration: none !important;
        letter-spacing: 1px;
        transition: background-color 0.3s ease;
        font-size: 15px;
    }

    .studio-card-btn:hover {
        background-color: rgb(126, 83, 45) !important;
        /* transform: translateY(-2px); */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .studio-map {
        margin: 20px;
        overflow: hidden;
    }
</style>