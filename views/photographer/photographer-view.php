<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $upcomingReservations app\models\Reservation[] */

$this->title = 'Предстоящие фотосессии';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php if (!empty($upcomingReservations)): ?>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Студия</th>
                <th>Дата</th>
                <th>Цена</th>
                <th>Комментарий</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($upcomingReservations as $reservation): ?>
                <tr>
                    <td><?= Html::encode($reservation->id) ?></td>
                    <td><?= Html::encode($reservation->id_studio) ?></td>
                    <td><?= Html::encode(date('Y-m-d', strtotime($reservation->date))) ?></td>
                    <td><?= Html::encode($reservation->price) ?></td>
                    <td><?= Html::encode($reservation->comment) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>Нет предстоящих фотосессий.</p>
<?php endif; ?>
