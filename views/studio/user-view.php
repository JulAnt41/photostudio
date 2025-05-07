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
            <p><strong>Местоположение:</strong> <?= Html::encode($model->location) ?></p>
            <p><strong>Описание:</strong> <?= Html::encode($model->description) ?></p>
            <p><strong>Цена:</strong> <?= Html::encode($model->price) ?> рублей</p>
            <p><strong>Размеры:</strong> <?= Html::encode($model->dimensions) ?> квадратных метров</p>
        </div>
    </div>

    <p class="buttons">
        <?= Html::a('Назад', ['user-index'], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Забронировать', ['/reservation/create'], ['class' => 'btn btn-primary']) ?>
    </p>
</div>

<style>
    .studio-view {
        position: relative;
        background-color: #f9f9f9; /* Светлый фон для страницы */
        border-radius: 8px; /* Скруглённые углы */
        padding: 20px; /* Отступы внутри страницы */
        margin: 20px; /* Отступы снаружи */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Тень */
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

    .buttons {
        position: absolute; /* Установка абсолютного позиционирования */
        bottom: 5px; /* Отступ от низа карточки */
        right: 20px; /* Отступ от правого края */
        display: flex;
        gap: 10px; /* Интервал между кнопками */
    }
</style>
