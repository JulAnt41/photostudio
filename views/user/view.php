<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\User $model */

$this->title = $model->name;
\yii\web\YiiAsset::register($this);
?>
<div class="user-view">

    <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1><?= Html::encode($this->title) ?></h1>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этого пользователя?',
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <div class="detail-view-container">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-striped table-bordered detail-view'],
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
                    'format' => ['datetime', 'php:d.m.Y']
                ],
                [
                    'attribute' => 'id_sex',
                    'value' => $model->sex->name,
                    'label' => 'Пол'
                ],
                [
                    'attribute' => 'id_role',
                    'value' => $model->role->name,
                    'label' => 'Роль',
                    'contentOptions' => ['style' => 'font-weight: bold;']
                ],
            ],
        ]) ?>
    </div>

    <?php if (Yii::$app->user->identity->id_role === 2): ?>
    <div class="status-change-card mt-4">
        <div class="card-header">
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

<style>
/* Основные стили */
.user-view {
    padding: 20px;
    border-radius: 10px;
    margin: 20px;
    background-color: white;
}

.user-view h1 {
    color: rgba(54, 51, 47, 1);
    font-size: 32px;
    margin: 0;
}

/* Стили для кнопок */
.btn-danger {
    background-color: rgba(220, 53, 69, 1) !important;
    border-color: rgba(220, 53, 69, 0.8) !important;
    border-radius: 4px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-success {
    background-color: rgba(158, 105, 58, 1) !important;
    border-color: rgba(158, 105, 58, 0.8) !important;
    border-radius: 4px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-danger:hover,
.btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Стили для DetailView */
.detail-view {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
}

.detail-view th {
    background-color: rgb(143, 143, 143);
    color: rgba(54, 51, 47, 1);
    font-weight: 500;
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid rgba(107, 99, 87, 0.1);
}

.detail-view td {
    padding: 12px 15px;
    border-top: 1px solid rgba(107, 99, 87, 0.1);
}

.detail-view tr:nth-child(even) {
    background-color: rgba(204, 181, 159, 0.05);
}

.detail-view tr:hover {
    background-color: rgba(204, 181, 159, 0.1);
}

/* Стили для карточки изменения роли */
.status-change-card {
    background-color: rgba(242, 242, 242, 1);
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}

.status-change-card .card-header {
    background-color: rgb(160, 160, 160);
    color: rgba(54, 51, 47, 1);
    padding: 12px 15px;
    font-weight: 500;
}

.status-change-card .card-body {
    padding: 15px;
}

.btn-group .btn {
    margin-right: 10px;
    border-radius: 4px !important;
}

.btn-group .btn:last-child {
    margin-right: 0;
}

/* Адаптивность */
@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .header-container .btn {
        margin-top: 15px;
        align-self: flex-end;
    }
    
    .btn-group {
        flex-direction: column;
    }
    
    .btn-group .btn {
        margin-right: 0;
        margin-bottom: 10px;
        width: 100%;
    }
    
    .btn-group .btn:last-child {
        margin-bottom: 0;
    }
}
</style>