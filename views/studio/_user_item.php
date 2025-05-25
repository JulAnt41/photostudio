<?php

use yii\helpers\Html;

?>

<div class="studio-card">
    <img src="<?= Yii::getAlias('@web/images/' . Html::encode($model->img)) ?>" alt="<?= Html::encode($model->name) ?>" class="studio-image">
    <div class="studio-content">
        <div class="studio-title"><?= Html::encode($model->name) ?></div>
        <div class="studio-description"><?= Html::encode($model->location) ?></div>
        <div class="studio-price"><?= Html::encode($model->price) ?> рублей/час</div>
        <div class="studio-dimensions"><?= Html::encode($model->dimensions) ?> м²</div>
    </div>
    <div class="buttons">
        <?= Html::a('Подробнее', ['user-view', 'id' => $model->id], ['class' => 'studio-card-btn']) ?>
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

<style>
    .studio-card {
        position: relative;
        background-color: rgba(235, 234, 237, 1);
        border-radius: 15px;
        padding: 20px;
        margin: 15px;
        color: rgba(54, 51, 47, 1);
        transition: transform 0.2s;
        display: flex;
        gap: 20px;
        min-height: 250px; /* Фиксированная высота для всех карточек */
    }

    .studio-card:hover {
        transform: scale(1.05);
    }

    .studio-image {
        width: 40%;
        border-radius: 10px;
        object-fit: cover; /* Чтобы изображение заполняло область */
        height: 100%; /* Занимает всю высоту карточки */
    }

    .studio-content {
        flex: 1;
        position: relative;
        padding-bottom: 50px; /* Оставляем место для кнопок */
    }

    .studio-title {
        font-size: 2em;
        margin: 10px 0;
        font-weight: 500;
    }

    .studio-description, .studio-price, .studio-dimensions {
        font-size: 1em;
        line-height: 1.6;
        margin-bottom: 8px;
    }

    .buttons {
        position: absolute;
        bottom: 20px;
        right: 20px;
        display: flex;
        gap: 10px;
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
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>