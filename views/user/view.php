<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->name;
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <!-- <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?> -->
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name',
                'label' => 'Имя'
            ],
            [
                'attribute' => 'email',
                'label' => 'Почта'
            ],
            [
                'attribute' => 'phone',
                'label' => 'Телефон'
            ],
            [
                'attribute' => 'birthday',
                'label' => 'Дата рождения',
                'format' => ['datetime', 'php:d.m.Y'] // Красивое форматирование даты
            ],
            [
                'attribute' => 'id_sex',
                'value' => $model->sex->name,
                'label' => 'Пол'
            ],
            [
                'attribute' => 'id_role',
                'value' => $model->role->name,
                'label' => 'Роль'
            ],
            //'id',
            // 'login',
            // 'password',
        ],
    ]) ?>

    <?php if (Yii::$app->user->identity->id_role === 2): ?>
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5>Изменение роли пользователя</h5>
        </div>
        <div class="card-body">
            <div class="btn-group" role="group">
                
                <?= Html::a('Пользователь', ['change-status', 'id' => $model->id, 'role' => 1], [
                    'class' => 'btn btn-success',
                    'data' => ['method' => 'post']
                ]) ?>

                <?= Html::a('Администратор', ['change-status', 'id' => $model->id, 'role' => 2], [ 
                    'class' => 'btn btn-success',
                    'data' => ['method' => 'post']
                ]) ?>

                <?= Html::a('Фотограф', ['change-status', 'id' => $model->id, 'role' => 3], [ 
                    'class' => 'btn btn-success',
                    'data' => ['method' => 'post']
                ]) ?>
                
            </div>
        </div>
    </div>

    <?php endif; ?>

</div>
