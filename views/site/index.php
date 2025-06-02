<?php

/** @var yii\web\View $this */

use app\assets\AppAsset;

$this->title = 'LensLounge - аренда фотостудий и организация фотосессий';
$this->registerCssFile('@web/css/style.css', [
    'depends' => [AppAsset::class],
]);
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Добро пожаловать в LensLounge</h1>

        <p class="lead">Аренда фотостудий и организация фотосессий для вашего вдохновения!</p>

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

</div>

<style>
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
</style>