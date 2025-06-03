<?php

namespace app\models;

use Yii;

class Review extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'review';
    }

    public function rules()
    {
        return [
            [['comment'], 'default', 'value' => null],
            [['id_user', 'id_reservation', 'rating'], 'required'],
            [['id_user', 'id_reservation', 'rating'], 'integer'],
            [['comment'], 'string'],
            [['created_at'], 'safe'],
            [['id_reservation'], 'exist', 'skipOnError' => true, 'targetClass' => Reservation::class, 'targetAttribute' => ['id_reservation' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
            [['rating'], 'in', 'range' => [1, 2, 3, 4, 5]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Пользователь',
            'id_reservation' => 'Бронирование',
            'rating' => 'Оценка',
            'comment' => 'Комментарий',
            'created_at' => 'Дата создания',
        ];
    }

    public function getReservation()
    {
        return $this->hasOne(Reservation::class, ['id' => 'id_reservation']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            // Удаляем emoji из комментария
            $this->comment = preg_replace('/[^\x{0000}-\x{FFFF}]/u', '', $this->comment);
            return true;
        }
        return false;
    }

}
