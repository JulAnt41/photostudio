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
            echo '<p><a class="btn btn-lg btn-main" href="reservation/index">Просмотреть мои фотосессии</a></p>';
        }
    ?>
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
</style>