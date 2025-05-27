<?php

use app\models\User;
use app\models\Sex;
use app\models\Role;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Пользователи';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1><?= Html::encode($this->title) ?></h1>
        <!-- Если нужно добавить кнопку, раскомментируйте:
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
        -->
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => 'Показано {begin}-{end} из {totalCount} элементов',
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'label' => 'Имя',
            ],
            [
                'attribute' => 'email',
                'label' => 'Почта',
            ],
            [
                'attribute' => 'phone',
                'label' => 'Телефон',
            ],
            [
                'attribute' => 'birthday',
                'label' => 'День рождения',
                'format' => ['datetime', 'php:d.m.Y']
            ],
            [
                'attribute' => 'id_sex',
                'value' => 'sex.name',
                'label' => 'Пол',
                'filter' => ArrayHelper::map(Sex::find()->all(), 'id', 'name')
            ],
            [
                'attribute' => 'id_role',
                'value' => 'role.name',
                'label' => 'Роль',
                'filter' => ArrayHelper::map(Role::find()->all(), 'id', 'name')
            ],
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}',
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 },
                 'contentOptions' => ['style' => 'color: rgba(145, 44, 47, 1);'],
            ],
        ],
    ]); ?>

</div>

<style>
/* Основные стили админ-панели */
.user-index {
    padding: 20px;
    border-radius: 10px;
    margin: 20px;
}

.user-index h1 {
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
</style>