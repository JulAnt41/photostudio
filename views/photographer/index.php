<?php

use app\models\Photographer;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PhotographerSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Фотографы';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="photographer-index">

    <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Добавить фотографа', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показано {begin}-{end} из {totalCount} элементов',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id_user',
                'value' => 'user.name',
                'label' => 'Имя'
            ],
            [
                'attribute' => 'specialization',
                'label' => 'Специализация',
            ],
            [
                'attribute' => 'price',
                'label' => 'Стоимость',
            ],
            [
                'attribute' => 'description',
                'label' => 'Описание',
            ],
            [
                'attribute' => 'img',
                'format' => 'raw',
                'value' => function($model) {
                    $imagePath = Yii::getAlias('@web/images/') . $model->img;
                    $imageExists = file_exists(Yii::getAlias('@webroot/images/') . $model->img);
                    
                    $imageContent = $imageExists 
                        ? Html::img($imagePath, [
                            'class' => 'img-thumbnail',
                            'style' => 'width: 80px; height: 80px; object-fit: cover;',
                            'alt' => $model->img,
                          ])
                        : Html::tag('span', 'Нет изображения', ['class' => 'text-muted']);
                    
                    return Html::tag('div', 
                        $imageContent . Html::tag('span', $model->img, ['class' => 'image-name']),
                        ['class' => 'image-preview-container']
                    );
                },
                'contentOptions' => ['style' => 'vertical-align: middle;'],
                'label' => 'Фото'
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Photographer $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'contentOptions' => ['style' => 'color: rgba(145, 44, 47, 1);'],
            ],
        ],
    ]); ?>


</div>

<style>

/* Основные стили админ-панели */
.photographer-index {
    /* background-color: rgba(204, 181, 159, 0.1); */
    padding: 20px;
    border-radius: 10px;
    margin: 20px;
}

.photographer-index h1 {
    color: rgba(54, 51, 47, 1);
    font-size: 32px;
    margin: 0;
    padding-bottom: 10px;
    /* border-bottom: 2px solid rgba(145, 44, 47, 0.3); */
}

/* Стили для таблицы */
.table {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
    /* box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05); */
}

.table thead th {
    background-color: rgb(143, 143, 143);
    color: rgba(54, 51, 47, 1);
    font-weight: 500;
    border: none;
}

.table tbody tr {
    transition: background-color 0.3s;
}

.table tbody tr:hover {
    background-color: rgba(204, 181, 159, 0.2);
}

.table tbody td {
    border-top: 1px solid rgba(107, 99, 87, 0.1);
    vertical-align: middle;
}

/* Стили для кнопок */
.btn-success {
    background-color: rgba(145, 44, 47, 1) !important;
    border-color: rgba(145, 44, 47, 0.8) !important;
    border-radius: 4px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-success:hover {
    background-color: rgba(145, 44, 47, 0.9) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(145, 44, 47, 0.2);
}

/* Стили для кнопок действий */
.btn-default {
    background-color: rgba(107, 99, 87, 0.1) !important;
    border: 1px solid rgba(107, 99, 87, 0.3) !important;
    color: rgba(54, 51, 47, 1) !important;
    margin: 0 3px;
    transition: all 0.2s;
}

.btn-default:hover {
    background-color: rgba(107, 99, 87, 0.2) !important;
}

/* Стили для пагинации */
.pagination > li > a {
    color: rgba(54, 51, 47, 1);
    border: 1px solid rgba(107, 99, 87, 0.3);
}

.pagination > li > a:hover {
    background-color: rgba(204, 181, 159, 0.3);
}

.pagination > .active > a {
    background-color: rgba(145, 44, 47, 1);
    border-color: rgba(145, 44, 47, 1);
}

/* Стили для фильтров */
.form-control {
    border: 1px solid rgba(107, 99, 87, 0.3);
    border-radius: 4px;
}

.form-control:focus {
    border-color: rgba(145, 44, 47, 0.5);
    box-shadow: 0 0 0 0.2rem rgba(145, 44, 47, 0.1);
}

a {
    color: rgba(54, 51, 47, 1);
}

a:hover {
    color: rgba(145, 44, 47, 1);
}

/* @media (max-width: 768px) {
    .photographer-index {
        margin: 10px;
        padding: 15px;
    }
    
    .table-responsive {
        border: none;
    }
} */
</style>