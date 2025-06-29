<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Studio $model */

$this->title = 'Добавить студию';
// $this->params['breadcrumbs'][] = ['label' => 'Studios', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="studio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

<style>
    h1 {
        text-align: center;
        color: rgba(54, 51, 47, 1); /* Цвет как у других заголовков */
        letter-spacing: 1px; /* Разрежение между буквами */
        font-size: 42px;
        margin: 0;
    }
</style>