<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Image $model */

$this->title = $model->img;
\yii\web\YiiAsset::register($this);
?>
<div class="image-view">

    <div class="header-container" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="action-buttons">
            <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы уверены, что хотите удалить фотографию из портфолио?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>

    <div class="detail-view-container">
        <?= DetailView::widget([
            'model' => $model,
            'options' => ['class' => 'table table-striped table-bordered detail-view'],
            'attributes' => [
                [
                    'attribute' => 'img',
                    'format' => 'raw',
                    'value' => function($model) {
                        $imagePath = Yii::getAlias('@web/images/') . $model->img;
                        $imageExists = file_exists(Yii::getAlias('@webroot/images/') . $model->img);
                        
                        return $imageExists 
                            ? Html::img($imagePath, [
                                'class' => 'img-preview',
                                'alt' => $model->img,
                                'style' => 'max-width: 100%; max-height: 500px; display: block; margin: 0 auto;'
                            ])
                            : Html::tag('div', 'Изображение не найдено', ['class' => 'text-danger']);
                    },
                    'label' => ' ',
                ],
                [
                    'attribute' => 'img',
                    'label' => 'Имя файла',
                ],
            ],
        ]) ?>
    </div>

</div>

<style>
/* Основные стили */
.image-view {
    padding: 20px;
    border-radius: 10px;
    margin: 20px;
    background-color: white;
}

.image-view h1 {
    color: rgba(54, 51, 47, 1);
    font-size: 32px;
    margin: 0;
}

/* Стили для кнопок */
.btn-primary {
    background-color: rgba(70, 130, 180, 1) !important;
    border-color: rgba(70, 130, 180, 0.8) !important;
    border-radius: 4px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s;
    margin-right: 10px;
}

.btn-danger {
    background-color: rgba(220, 53, 69, 1) !important;
    border-color: rgba(220, 53, 69, 0.8) !important;
    border-radius: 4px;
    padding: 8px 20px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary:hover, 
.btn-danger:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Стили для DetailView */
.detail-view {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    border-radius: 8px;
    overflow: hidden;
}

.detail-view th {
    background-color: rgb(143, 143, 143);
    color: rgba(54, 51, 47, 1);
    font-weight: 500;
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid rgba(107, 99, 87, 0.1);
}

.detail-view td {
    padding: 12px 15px;
    border-top: 1px solid rgba(107, 99, 87, 0.1);
}

.detail-view tr:nth-child(even) {
    background-color: rgba(204, 181, 159, 0.05);
}

.detail-view tr:hover {
    background-color: rgba(204, 181, 159, 0.1);
}

/* Стили для изображения */
.img-preview {
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 15px 0;
    max-height: 500px;
    width: auto;
    border: 1px solid rgba(107, 99, 87, 0.1);
}

/* Адаптивность */
@media (max-width: 768px) {
    .header-container {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .action-buttons {
        margin-top: 15px;
        display: flex;
        flex-direction: column;
        width: 100%;
    }
    
    .btn-primary {
        margin-right: 0;
        margin-bottom: 10px;
    }
    
    .img-preview {
        max-height: 300px;
    }
}
</style>