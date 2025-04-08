<?php

/** @var yii\web\View $this */

use app\assets\AppAsset;

$this->title = 'My Yii Application';
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
            echo '<p><a class="btn btn-lg btn-main" href="user/create">Присоединиться к нам</a></p>';
        } else if (Yii::$app->user->identity->id_role === 2) { // Проверка на админа
            echo '<p><a class="btn btn-lg btn-main" href="admin/index">Перейти в админ-панель</a></p>';
        } else { // Если не гость и не админ
            echo '<p><a class="btn btn-lg btn-main" href="reservation/index">Просмотреть мои фотосессии</a></p>';
        }
    ?>
</div>


    <!-- <div class="jumbotron text-center bg-transparent">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-outline-secondary" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div> -->
</div>
