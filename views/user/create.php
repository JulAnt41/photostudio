<!-- <?php if (Yii::$app->session->hasFlash('custom')): ?>
    <div class="custom-message">
        <?= Yii::$app->session->getFlash('custom') ?>
    </div>
<?php endif; ?> -->

<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\User $model */



$this->title = 'Регистрация';
// $this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

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

    /* .custom-message {
    background: #fff8e1;
    color: #ff6f00;
    padding: 12px;
    border-radius: 4px;
    border-left: 4px solid #ffc107;
    margin: 15px 0;
}

.alert-success {
    background: #d4edda !important;
    color: #155724 !important;
    border: none !important;
    border-radius: 4px !important;
}

.custom-message {
    background: #fff8e1;
    color: #ff6f00;
    padding: 12px;
    border-radius: 4px;
    border-left: 4px solid #ffc107;
} */
</style>
