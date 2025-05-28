<?php

use app\models\Studio;
use app\models\Photographer;
use app\models\Payment;
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Reservation $model */
/** @var yii\bootstrap4\ActiveForm $form */

$this->title = 'Бронирование фотосессии';
$this->registerCssFile('@web/css/style.css', [
    'depends' => [\yii\bootstrap4\BootstrapAsset::class],
]);
?>
<div class="reservation-form custom-reservation-form">
    <h1 class="reservation-title"><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'reservation-form',
        'options' => ['class' => 'reservation-form-fields'],
        'fieldConfig' => [
            'options' => ['class' => 'form-group'],
            'inputOptions' => ['class' => 'form-control input-field'],
            'labelOptions' => ['class' => 'form-label'],
            'errorOptions' => ['class' => 'invalid-feedback'],
        ],
    ]); ?>

        <?= $form->field($model, 'id_studio', [
            'inputOptions' => [
                'class' => 'form-control input-field form-control-select',
                'placeholder' => 'Выберите студию'
            ]
        ])->dropDownList(
            ArrayHelper::map(Studio::find()->all(), 'id', 'name'),
            ['prompt' => 'Выберите студию']
        )->label('Студия') ?>

        <?= $form->field($model, 'id_photographer', [
            'inputOptions' => [
                'class' => 'form-control input-field form-control-select',
                'placeholder' => 'Выберите фотографа'
            ]
        ])->dropDownList(
            ArrayHelper::map(Photographer::find()->all(), 'id', 'user.name'),
            ['prompt' => 'Выберите фотографа']
        )->label('Фотограф') ?>

        <?= $form->field($model, 'date')->input('date', [
            'class' => 'form-control',
            'min' => date('Y-m-d'), // минимальная дата - сегодня
        ])->label('Дата фотосъемки') ?>

        <?= $form->field($model, 'start_time')->dropDownList(
            [
                '09:00' => '09:00',
                '10:00' => '10:00',
                '11:00' => '11:00',
                '12:00' => '12:00',
                '13:00' => '13:00',
                '14:00' => '14:00',
                '15:00' => '15:00',
                '16:00' => '16:00',
                '17:00' => '17:00',
                '18:00' => '18:00',
            ],
            ['prompt' => 'Выберите время начала']
        )->label('Время начала') ?>

        <?= $form->field($model, 'hours_count')->dropDownList(
            [1 => '1 час', 2 => '2 часа', 3 => '3 часа', 4 => '4 часа'],
            ['prompt' => 'Выберите продолжительность']
        )->label('Продолжительность') ?>

        <?= $form->field($model, 'id_payment', [
            'inputOptions' => [
                'class' => 'form-control input-field form-control-select',
                'placeholder' => 'Выберите тип оплаты'
            ]
        ])->dropDownList(
            ArrayHelper::map(Payment::find()->all(), 'id', 'name'),
            ['prompt' => 'Выберите тип оплаты']
        )->label('Тип оплаты') ?>

        <?= $form->field($model, 'comment', [
            'inputOptions' => [
                'class' => 'form-control input-field',
                'placeholder' => 'Ваши комментарии и пожелания'
            ]
        ])->textarea(['rows' => 4])->label('Комментарий/пожелания') ?>

        <div class="form-group">
            <label class="control-label">Предварительная стоимость</label>
            <div id="price-calculation" style="font-size: 18px; font-weight: bold;">
                0 руб.
            </div>
        </div>

<?php
$this->registerJs(<<<JS
function calculatePrice() {
    var id_studio = $('#reservation-id_studio').val();
    var id_photographer = $('#reservation-id_photographer').val();
    var hours = $('#reservation-hours_count').val();
    
    if (!id_studio || !id_photographer || !hours) {
        $('#price-calculation').text('0 руб.');
        return;
    }
    
    $.get('/web/reservation/calculate-price', {
        id_studio: id_studio,
        id_photographer: id_photographer,
        hours: hours
    })
    .done(function(data) {
        if (data.price) {
            $('#price-calculation').text(data.price);
        } else {
            $('#price-calculation').text('Ошибка: ' + (data.error || 'неизвестная'));
        }
    })
    .fail(function() {
        $('#price-calculation').text('Ошибка сервера');
    });
}

function checkAvailability() {
    var id_studio = $('#reservation-id_studio').val();
    var id_photographer = $('#reservation-id_photographer').val();
    var date = $('#reservation-date').val();
    
    if (id_studio && id_photographer && date) {
        $.get('/web/reservation/check-availability', {
            id_studio: id_studio,
            id_photographer: id_photographer,
            date: date
        }, function(data) {
            if (data.busyTimes) {
                // Enable all options first
                $('#reservation-start_time option').prop('disabled', false);
                
                // Disable busy times
                $.each(data.busyTimes, function(index, time) {
                    $('#reservation-start_time option[value="' + time + '"]').prop('disabled', true);
                });
                
                // Reset selection if current time is now unavailable
                var selectedTime = $('#reservation-start_time').val();
                if (selectedTime && data.busyTimes.includes(selectedTime)) {
                    $('#reservation-start_time').val('');
                }
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error('Ошибка при проверке доступности: ' + textStatus);
        });
    }
}

$(document).ready(function() {
    calculatePrice();
    
    $('#reservation-id_studio, #reservation-id_photographer, #reservation-hours_count').on('change', function() {
        calculatePrice();
    });
    
    $('#reservation-date, #reservation-id_studio, #reservation-id_photographer').on('change', function() {
        checkAvailability();
    });
});
JS
); ?>

        <div class="form-group submit-group">
            <?= Html::submitButton('Забронировать', [
                'class' => 'btn btn-submit',
                'name' => 'reservation-button'
            ]) ?>
        </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
/* Общие стили формы */
.custom-reservation-form {
    max-width: 600px;
    margin: 0 auto;
    padding: 30px;
}

/* Стили для заголовка */
.reservation-title {
    text-align: center;
    color: rgba(54, 51, 47, 1);
    font-size: 39px;
    margin-bottom: 20px;
    letter-spacing: 1px;
}

/* Стили для полей формы */
.reservation-form-fields .form-control {
    border: 1px solid rgba(235, 234, 237, 1);
    border-radius: 50px;
    padding: 12px 15px;
    font-size: 16px;
    transition: all 0.3s;
    height: 45px;
}

.reservation-form-fields .form-control:focus {
    border-color: rgb(209, 209, 209);
    box-shadow: 0 0 5px rgba(235, 234, 237, 1);
}

/* Стили для текстовой области */
.reservation-form-fields textarea.form-control {
    border-radius: 20px;
    min-height: 120px;
    resize: vertical;
}

/* Стили для выпадающих списков */
.form-control-select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='rgba(235, 234, 237, 1)' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 20px center;
    background-size: 20px;
}

/* Стили для кнопки */
.btn-submit {
    background-color: rgba(158, 105, 58, 1) !important;
    color: white !important;
    border-radius: 50px !important;
    padding: 15px 40px !important;
    border: none !important;
    text-decoration: none !important;
    display: block;
    margin: 30px auto 0;
    width: fit-content;
    min-width: 250px;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    font-size: 18px;
    /* font-weight: 600;
    text-transform: uppercase; */
}

.btn-submit:hover {
    background-color: rgb(126, 83, 45) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Стили для лейблов */
.form-label {
    font-weight: 560;
    color: rgba(54, 51, 47, 1);
    margin-bottom: 5px;
    display: block;
    text-transform: uppercase;
    font-size: 14px;
    margin-left: 15px;
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