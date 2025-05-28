<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "image".
 */
class Image extends \yii\db\ActiveRecord
{
    public $imageFile; // Виртуальное свойство для загрузки файла

    public static function tableName()
    {
        return 'image';
    }

public function rules()
{
    return [
        [['id_photographer'], 'required'],
        [['id_photographer'], 'integer'],
        [['img'], 'string', 'max' => 255],
        [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],
    ];
}

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Фотография',
            'id_photographer' => 'Фотограф',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $filename = 'img_'.time().'_'.Yii::$app->security->generateRandomString(6).'.'.$this->imageFile->extension;
            $path = Yii::getAlias('@webroot/images/'.$filename);
            
            if ($this->imageFile->saveAs($path)) {
                $this->img = $filename;
                return true;
            }
        }
        return false;
    }
}