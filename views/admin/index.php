<?php

use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Админ-панель';
?>
<div class="admin-index centered-panel">

    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>

    <div class="admin-buttons-container">
        <?= Html::a('Бронирования', ['/reservation'], ['class' => 'btn btn-custom btn-lg']) ?>
        <?= Html::a('Пользователи', ['/user'], ['class' => 'btn btn-custom btn-lg']) ?>
        <?= Html::a('Студии', ['/studio'], ['class' => 'btn btn-custom btn-lg']) ?>
        <?= Html::a('Фотографы', ['/photographer'], ['class' => 'btn btn-custom btn-lg']) ?>
    </div>

</div>

<style>
/* Основные стили */
.admin-index {
    padding: 0 30px;
    border-radius: 10px;
    margin: 20px auto;
    max-width: 800px;
}

/* Центрирование */
.centered-panel {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
}

/* Заголовок */
.admin-index h1 {
    color: rgba(54, 51, 47, 1);
    font-size: 36px;
    margin-bottom: 30px;
    font-weight: 600;
}

/* Контейнер кнопок */
.admin-buttons-container {
    display: flex;
    flex-direction: column;
    gap: 15px;
    width: 100%;
    max-width: 300px;
}

/* Стили кнопок */
.btn-custom {
    background-color: rgba(145, 44, 47, 1) !important;
    border-color: rgba(145, 44, 47, 0.8) !important;
    color: white !important;
    border-radius: 6px;
    padding: 12px 25px;
    font-weight: 500;
    transition: all 0.3s;
    width: 100%;
    font-size: 18px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.btn-custom:hover {
    background-color: rgba(145, 44, 47, 0.9) !important;
    transform: translateY(-3px);
    box-shadow: 0 5px 12px rgba(145, 44, 47, 0.25);
    color: white !important;
}

/* Адаптивность */
@media (max-width: 768px) {
    .admin-index {
        padding: 20px 15px;
        margin: 15px 10px;
    }
    
    .admin-index h1 {
        font-size: 28px;
        margin-bottom: 25px;
    }
    
    .admin-buttons-container {
        max-width: 100%;
    }
    
    .btn-custom {
        padding: 10px 20px;
        font-size: 16px;
    }
}
</style>