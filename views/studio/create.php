<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Studio $model */

$this->title = 'Create Studio';
$this->params['breadcrumbs'][] = ['label' => 'Studios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="studio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
