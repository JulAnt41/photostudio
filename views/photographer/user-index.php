<?php
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = 'Фотографы';

?>
<div class="photographers-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_photographer',
        'summary' => '', // отключаем отображение информации о количестве элементов
    ]); ?>

</div>