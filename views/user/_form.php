<?php

use app\models\Sex;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'login')->textInput(['maxlength' => true])->label('Логин') ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Имя') ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true])->label('Почта') ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '+7(999)-999-99-99',
    ])->textInput(['maxlength' => true])->label('Телефон') ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => true])->label('Пароль') ?>

    <?= $form->field($model, 'birthday')->widget(\yii\widgets\MaskedInput::class, [
    'mask' => '9999-99-99', // Маска для формата гггг-мм-дд
    ])->textInput(['placeholder' => 'гггг-мм-дд'])->label('Дата рождения') ?>

    <?= $form->field($model, 'id_sex')->textInput()->dropDownList(
        ArrayHelper::map(Sex::find()->all(), 'id', 'name'),
        ['prompt' => 'Укажите ваш пол']
    )->label('Пол') ?>

    <div class="form-group">
        <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
