<?php
use app\models\Reservation;
use app\models\Status;
use app\models\Payment;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Предстоящие съемки фотографа ' . Html::encode(Yii::$app->user->identity->name);
$this->registerCssFile('@web/css/style.css', [
    'depends' => [\yii\bootstrap4\BootstrapAsset::class],
]);
?>
<div class="reservation-index">

    <h1 class="page-title"><?= Html::encode($this->title) ?></h1>

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
                        <span class="info-label">Имя:</span>
                        <span class="info-value"><?= Html::encode($reservation->user->name) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Телефон:</span>
                        <span class="info-value"><?= Html::encode($reservation->user->phone) ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Почта:</span>
                        <span class="info-value"><?= Html::encode($reservation->user->email) ?></span>
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
</style>