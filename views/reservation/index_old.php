<?php

use app\models\Reservation;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ReservationSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Reservations';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reservation-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Reservation', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'id_user',
            'id_studio',
            'id_photographer',
            'date',
            //'created_at',
            //'price',
            //'id_payment',
            //'comment:ntext',
            //'id_status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Reservation $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
