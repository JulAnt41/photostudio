<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "photographer".
 *
 * @property int $id
 * @property int $id_user
 * @property string $specialization
 * @property int|null $price
 * @property string $description
 * @property string|null $img
 *
 * @property Image[] $images
 * @property Reservation[] $reservations
 * @property User $user
 */
class Photographer extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'photographer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['price', 'img'], 'default', 'value' => null],
            [['id_user', 'specialization', 'description'], 'required'],
            [['id_user', 'price'], 'integer'],
            [['description'], 'string'],
            [['specialization', 'img'], 'string', 'max' => 255],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'specialization' => 'Specialization',
            'price' => 'Price',
            'description' => 'Description',
            'img' => 'Img',
        ];
    }

    /**
     * Gets query for [[Images]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(Image::class, ['id_photographer' => 'id']);
    }

    /**
     * Gets query for [[Reservations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservation::class, ['id_photographer' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

}
