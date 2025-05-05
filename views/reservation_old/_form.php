<?php

use app\models\Studio;
use app\models\Photographer;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Reservation $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reservation-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_studio')->textInput()->dropDownList(
        ArrayHelper::map(Studio::find()->all(), 'id', 'name'),
        ['prompt' => 'Выберите студию']
    )->label('Студия') ?>

    <?= $form->field($model, 'id_photographer')->textInput()->dropDownList(
        ArrayHelper::map(Photographer::find()->all(), 'id', 'user.name'),
        ['prompt' => 'Выберите фотографа']
    )->label('Фотограф') ?>

    <?= $form->field($model, 'date')->widget(\yii\widgets\MaskedInput::class, [
    'mask' => '9999-99-99', // Маска для формата гггг-мм-дд
    ])->textInput(['placeholder' => 'гггг-мм-дд'])->label('Дата фотосъемки') ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6])->label('Комментарий/пожелания') ?>

    <div class="form-group">
        <?= Html::submitButton('Забронировать', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
