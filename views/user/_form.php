<?php

use app\models\Sex;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\assets\AppAsset;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerCssFile('@web/css/style.css', [
    'depends' => [AppAsset::class],
]);
?>

<div class="user-form custom-registration-form">

    <?php $form = ActiveForm::begin([
        'options' => ['class' => 'registration-form'],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'inputOptions' => ['class' => 'form-control'],
            'labelOptions' => ['class' => 'form-label'],
        ],
    ]); ?>

    <?= $form->field($model, 'login')->textInput([
        'maxlength' => true,
        'class' => 'form-control input-field' // дополнительный класс
    ])->label('Логин') ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => true,
        'class' => 'form-control input-field'
    ])->label('Имя') ?>

    <?= $form->field($model, 'email')->textInput([
        'maxlength' => true,
        'class' => 'form-control input-field'
    ])->label('Почта') ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
        'mask' => '+7(999)-999-99-99',
        'options' => [
            'class' => 'form-control input-field',
            'placeholder' => '+7(___)___-__-__'
        ]
    ])->label('Телефон') ?>

    <?= $form->field($model, 'password')->passwordInput([
        'maxlength' => true,
        'class' => 'form-control input-field'
    ])->label('Пароль') ?>

    <?= $form->field($model, 'birthday')->widget(\yii\widgets\MaskedInput::class, [
        'mask' => '9999-99-99',
        'options' => [
            'class' => 'form-control',
            'placeholder' => 'гггг-мм-дд'
        ]
    ])->label('Дата рождения') ?>


    <?= $form->field($model, 'id_sex')->dropDownList(
        ArrayHelper::map(Sex::find()->all(), 'id', 'name'),
        [
            'prompt' => 'Укажите ваш пол',
            'class' => 'form-control form-control-select'
        ]
    )->label('Пол') ?>


    <div class="form-group submit-group">
        <?= Html::submitButton('Зарегистрироваться', [
            'class' => 'btn btn-submit'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>

/* Общие стили формы */
.custom-registration-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
}

/* Стили для заголовков полей */
.form-label {
    font-weight: 560;
    color: rgba(54, 51, 47, 1);
    margin-bottom: 5px;
    display: block;
    text-transform: uppercase;
    font-size: 14px;
}

/* Стили для полей ввода */
.form-control {
    border: 1px solid rgba(235, 234, 237, 1);
    border-radius: 50px;
    padding: 12px 15px;
    font-size: 16px;
    transition: all 0.3s;
    height: 45px;
}

.form-control:focus {
    border-color: rgb(209, 209, 209);
    box-shadow: 0 0 5px rgba(235, 234, 237, 1);
}

/* Стили для кнопки */
.btn-submit {
    background-color: rgba(158, 105, 58, 1) !important;
    color: white !important;
    border-radius: 50px !important;
    padding: 15px 40px !important;
    border: none !important;
    text-decoration: none !important;
    display: block; /* или inline-block */
    margin: 30px auto 0; /* auto по бокам для центрирования */
    width: fit-content; /* Ширина по содержимому */
    min-width: 250px; /* Минимальная ширина */
    letter-spacing: 1px;
    transition: background-color 0.3s ease;
    font-size: 17px;
}

.btn-submit:hover {
    background-color: rgb(126, 83, 45) !important;
    transform: translateY(-2px); /* Небольшой эффект при наведении */
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.form-control-select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='rgba(235, 234, 237, 1)' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 20px center;
    background-size: 20px;
}

</style>