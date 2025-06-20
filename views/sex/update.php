<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Sex $model */

$this->title = 'Update Sex: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sexes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sex-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
