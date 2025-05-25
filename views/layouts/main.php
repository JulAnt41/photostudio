<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;

AppAsset::register($this);
$this->registerCssFile('@web/css/style.css', [
    'depends' => [AppAsset::class],
]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header>
    <?php
    NavBar::begin([
        'brandLabel' => Html::img('@web/images/logo.png', ['class' => 'navbar-logo']) 
            . '<span class="navbar-brand-text">LensLounge</span>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md bg-transparent custom-navbar',
        ],
    ]);

    // Основные пункты меню (всегда посередине)
    $centerItems = [
        ['label' => 'Главная', 'url' => ['/site/index']],
        ['label' => 'Студии', 'url' => ['/studio/user-index']],
        ['label' => 'Фотографы', 'url' => ['/photographer/user-index']],
    ];
    
    // Пункты меню для авторизованных пользователей (добавляются в центр)
    if (!Yii::$app->user->isGuest) {
        if (Yii::$app->user->identity->id_role == 2) {
            $centerItems[] = ['label' => 'Админка', 'url' => ['/admin/index']];
        } else if (Yii::$app->user->identity->id_role == 1) {
            $centerItems[] = ['label' => 'Мои фотосессии', 'url' => ['/reservation/user-index']];
        } else if (Yii::$app->user->identity->id_role == 3) {
            $centerItems[] = ['label' => 'Фотограф', 'url' => ['/photographer/photographer-index']];
        }
    }

    // Правые элементы (регистрация/вход или кнопка выхода)
    $rightItems = [];
    if (Yii::$app->user->isGuest) {
        $rightItems[] = [
            'label' => 'Регистрация',
            'url' => ['/user/create'],
            'linkOptions' => ['class' => 'nav-register-link'],
        ];        
        $rightItems[] = [
            'label' => 'Вход',
            'url' => ['/site/login'],
            'linkOptions' => ['class' => 'nav-login-btn'],
        ];
    } else {
        $rightItems[] = '<li class="nav-item">'
            . Html::beginForm(['/site/logout'])
            . Html::submitButton(
                'Выйти (' . Yii::$app->user->identity->login . ')',
                ['class' => 'nav-login-btn']
            )
            . Html::endForm()
            . '</li>';
    }

    // Вывод центрированного меню
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav mx-auto'], // mx-auto для центрирования
        'items' => $centerItems,
    ]);

    // Вывод правого меню
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'], // ml-auto для выравнивания вправо
        'items' => $rightItems,
    ]);

    NavBar::end();
    ?>
</header>

<main role="main" class="flex-shrink-0">
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => $this->params['breadcrumbs'] ?? [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer class="footer mt-auto py-3">
    <div class="container">
        <p class="center footer_text">&copy; LensLounge <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<style>

header {
    background-color: transparent !important; */
    padding: 10px; /* Отступы */
    /* height: 80px; */
}

/* Стили для навбара */
.custom-navbar {
    position: relative;
}

/* Центрированные элементы */
.navbar-nav.mx-auto {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
}

/* Правые элементы */
.navbar-nav.ml-auto {
    margin-left: auto !important;
}

.navbar-logo {
    height: 35px;
    margin-right: 5px;
}

.navbar-brand-text {
    color:rgba(56, 16, 16, 1); /* Ваш цвет */
    font-weight: bold;
}

.navbar-nav .nav-link {
    color: rgba(107, 99, 87, 1); /* Цвет текста навигации */
    margin-right: 10px; /* Отступы между элементами */
}

.navbar-nav .nav-link:hover {
    color: rgba(54, 51, 47, 1); /* Цвет текста при наведении */
}

.nav-login-btn {
    background-color: rgba(145, 44, 47, 1) !important;
    color: white !important;
    border-radius: 50px !important; /* Круглая кнопка */
    padding: 8px 20px !important;
    margin-left: 15px !important;
    border: none !important;
    text-decoration: none !important;
    display: inline-block !important;
}

.nav-login-btn:hover {
    background-color: rgb(119, 37, 39) !important;
}

/* Стиль для ссылки "Регистрация" */
.nav-register-link {
    color: rgba(145, 44, 47, 1) !important;
    /* font-weight: 500 !important; */
    text-decoration: none !important;
    padding: 8px 0 !important;
    display: inline-block !important;
}

.nav-register-link:hover {
    color: rgba(56, 16, 16, 1) !important;
}

.fixed-top {
    top: 0; /* Фиксированная позиция */
    z-index: 1030; /* Прозрачность */
}

.center {
    display: flex;
    justify-content: center;
}

.footer {
    background-color: #36332F;
}

.footer_text {
    color: #CCB59F;
}

.btn-main {
    background-color: #912C2F;
    color: white;
}

.btn-main:hover {
    background-color: #702124;
    color: rgb(230, 230, 230);
}
</style>