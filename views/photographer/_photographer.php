<?php
use yii\helpers\Html;
?>

<div class="photographer">
    <div class="photo photographer-image">
        <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($model->img)), ['alt' => Html::encode($model->user->name)]) ?>
    </div>
    <div class="info">
        <h2><?= Html::encode($model->user->name) ?></h2>
        <p>Телефон: <?= Html::encode($model->user->phone) ?></p>
        <p>Email: <?= Html::encode($model->user->email) ?></p>
        <p>Специализация: <?= Html::encode($model->specialization) ?></p>
        <p>Цена: <?= Html::encode($model->price) ?> рублей/час</p>
        <p>Описание: <?= Html::encode($model->description) ?></p>
    </div>
    <div class="portfolio">
        <?php foreach ($model->images as $image): ?>
            <div class="photographer-image">
                <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($image->img)), ['alt' => 'Работа']) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="actions">
        <?= Html::a('Просмотреть', ['photographer/user-view', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Нанять', ['reservation/create'], ['class' => 'btn btn-success']) ?>
    </div>
</div>

<style>
    .photographer {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 20px;
        margin: 20px;
    }

    .photographer-image {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 20px 0;
        border: 2px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        background-color: #f9f9f9;
    }

    .photographer-image img {
        max-width: 100%;
        height: auto;
        border-bottom: 2px solid #ddd;
    }

    .info h2 {
        margin-top: 0;
    }

    .portfolio {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 10px;
    }

    .portfolio img {
        width: 100px;
        height: auto;
        margin: 5px;
        border-radius: 5px; /* Закругление углов для изображений в портфолио */
    }

    .actions {
        margin-top: 15px;
    }
</style>
