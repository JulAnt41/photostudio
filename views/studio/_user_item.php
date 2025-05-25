<?php
use yii\helpers\Html;

/* @var $model app\models\Studio */

?>

<!-- <div class="studio-item">
    <h2><?= Html::encode($model->name) ?></h2>
    <p>Местоположение: <?= Html::encode($model->location) ?></p>
    <p><?= Html::a('Подробнее', ['view', 'id' => $model->id], ['class' => 'btn btn-info']) ?></p>
</div> -->

<div class="studio-card">
    <img src="<?= Yii::getAlias('@web/images/' . Html::encode($model->img)) ?>" alt="<?= Html::encode($model->name) ?>" class="studio-image">
    <div class="studio-content">
        <div class="studio-title"><?= Html::encode($model->name) ?></div>
        <div class="studio-description"><?= Html::encode($model->location) ?></div>
        <div class="studio-price"><?= Html::encode($model->price) ?> рублей/час</div>
        <div class="studio-dimensions"><?= Html::encode($model->dimensions) ?> м²</div>
        <div class="buttons">
            <p><?= Html::a('Подробнее', ['user-view', 'id' => $model->id], ['class' => 'studio-card-btn']) ?></p>
            <p><?= Html::a('Забронировать', ['/reservation/create', 'id' => $model->id], ['class' => 'studio-card-btn']) ?></p>
        </div>
    </div>    
</div>

<style>
    .studio-card {
        position: relative; /* Установка относительного позиционирования */
        background-color: rgba(235, 234, 237, 1);
        border-radius: 15px;
        padding: 20px;
        margin: 15px;
        color: rgba(54, 51, 47, 1);
        /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2); */
        transition: transform 0.2s;
        display: flex;
        gap: 20px;
    }

    .studio-card:hover {
        transform: scale(1.05);
    }

    .studio-image {
        width: 40%;
        border-radius: 10px;
        /* border: 2px solid #ffffff; */
        transition: filter 0.3s;
    }

    .studio-card:hover .studio-image {
        filter: brightness(85%);
    }

    .studio-title {
        font-size: 2em;
        margin: 10px 0;
        font-weight: 500;
    }

    .studio-description, .studio-price, .studio-dimensions {
        font-size: 1em;
        line-height: 1.6;
    }

    .buttons {
        position: absolute; /* Установка абсолютного позиционирования */
        bottom: 5px; /* Отступ от низа карточки */
        right: 20px; /* Отступ от правого края */
        display: flex;
        gap: 10px; /* Интервал между кнопками */
    }
    .studio-card-btn {
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

    .studio-card-btn:hover {
        background-color: rgb(126, 83, 45) !important;
        /* transform: translateY(-2px); */
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>
