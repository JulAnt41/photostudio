<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Админ-панель';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- <div class="list-group">
        <?= Html::a('Управление бронированиями', ['reservation/index'], ['class' => 'list-group-item list-group-item-action']) ?>
    </div> -->

    <p>
        <?= Html::a('Бронирования', ['/reservation'], ['class' => 'btn btn-lg btn-main admin_btn']) ?>
    </p>

    <style>
        .admin_btn {
            width: 280px;
            font-weight: 500;
        }
    </style>

</div>
