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

<footer class="footer">
    <div class="footer-container">
        <!-- Верхний блок с контактами -->
        <div class="contacts-section">
            <h3 class="footer-title">Контакты</h3>
            <div class="contact-info">
                <p>ИП Антонова Юлианна Сергеевна</p>
                <p>ИНН 472584238787, ОГРНИП 328784704006142</p>
                
                <div class="contact-row">
                    <span class="contact-label">Номер:</span>
                    <a href="tel:+79041773838" class="contact-link">+7 904 177-38-38</a>
                </div>
                
                <div class="contact-row">
                    <span class="contact-label">E-mail:</span>
                    <a href="mailto:lenslounge@gmail.ru" class="contact-link">lenslounge@gmail.ru</a>
                </div>
                
                <p class="social-title">Мы в социальных сетях!</p>
                
                <div class="social-icons">
                    <!-- Иконка ВКонтакте -->
                    <a href="https://vk.com" target="_blank" class="social-icon vk-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22.3951 1.66071C22.3951 1.66071 22.2388 1.21429 21.2679 1.33705L18.0536 1.35938C17.808 1.32589 17.6295 1.42634 17.6295 1.42634C17.6295 1.42634 17.4397 1.52679 17.3504 1.77232C16.8259 3.12277 16.1563 4.28348 16.1563 4.28348C14.7277 6.71652 14.1473 6.85045 13.9129 6.6942C13.3661 6.34821 13.5112 5.28795 13.5112 4.52902C13.5112 2.16295 13.8683 1.1808 12.808 0.924106C12.4621 0.845981 12.2054 0.790178 11.3013 0.779018C10.1518 0.767856 9.1808 0.779018 8.63393 1.04688C8.26563 1.22545 7.98661 1.62723 8.15402 1.64955C8.36607 1.68304 8.84598 1.78348 9.10268 2.12946C9.10268 2.12946 9.3817 2.58705 9.42634 3.59152C9.54911 6.37054 8.97991 6.71652 8.97991 6.71652C8.54464 6.95089 7.78571 6.56027 6.66964 4.26116C6.66964 4.26116 6.02232 3.12277 5.52009 1.87277C5.4308 1.63839 5.25223 1.51562 5.25223 1.51562C5.25223 1.51562 5.05134 1.35938 4.76116 1.31473L1.70312 1.33705C1.23438 1.33705 1.06696 1.54911 1.06696 1.54911C1.06696 1.54911 0.899554 1.72768 1.0558 2.09598C3.4442 7.70982 6.16741 10.5223 6.16741 10.5223C6.16741 10.5223 8.65625 13.1228 11.4799 12.9442H12.7634C13.154 12.9107 13.3549 12.6987 13.3549 12.6987C13.3549 12.6987 13.5335 12.4978 13.5223 12.1295C13.5 10.4107 14.3036 10.154 14.3036 10.154C15.0848 9.90848 16.0893 11.817 17.1607 12.5536C17.1607 12.5536 17.9754 13.1116 18.5893 12.9888L21.4464 12.9442C22.9531 12.933 22.2388 11.683 22.2388 11.683C22.183 11.5826 21.8259 10.8125 20.1071 9.21652C18.3214 7.55357 18.5558 7.82143 20.721 4.94196C22.0379 3.18973 22.5625 2.1183 22.3951 1.66071Z"/>
                        </svg>
                    </a>
                    
                    <!-- Иконка Телеграма -->
                    <a href="https://telegram.org" target="_blank" class="social-icon tg-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.69 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69.03-.09.06-.17-.06-.26s-.34-.04-.49-.03c-.21.03-3.53 2.23-3.99 2.51-.37.23-.71.34-1.01.33-.33-.01-.95-.18-1.42-.33-.57-.18-1.03-.28-.99-.59.02-.17.25-.35.69-.53 2.38-1.05 3.96-1.58 6.03-2.42.83-.34 1.24-.39 1.69-.4.42-.01.83.1 1.14.3.38.25.5.43.51.45.01.02.08.1.02.31-.05.2-.2.24-.37.3z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Нижний блок с ссылками -->
        <div class="links-section">
            <div class="footer-links">
                <?= Html::a('© 2025, LensLounge', ['/site/offer'], ['class' => 'footer-link']) ?>
                <?= Html::a('Политика конфиденциальности', ['/site/privacy'], ['class' => 'footer-link']) ?>
            </div>
        </div>
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

.btn-main {
    background-color: #912C2F;
    color: white;
}

.btn-main:hover {
    background-color: #702124;
    color: rgb(230, 230, 230);
}

.footer {
    background-color: #36332F;
    color: #CCB59F;
    height: auto !important;
    padding: 40px 0 20px;
    font-family: Arial, sans-serif;
    font-size: inherit !important;
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.footer > .container {
    padding-right: 0 !important;
    padding-left: 0 !important;
}

/* Стили для блока контактов */
.contacts-section {
    text-align: center;
    margin-bottom: 30px;
}

.footer-title {
    color: rgb(219, 196, 174);
    font-size: 22px;
    margin-bottom: 20px;
    font-weight: 600;
}

.contact-info {
    line-height: 1.6;
    margin-bottom: 15px;
}

.contact-row {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 8px 0;
}

.contact-label {
    font-weight: 500;
}

.contact-link {
    color: #CCB59F;
    text-decoration: none;
    transition: color 0.3s;
}

.contact-link:hover {
    color: #fff;
    text-decoration: underline;
}

.social-title {
    margin: 20px 0 10px;
    font-weight: 500;
}

/* Стили для иконок соцсетей */
.social-icons {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 15px;
}

.social-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s;
}

.social-icon:hover {
    color: #fff;
    background-color: rgba(204, 181, 159, 0.3);
    transform: translateY(-3px);
}

/* Стиль для иконки ВКонтакте */
.vk-icon {
    background-color: rgba(204, 181, 159, 0.1);
    color: #CCB59F;
}

.vk-icon svg {
    width: 24px;
    height: 24px;
    margin-top: 10px;
}

/* Стиль для иконки Телеграма */
.tg-icon {
    background-color: rgba(204, 181, 159, 0.1);
    color: #CCB59F;
    padding: 8px; /* Чтобы иконка занимала всё пространство */
}

.tg-icon svg {
    width: 100%;
    height: 100%;
    fill: currentColor;
}

/* Стили для нижнего блока с ссылками */
.links-section {
    border-top: 1px solid rgba(204, 181, 159, 0.2);
    padding-top: 20px;
}

.footer-links {
    display: flex;
    justify-content: space-between;
    max-width: 600px;
    margin: 0 auto;
}

.footer-link {
    color: #CCB59F;
    text-decoration: none;
    font-size: 14px;
    transition: color 0.3s;
}

.footer-link:hover {
    color: #fff;
    text-decoration: underline;
}

@media (max-width: 768px) {
    .footer-links {
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }
    
    .contact-row {
        flex-direction: column;
        align-items: center;
        gap: 0;
    }
    
    .footer-title {
        font-size: 20px;
    }
}
</style>