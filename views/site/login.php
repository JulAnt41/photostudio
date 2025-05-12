<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;

$this->title = 'Авторизация';
$this->registerCssFile('@web/css/style.css', [
    'depends' => [\yii\bootstrap4\BootstrapAsset::class],
]);
?>
<div class="site-login custom-auth-form">
    <h1 class="auth-title"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'auth-form'],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'inputOptions' => ['class' => 'form-control input-field'],
            'labelOptions' => ['class' => 'form-label'],
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'username', [
            'inputOptions' => [
                'class' => 'form-control input-field',
                'placeholder' => 'Введите ваш логин'
            ]
        ])->textInput(['autofocus' => true])->label('Логин') ?>

        <?= $form->field($model, 'password', [
            'inputOptions' => [
                'class' => 'form-control input-field',
                'placeholder' => 'Введите ваш пароль'
            ]
        ])->passwordInput()->label('Пароль') ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"custom-checkbox remember-me\">{input} {label}</div>\n<div class=\"\">{error}</div>",
        ])->label('Запомнить меня') ?>

        <div class="form-group submit-group">
            <?= Html::submitButton('Войти', [
                'class' => 'btn btn-submit',
                'name' => 'login-button'
            ]) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
.form-label {
    font-weight: 560;
    color: rgba(54, 51, 47, 1);
    margin-bottom: 5px;
    display: block;
    text-transform: uppercase;
    font-size: 14px;
}
/* Общие стили формы */
.custom-auth-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
}

/* Стили для заголовка */
.auth-title {
    text-align: center;
    color: rgba(54, 51, 47, 1);
    font-size: 42px;
    margin-bottom: 20px;
    letter-spacing: 1px;
}

/* Стили для полей формы (наследуем из формы регистрации) */
.auth-form .form-control {
    border: 1px solid rgba(235, 234, 237, 1);
    border-radius: 50px;
    padding: 12px 15px;
    font-size: 16px;
    transition: all 0.3s;
    height: 45px;
}

.auth-form .form-control:focus {
    border-color: rgb(209, 209, 209);
    box-shadow: 0 0 5px rgba(235, 234, 237, 1);
}

/* Стили для чекбокса "Запомнить меня" */
.remember-me {
    display: flex;
    align-items: center;
    margin: 20px 30px;
}

.remember-me input[type="checkbox"] {
    margin-right: 10px;
    width: 18px;
    height: 18px;
}

.remember-me label {
    margin-bottom: 0;
    font-weight: normal;
    color: rgba(54, 47, 54, 0.8);
}

/* Стили для кнопки входа */
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
    font-size: 18px;
}

.btn-submit:hover {
    background-color: rgb(126, 83, 45) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Стили для сообщений об ошибках */
.invalid-feedback {
    display: block;
    margin-top: 5px;
    color: rgba(145, 44, 47, 1);
    font-size: 14px;
    padding-left: 15px;
}
</style>