<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "studio".
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $description
 * @property int $price
 * @property int $dimensions
 * @property string|null $img
 *
 * @property Reservation[] $reservations
 */
class Studio extends \yii\db\ActiveRecord
{
    public $imageFile;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'studio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['img'], 'default', 'value' => null],
            [['name', 'location', 'description', 'price', 'dimensions'], 'required'],
            [['location', 'description'], 'string'],
            [['price', 'dimensions'], 'integer'],
            [['name', 'img'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, jpeg'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'location' => 'Location',
            'description' => 'Description',
            'price' => 'Price',
            'dimensions' => 'Dimensions',
            'img' => 'Img',
        ];
    }

    /**
     * Gets query for [[Reservations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservation::class, ['id_studio' => 'id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $directory = Yii::getAlias('@webroot/images/');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }
            
            $filename = 'img_'.time().'_'.Yii::$app->security->generateRandomString(6).'.'.$this->imageFile->extension;
            $path = $directory . $filename;
            
            if ($this->imageFile->saveAs($path)) {
                $this->img = $filename;
                return true;
            }
        }
        return false;
    }

}
