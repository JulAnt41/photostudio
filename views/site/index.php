<?php

/** @var yii\web\View $this */

use app\assets\AppAsset;
use yii\helpers\Html;

$this->title = 'LensLounge - аренда фотостудий и организация фотосессий';
$this->registerCssFile('@web/css/style.css', [
    'depends' => [AppAsset::class],
]);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">LensLounge — пространство для идеальных кадров</h1>

        <p class="lead">Профессиональные фотостудии с безупречным светом, стильными интерьерами и полной свободой<br>
        для творчества. Арендуйте локации, доверьте нам организацию вашей фотосессии<br>
        и просто наслаждайтесь процессом.</p>

        <?php 
            // Проверка на гостя
            if (Yii::$app->user->isGuest) {
                echo '<p><a class="btn-main" href="user/create">Присоединиться к нам</a></p>';
            } else if (Yii::$app->user->identity->id_role === 2) { // Проверка на админа
                echo '<p><a class="btn btn-lg btn-main" href="admin/index">Перейти в админ-панель</a></p>';
            } else if (Yii::$app->user->identity->id_role === 3) {
                echo '<p><a class="btn btn-lg btn-main" href="photographer/photographer-index">Перейти в панель фотографа</a></p>';
            } else { // Если не гость и не админ
                echo '<p><a class="btn btn-lg btn-main" href="reservation/user-index">Просмотреть мои фотосессии</a></p>';
            }
        ?>
    </div>

    <div class="full-width-banner">
        <div class="banner-content">
            <h2>Ваша история в идеальных кадрах</h2>
            <p style="width: 670px; max-width: 100%;">
                Арендуйте студию с профессиональным светом, декорациями и услугами 
                опытного фотографа - создайте фотографии, которые расскажут вашу историю лучше слов. 
                Мы позаботимся обо всем техническом, чтобы вы могли сосредоточиться на творчестве.
            </p>
        </div>
    </div>

    <!-- Блок с отзывами -->
    <div class="reviews-section">
        <h2 class="section-title">Отзывы наших клиентов</h2>
        <div class="reviews-carousel">
            <?php
            $reviews = \app\models\Review::find()
                ->joinWith('user')
                ->joinWith('reservation')
                ->orderBy(['review.created_at' => SORT_DESC])
                ->limit(10)
                ->all();
            
            foreach ($reviews as $review): ?>
                <div class="review-item">
                    <div class="review-header">
                        <div class="user-info">
                            <span class="user-name"><?= Html::encode($review->user->name) ?></span>
                            <div class="review-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?= $i <= $review->rating ? 'filled' : '' ?>">★</span>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <span class="review-date">
                            <?= Yii::$app->formatter->asDate($review->created_at, 'php:d.m.Y') ?>
                        </span>
                    </div>
                    <div class="review-content">
                        <?= Html::encode($review->comment) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<style>
    .site-index h1 {
        margin-bottom: 25px;
    }

    .site-index .lead {
        margin-bottom: 25px;
    }

    .btn-main {
        background-color: rgba(158, 105, 58, 1) !important;
        color: white !important;
        border-radius: 50px !important; /* Круглая кнопка */
        padding: 8px 30px !important;
        margin-left: 15px !important;
        border: none !important;
        text-decoration: none !important;
        display: inline-block !important;
        font-size: 20px;
    }

    .btn-main:hover {
        background-color: rgb(126, 83, 45) !important;
    }

    .full-width-banner {
        position: relative;
        width: 100%;
        height: 700px;
        background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('<?= Yii::getAlias('@web') ?>/images/main-page.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    .banner-content {
        position: absolute;
        left: 100px;
        bottom: 100px;
        color: white; /* или другой цвет текста в зависимости от фона */
    }

    /* Стили для блока отзывов */
    .reviews-section {
        margin: 40px 0;
        padding: 60px 20px;
        background-color: rgba(204, 181, 159, 0.64);
        text-align: center;
    }
    
    .section-title {
        font-size: 32px;
        color: #36332f;
        margin-bottom: 40px;
    }
    
    .reviews-carousel {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        height: 300px; /* Фиксированная высота для плавности */
        overflow: hidden; /* Скрываем выходящие за границы элементы */
    }

    .review-item {
        background: white;
        border-radius: 10px;
        padding: 25px;
        margin: 20px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        position: absolute;
        width: calc(100% - 40px); /* Ширина с учетом margin */
        left: 20px; /* Равно margin */
        top: 0;
    }

    .review-item.active {
        opacity: 1;
        position: relative;
        left: 20px;
    }
    
    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    
    .user-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }
    
    .user-name {
        font-weight: bold;
        font-size: 18px;
        color: #36332f;
        margin-bottom: 5px;
    }
    
    .review-rating {
        margin-bottom: 10px;
    }
    
    .star {
        color: #ccc;
        font-size: 20px;
    }
    
    .star.filled {
        color: rgba(145, 44, 47, 1);
    }
    
    .review-date {
        color: #888;
        font-size: 14px;
    }
    
    .review-content {
        text-align: left;
        line-height: 1.6;
        color: #555;
    }

</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviews = document.querySelectorAll('.review-item');
    let currentIndex = 0;
    
    // Инициализация - показать первый отзыв
    if (reviews.length > 0) {
        reviews[currentIndex].classList.add('active');
    }
    
    function showNextReview() {
        // Скрываем текущий отзыв
        reviews[currentIndex].classList.remove('active');
        
        // Переходим к следующему отзыву
        currentIndex = (currentIndex + 1) % reviews.length;
        
        // Показываем новый отзыв
        reviews[currentIndex].classList.add('active');
    }
    
    // Запускаем карусель только если есть более одного отзыва
    if (reviews.length > 1) {
        setInterval(showNextReview, 5000); // Смена каждые 5 секунд
    }
});
</script>