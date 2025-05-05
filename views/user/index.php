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

    <h1><?= Html::encode($this->title) ?></h1>
<!-- 
    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-success']) ?>
    </p> -->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            // 'login',
            [
                'attribute' => 'name',
                'label' => 'Имя',
            ],
            [
                'attribute' => 'email',
                'label' => 'Почта',
            ],
            // 'email:email',
            [
                'attribute' => 'phone',
                'label' => 'Телефон',
            ],
            //'password',
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
            //'id_sex',
            //'id_role',
            [
                'class' => ActionColumn::className(),
                'template' => '{view} {delete}', // Оставляем только кнопку удаления
                'urlCreator' => function ($action, User $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
            
        ],
    ]); ?>


</div>
