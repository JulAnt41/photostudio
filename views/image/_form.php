<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="image-form centered-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data'],
        'enableClientValidation' => false,
    ]); ?>

    <div class="form-fields-container">
        <?= $form->field($model, 'imageFile', [
            'inputOptions' => [
                'class' => 'form-control-file',
                'style' => 'padding: 10px; border: 1px dashed rgba(107, 99, 87, 0.3); border-radius: 4px;'
            ]
        ])->fileInput(['accept' => 'image/*'])->label('Выберите изображение') ?>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-custom']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
/* Основные стили формы */
.image-form {
    padding: 30px;
    border-radius: 10px;
    margin: 20px auto;
}

/* Центрированная форма */
.centered-form {
    max-width: 600px;
}

/* Контейнер для полей формы */
.form-fields-container {
    max-width: 500px;
    margin: 0 auto;
}

/* Стили для поля загрузки файла */
.form-control-file {
    display: block;
    width: 100%;
    padding: 10px;
    transition: all 0.3s;
    background-color: #f9f9f9;
}

.form-control-file:focus {
    border-color: rgba(145, 44, 47, 0.5);
    box-shadow: 0 0 0 0.2rem rgba(145, 44, 47, 0.1);
    background-color: white;
}

/* Стили для кнопки */
.btn-custom {
    background-color: rgba(145, 44, 47, 1) !important;
    border-color: rgba(145, 44, 47, 0.8) !important;
    color: white !important;
    border-radius: 4px;
    padding: 12px 40px;
    font-weight: 500;
    transition: all 0.3s;
    font-size: 16px;
    margin-top: 20px;
}

.btn-custom:hover {
    background-color: rgba(145, 44, 47, 0.9) !important;
    transform: translateY(-3px);
    box-shadow: 0 5px 12px rgba(145, 44, 47, 0.25);
}

/* Стили для заголовков полей */
.control-label {
    font-weight: 500;
    color: rgba(54, 51, 47, 1);
    margin-bottom: 10px;
    font-size: 16px;
    display: block;
    text-align: center;
}

/* Адаптивность */
@media (max-width: 768px) {
    .image-form {
        padding: 25px 20px;
        margin: 15px 10px;
    }
    
    .form-fields-container {
        max-width: 100%;
    }
    
    .btn-custom {
        width: 100%;
        padding: 14px;
    }
}
</style>