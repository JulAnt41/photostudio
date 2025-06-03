<?php
use app\models\Reservation;
use app\models\Status;
use app\models\Payment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Мои бронирования';
$this->registerCssFile('@web/css/style.css', [
    'depends' => [\yii\bootstrap4\BootstrapAsset::class],
]);
?>
<div class="reservation-index">

    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

    <div class="create-btn-container">
        <?= Html::a('Забронировать новую фотосъемку', ['create'], ['class' => 'btn-create']) ?>
    </div>

    <div class="reservations-container">
        <?php foreach ($dataProvider->getModels() as $reservation): ?>
        <div class="reservation-card">
            <div class="reservation-header">
                <h2>Бронирование #<?= $reservation->id ?></h2>
                <span class="status-badge" style="background-color: rgba(56, 16, 16, 1)">
                    <?= $reservation->status->name ?>
                </span>
            </div>
            
            <div class="reservation-body">
                <div class="reservation-info">
                    <div class="info-row">
                        <span class="info-label">Фотограф:</span>
                        <span class="info-value"><?= Html::encode($reservation->photographer->user->name) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Студия:</span>
                        <span class="info-value"><?= Html::encode($reservation->studio->name) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Дата съемки:</span>
                        <span class="info-value"><?= Yii::$app->formatter->asDate($reservation->date, 'php:d.m.Y') ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Время:</span>
                        <span class="info-value">
                            <?= Yii::$app->formatter->asTime($reservation->start_time, 'HH:mm') . ' - ' . 
                            Yii::$app->formatter->asTime($reservation->end_time, 'HH:mm') ?>
                        </span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Стоимость:</span>
                        <span class="info-value"><?= number_format($reservation->price, 0, '', ' ') ?> ₽</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Способ оплаты:</span>
                        <span class="info-value"><?= Html::encode($reservation->payment->name) ?></span>
                    </div>
                    <?php if (!empty($reservation->comment)): ?>
                    <div class="info-row">
                        <span class="info-label">Комментарий:</span>
                        <span class="info-value"><?= Html::encode($reservation->comment) ?></span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="reservation-footer">
                <span class="created-at">
                    Забронировано: <?= Yii::$app->formatter->asDate($reservation->created_at, 'php:d.m.Y') ?>
                </span>
            </div>
            
            <?php if ($reservation->id_status == 2): // Проверяем статус "Завершено" ?>
                <div class="review-section">
                    <?php 
                    $existingReview = \app\models\Review::find()
                        ->where(['id_reservation' => $reservation->id])
                        ->one();
                    
                    if ($existingReview): ?>
                        <div class="existing-review">
                            <h3>Ваш отзыв</h3>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= $i <= $existingReview->rating ? 'filled' : '' ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <p class="review-comment"><?= Html::encode($existingReview->comment) ?></p>
                            <p class="review-date">Оставлен: <?= Yii::$app->formatter->asDate($existingReview->created_at, 'php:d.m.Y') ?></p>
                        </div>
                    <?php else: ?>
                        <div class="review-form-container">
                            <h3>Оставить отзыв</h3>
                            <?php $form = \yii\widgets\ActiveForm::begin([
                                'action' => ['/review/create'],
                                'options' => ['class' => 'review-form'],
                            ]); ?>
                            
                            <?= $form->field($reviewModel, 'id_reservation')->hiddenInput(['value' => $reservation->id])->label(false) ?>
                            
                            <div class="form-group">
                                <!-- <label>Оценка</label> -->
                                <div class="rating-stars">
                                    <?php for ($i = 5; $i >= 1; $i--): ?>
                                        <input type="radio" id="star<?= $i ?>-<?= $reservation->id ?>" name="Review[rating]" value="<?= $i ?>" <?= $i == 5 ? 'checked' : '' ?>>
                                        <label for="star<?= $i ?>-<?= $reservation->id ?>">★</label>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            
                            <?= $form->field($reviewModel, 'comment')->textarea(['rows' => 4, 'placeholder' => 'Ваш отзыв...'])->label(false) ?>
                            
                            <div class="form-group">
                                <?= Html::submitButton('Отправить отзыв', ['class' => 'btn-submit-review']) ?>
                            </div>
                            
                            <?php \yii\widgets\ActiveForm::end(); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.page-title {
    font-size: 32px;
    color: rgba(54, 51, 47, 1);
    margin-bottom: 30px;
    text-align: center;
}

.reservations-container {
    display: flex;
    flex-direction: column;
    gap: 20px;
    max-width: 1200px;
    margin: 0 auto;
}

.reservation-card {
    background-color: rgba(235, 234, 237, 1);
    border-radius: 15px;
    padding: 25px;
    color: rgba(54, 51, 47, 1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.reservation-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0,0,0,0.1);
}

.reservation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid rgba(0,0,0,0.1);
}

.reservation-header h2 {
    font-size: 24px;
    margin: 0;
    color: rgba(54, 51, 47, 1);
}

.status-badge {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 500;
    color: white;
}

.info-row {
    display: flex;
    margin-bottom: 12px;
}

.info-label {
    font-weight: 600;
    color: rgba(54, 51, 47, 0.8);
    width: 150px;
    flex-shrink: 0;
}

.info-value {
    color: rgba(54, 51, 47, 1);
}

.reservation-footer {
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid rgba(0,0,0,0.1);
    font-size: 14px;
    color: rgba(54, 51, 47, 0.6);
}

.btn-create {
    background-color: rgba(158, 105, 58, 1) !important;
    color: white !important;
    border-radius: 50px !important;
    padding: 12px 30px !important;
    border: none !important;
    text-decoration: none !important;
    font-size: 16px;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 30px;
    transition: all 0.3s ease;
}

.btn-create:hover {
    background-color: rgb(126, 83, 45) !important;
    box-shadow: 0 4px 12px rgba(158, 105, 58, 0.3);
}

.create-btn-container {
    text-align: center;
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .info-row {
        flex-direction: column;
    }
    
    .info-label {
        width: 100%;
        margin-bottom: 5px;
    }
    
    .reservation-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}

/* Отзывы */

.review-section {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid rgba(0,0,0,0.1);
}

.review-section h3 {
    font-size: 18px;
    margin-bottom: 15px;
    color: rgba(54, 51, 47, 1);
}

.review-form textarea {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid rgba(0,0,0,0.1);
    margin-bottom: 15px;
    color: rgba(54, 51, 47, 1);
}

.btn-submit-review {
    background-color: rgba(158, 105, 58, 1);
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 50px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
}

.btn-submit-review:hover {
    background-color: rgb(126, 83, 45);
}

.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
    margin-bottom: 15px;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    font-size: 24px;
    color: #ccc;
    cursor: pointer;
    padding: 0 5px;
}

.rating-stars input:checked ~ label,
.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: rgba(145, 44, 47, 1);
}

.existing-review {
    background-color: rgb(248, 248, 248);
    padding: 15px;
    border-radius: 8px;
}

.review-rating {
    margin-bottom: 10px;
}

.review-rating .star {
    font-size: 20px;
    color: #ccc;
}

.review-rating .star.filled {
    color: rgba(145, 44, 47, 1);
}

.review-comment {
    margin-bottom: 5px;
    line-height: 1.5;
}

.review-date {
    font-size: 12px;
    color: rgba(54, 51, 47, 0.6);
}

.form-control:focus {
    border-color: rgba(145, 44, 47, 0.5);
}

label {
    display: inline-block;
    margin-bottom: 0;
}
</style>