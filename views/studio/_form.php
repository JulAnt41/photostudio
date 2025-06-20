<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Studio $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="studio-form centered-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-fields-container">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название') ?>

        <?= $form->field($model, 'location')->textarea(['rows' => 3])->label('Местоположение') ?>

        <?= $form->field($model, 'description')->textarea(['rows' => 6])->label('Описание') ?>

        <?= $form->field($model, 'price')->textInput()->label('Стоимость, рублей/час') ?>

        <?= $form->field($model, 'dimensions')->textInput()->label('Размеры, м²') ?>
    
        <div class="form-fields-container">
            <?= $form->field($model, 'imageFile', [
                'inputOptions' => [
                    'class' => 'form-control-file',
                    'style' => 'padding: 10px; border: 1px dashed rgba(107, 99, 87, 0.3); border-radius: 4px;'
                ]
            ])->fileInput(['accept' => 'image/*'])->label('Выберите изображение') ?>
        </div>
    </div>

    <div class="form-group text-center">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-custom']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
/* Основные стили формы */
.studio-form {
    padding: 20px;
    border-radius: 10px;
    margin: 20px;
    background-color: white;
}

/* Центрированная форма */
.centered-form {
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Контейнер для полей формы */
.form-fields-container {
    max-width: 500px;
    margin: 0 auto;
}

/* Стили для полей формы */
.form-control {
    border: 1px solid rgba(107, 99, 87, 0.3);
    border-radius: 4px;
    padding: 10px 15px;
    transition: all 0.3s;
    width: 100%;
}

.form-control:focus {
    border-color: rgba(145, 44, 47, 0.5);
    box-shadow: 0 0 0 0.2rem rgba(145, 44, 47, 0.1);
}

/* Стили для выпадающего списка */
.form-control-select {
    appearance: none;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23363533' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
}

/* Стили для текстовых полей */
textarea.form-control {
    min-height: 120px;
    resize: vertical;
}

/* Стили для кнопки */
.btn-custom {
    background-color: rgba(145, 44, 47, 1) !important;
    border-color: rgba(145, 44, 47, 0.8) !important;
    color: white !important;
    border-radius: 4px;
    padding: 10px 30px;
    font-weight: 500;
    transition: all 0.3s;
    display: inline-block;
    margin-top: 20px;
    font-size: 16px;
}

.btn-custom:hover {
    background-color: rgba(145, 44, 47, 0.9) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(145, 44, 47, 0.2);
    color: white !important;
}

/* Стили для заголовков полей */
.control-label {
    font-weight: 500;
    color: rgba(54, 51, 47, 1);
    margin-bottom: 8px;
    display: block;
    font-size: 16px;
}

/* Стили для ошибок валидации */
.help-block {
    color: rgba(220, 53, 69, 1);
    font-size: 0.875em;
    margin-top: 5px;
}

/* Центрирование текста */
.text-center {
    text-align: center;
}

/* Адаптивность */
@media (max-width: 768px) {
    .studio-form {
        padding: 20px 15px;
        margin: 15px 10px;
    }
    
    .form-fields-container {
        max-width: 100%;
    }
    
    .form-control {
        padding: 10px 12px;
    }
    
    .btn-custom {
        width: 100%;
        padding: 12px;
    }
}
</style>