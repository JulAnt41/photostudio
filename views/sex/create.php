<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Sex $model */

$this->title = 'Create Sex';
$this->params['breadcrumbs'][] = ['label' => 'Sexes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sex-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
