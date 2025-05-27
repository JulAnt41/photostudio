<?php

use app\models\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ImageSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Ваше портфолио';
?>
<div class="image-index">

    <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Добавить фотографию', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показано {begin}-{end} из {totalCount} элементов',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
                'label' => 'Изображение'
            ],
            [
                'class' => ActionColumn::className(),
                'header' => 'Действия',
                'template' => '{view} {update} {delete}',
                'urlCreator' => function ($action, Image $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
                'contentOptions' => ['style' => 'color: rgba(145, 44, 47, 1);'],
            ],
        ],
        'tableOptions' => ['class' => 'table table-striped table-bordered'],
        'pager' => [
            'options' => ['class' => 'pagination justify-content-center'],
            'linkOptions' => ['class' => 'page-link'],
        ],
    ]); ?>

</div>

<style>
/* Основные стили админ-панели */
.image-index {
    padding: 20px;
    border-radius: 10px;
    margin: 20px;
}

.image-index h1 {
    color: rgba(54, 51, 47, 1);
    font-size: 32px;
    margin: 0;
    padding-bottom: 10px;
}

/* Стили для таблицы */
.table {
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
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

/* Стили для изображений */
.image-preview-container {
    display: flex;
    align-items: center;
    gap: 15px;
}

.image-name {
    font-size: 14px;
    word-break: break-all;
    color: rgba(54, 51, 47, 1);
}

.img-thumbnail {
    border-radius: 4px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.2s;
    border: 1px solid rgba(107, 99, 87, 0.1);
}

.img-thumbnail:hover {
    transform: scale(1.05);
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
    color: white;
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
</style>