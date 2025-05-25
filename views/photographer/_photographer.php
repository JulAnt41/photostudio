<?php
    use yii\helpers\Html;
?>

<div class="photographer">
    <div class="photo-info">
        <div class="profile-photographer">
            <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($model->img)), ['alt' => Html::encode($model->user->name)]) ?>
        </div>
        <div class="info">
            <h2><?= Html::encode($model->user->name) ?></h2>
            <p><?= Html::encode($model->specialization) ?></p>
            <h3><?= Html::encode($model->price) ?> рублей/час</h3>
        </div>
    </div>    
    
<div class="portfolio-container">
    <button class="slider-arrow prev-arrow">❮</button>
    <div class="portfolio-slider">
        <?php foreach ($model->images as $image): ?>
            <div class="portfolio-slide">
                <?= Html::img(Yii::getAlias('@web/images/' . Html::encode($image->img)), ['alt' => 'Работа']) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <button class="slider-arrow next-arrow">❯</button>
</div>
    
    <div class="buttons">
        <?= Html::a('Просмотреть', ['photographer/user-view', 'id' => $model->id], ['class' => 'photog-card-btn']) ?>
        <?php if (Yii::$app->user->isGuest): ?>
            <?= Html::a('Нанять', ['/user/create', 'message' => 'Чтобы нанять фотографа, необходимо зарегистрироваться.'],
                ['class' => 'photog-card-btn']) ?>
        <?php elseif (Yii::$app->user->identity->role == 1): ?>
            <?= Html::a('Нанять', ['/reservation/create', 'id' => $model->id], ['class' => 'photog-card-btn']) ?>
        <?php else: ?>
            <?= Html::a('Нанять', ['/user/create', 'message' => 'Только пользователи могут нанять фотографа.'], 
                ['class' => 'photog-card-btn']) ?>
        <?php endif; ?>
    </div> 
    
</div>

<style>
    .photographer {
        background-color: rgba(235, 234, 237, 1);
        border-radius: 15px;
        padding: 20px;
        margin: 15px;
        color: rgba(54, 51, 47, 1);
        display: flex;
        gap: 20px;
        flex-direction: column;
        position: relative;
    }

    .photo-info {
        display: flex;
        gap: 20px;
    }

    .profile-photographer img {
        width: auto;
        height: 105px;
        border-radius: 105px;
    }

    .photographer h2 {
        font-size: 35px;
        margin-bottom: 3px;
    }

    .photographer h3 {
        font-size: 25px;
    }

    .photographer p {
        font-size: 15px;
        color: rgb(105, 105, 105);
        margin-bottom: 15px;
    }

    .portfolio-container {
        position: relative;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .portfolio-slider {
        display: flex;
        overflow-x: auto;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch;
        scroll-snap-type: x mandatory;
        gap: 10px;
        width: 100%;
        padding: 10px 0;
    }

    .portfolio-slider::-webkit-scrollbar {
        display: none; /* Скрываем scrollbar */
    }

    .portfolio-slide {
        flex: 0 0 auto;
        scroll-snap-align: start;
    }

    .portfolio-slide img {
        width: auto;
        height: 200px;
        object-fit: cover;
    }

    .slider-arrow {
        background: rgba(158, 105, 58, 0.7);
        border: none;
        color: white;
        font-size: 20px;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s;
    }

    .slider-arrow:hover {
        background: rgba(158, 105, 58, 1);
    }

    .buttons {
        margin-top: 15px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        align-self: flex-end; /* Выравнивание по правому краю родительского контейнера */
        width: 100%; /* Занимает всю доступную ширину */
        padding-right: 20px; /* Отступ от правого края */
    }

    .photog-card-btn {
        background-color: rgba(158, 105, 58, 1) !important;
        color: white !important;
        border-radius: 50px !important;
        padding: 15px 40px !important;
        border: none !important;
        text-decoration: none !important;
        letter-spacing: 1px;
        transition: background-color 0.3s ease;
        font-size: 15px;
    }

    .photog-card-btn:hover {
        background-color: rgb(126, 83, 45) !important;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const slider = document.querySelector('.portfolio-slider');
    const prevBtn = document.querySelector('.prev-arrow');
    const nextBtn = document.querySelector('.next-arrow');
    const slides = document.querySelectorAll('.portfolio-slide');
    const slideWidth = slides[0]?.offsetWidth + 10; // 10px gap
    
    if (slides.length > 0) {
        let currentPosition = 0;
        const maxPosition = -(slides.length * slideWidth - slider.offsetWidth);
        
        prevBtn.addEventListener('click', function() {
            currentPosition = Math.min(currentPosition + slideWidth, 0);
            slider.style.transform = `translateX(${currentPosition}px)`;
        });
        
        nextBtn.addEventListener('click', function() {
            currentPosition = Math.max(currentPosition - slideWidth, maxPosition);
            slider.style.transform = `translateX(${currentPosition}px)`;
        });
    } else {
        // Если нет фотографий, скрываем стрелки
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    }
});
</script>