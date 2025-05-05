<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Reservation $model */

$this->title = 'Бронирование №' . $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'Бронирования', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="reservation-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить бронирование?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'id_user',
                'value' => $model->user->name, 
                'label' => 'Имя'
            ],
            [
                'attribute' => 'id_studio',
                'value' => $model->studio->name, 
                'label' => 'Студия'
            ],
            [
                'attribute' => 'id_photographer',
                // 'value' => $model->photographer->id_user, 
                'value' => $model->photographer->user->name, 
                'label' => 'Фотограф'
            ],
            [
                'attribute' => 'date',
                'label' => 'Дата фотосъемки',
                'format' => ['datetime', 'php:d.m.Y H:i'] // Красивое форматирование даты
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата бронирования',
                'format' => ['datetime', 'php:d.m.Y H:i'] // Красивое форматирование даты
            ],
            [
                'attribute' => 'comment',
                'label' => 'Комментарий'
             ],
            // 'comment:ntext',
            [
                'attribute' => 'id_status',
                'value' => $model->status->name,
                'label' => 'Статус'
            ],
        ],
    ]) ?>

    <?php if (Yii::$app->user->identity->id_role === 2): ?>
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5>Изменение статуса</h5>
        </div>
        <div class="card-body">
            <div class="btn-group" role="group">
                
                <?= Html::a('Завершено', ['change-status', 'id' => $model->id, 'status' => 2], [ // status => 2 - Id статуса "Завершено"
                    'class' => 'btn btn-success',
                    'data' => ['method' => 'post']
                ]) ?>

                <?= Html::a('Отменено', ['change-status', 'id' => $model->id, 'status' => 3], [ 
                    'class' => 'btn btn-danger',
                    'data' => ['method' => 'post']
                ]) ?>
                
            </div>
        </div>
    </div>

    <?php endif; ?>

</div>