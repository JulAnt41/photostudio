<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Доступные Студии';
// $this->params['breadcrumbs'][] = $this->title;

?>
<div class="studio-user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_user_item',  // файл представления для одного элемента
        'layout' => "{items}\n{pager}",
    ]); ?>
</div>
