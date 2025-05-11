<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Панель фотографа';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="admin-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Фотосессии', ['photographer-view'], ['class' => 'btn btn-lg btn-main admin_btn']) ?>
    </p>

    <style>
        .admin_btn {
            width: 280px;
            font-weight: 500;
        }
    </style>

</div>
