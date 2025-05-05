<?php

use app\models\Reservation;
use app\models\Status;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\ReservationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Бронирования';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Забронировать фотосъемку', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id_user',
                'value' => 'user.name',
                'label' => 'Имя'
            ],
            [
                'attribute' => 'id_studio',
                'value' => 'studio.name',
                'label' => 'Студия'
            ],
            [
                'attribute' => 'id_photographer',
                'value' => 'photographer.user.name',
                'label' => 'Фотограф'
            ],
            // [
            //     'attribute' => 'service_id',
            //     'value' => 'service.type',
            //     'label' => 'Услуга',
            //     'filter' => ArrayHelper::map(Service::find()->all(), 'id', 'type')
            // ],
            
            [
                'attribute' => 'date',
                'label' => 'Дата фотосъемки',
                'format' => ['datetime', 'php:d.m.Y']
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата бронирования',
                'format' => ['datetime', 'php:d.m.Y']
            ],
            [
                'attribute' => 'price',
                'label' => 'Стоимость',
            ],
            [
                'attribute' => 'id_payment',
                'value' => 'payment.name',
                'label' => 'Оплата',
                'filter' => ArrayHelper::map(Payment::find()->all(), 'id', 'name')
            ],
            [
                'attribute' => 'comment',
                'label' => 'Комментарий',
            ],
            [
                'attribute' => 'id_status',
                'value' => 'status.name',
                'label' => 'Статус',
                'filter' => ArrayHelper::map(Status::find()->all(), 'id', 'name')
            ],
            //'comment:ntext',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Reservation $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
