<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Studio $model */

$this->title = $model->name;
// $this->params['breadcrumbs'][] = ['label' => 'Studios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="studio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить студию?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'name',
                'label' => 'Название'
            ],
            [
                'attribute' => 'location',
                'label' => 'Местоположение'
            ],
            [
                'attribute' => 'description',
                'label' => 'Описание'
            ],
            [
                'attribute' => 'price',
                'label' => 'Стоимость, рублей/час'
            ],
            [
                'attribute' => 'dimensions',
                'label' => 'Размеры, м²'
            ],
        ],
    ]) ?>

</div>
