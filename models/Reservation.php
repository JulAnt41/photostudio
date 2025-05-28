<?php

namespace app\models;

use Yii;

class Reservation extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'reservation';
    }

    public function rules()
    {
        return [
            [['price', 'comment'], 'default', 'value' => null],
            [['id_status'], 'default', 'value' => 1],
            [['id_user', 'id_studio', 'id_photographer', 'date', 'start_time', 'hours_count', 'id_payment'], 'required', 'message' => 'Обязательное поле'],
            [['id_user', 'id_studio', 'id_photographer', 'price', 'id_payment', 'id_status'], 'integer'],
            [['date', 'created_at'], 'safe'],
            [['comment'], 'string'],
            [['id_photographer'], 'exist', 'skipOnError' => true, 'targetClass' => Photographer::class, 'targetAttribute' => ['id_photographer' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['id_status' => 'id']],
            [['id_studio'], 'exist', 'skipOnError' => true, 'targetClass' => Studio::class, 'targetAttribute' => ['id_studio' => 'id']],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['id_user' => 'id']],
            [['id_payment'], 'exist', 'skipOnError' => true, 'targetClass' => Payment::class, 'targetAttribute' => ['id_payment' => 'id']],
            // [['hours_count'], 'integer', 'min' => 1, 'max' => 8],
            // [['date'], 'date', 'format' => 'php:Y-m-d'],
            [['start_time'], 'validateTimeSlot'],
            [['start_time', 'end_time'], 'date', 'format' => 'php:H:i'],
            ['hours_count', 'integer', 'min' => 1, 'max' => 4],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'id_studio' => 'Id Studio',
            'id_photographer' => 'Id Photographer',
            'date' => 'Date',
            'created_at' => 'Created At',
            'price' => 'Price',
            'id_payment' => 'Id Payment',
            'comment' => 'Comment',
            'id_status' => 'Id Status',
        ];
    }

    public function getPayment()
    {
        return $this->hasOne(Payment::class, ['id' => 'id_payment']);
    }

    public function getPhotographer()
    {
        return $this->hasOne(Photographer::class, ['id' => 'id_photographer']);
    }

    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_reservation' => 'id']);
    }

    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'id_status']);
    }

    public function getStudio()
    {
        return $this->hasOne(Studio::class, ['id' => 'id_studio']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'id_user']);
    }

    public function validateTimeSlot($attribute, $params)
    {
        $endTime = date('H:i', strtotime($this->start_time) + $this->hours_count * 3600);
        
        // Проверяем, что выбранное время не пересекается с существующими бронированиями
        $existingReservations = Reservation::find()
            ->where(['date' => $this->date, 'id_studio' => $this->id_studio])
            ->orWhere(['date' => $this->date, 'id_photographer' => $this->id_photographer])
            ->all();
        
        foreach ($existingReservations as $reservation) {
            $existingStart = strtotime($reservation->start_time);
            $existingEnd = strtotime($reservation->end_time);
            $newStart = strtotime($this->start_time);
            $newEnd = strtotime($endTime);
            
            if (($newStart >= $existingStart && $newStart < $existingEnd) || 
                ($newEnd > $existingStart && $newEnd <= $existingEnd) ||
                ($newStart <= $existingStart && $newEnd >= $existingEnd)) {
                $this->addError($attribute, 'Выбранное время уже занято');
                break;
            }
        }
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }
        
        // Рассчитываем стоимость
        $studio = Studio::findOne($this->id_studio);
        $photographer = Photographer::findOne($this->id_photographer);
        
        if ($studio && $photographer) {
            $this->price = ($studio->price + $photographer->price) * $this->hours_count;
        }

        // Рассчитываем конечное время (более надежный способ с DateTime)
        $start = \DateTime::createFromFormat('H:i', $this->start_time);
        if ($start) {
            $start->add(new \DateInterval('PT' . $this->hours_count . 'H'));
            $this->end_time = $start->format('H:i:s');
        } else {
            // Fallback на старый способ, если не удалось создать DateTime
            $startTimestamp = strtotime($this->start_time);
            $this->end_time = date('H:i:s', $startTimestamp + $this->hours_count * 3600);
        }
        
        return true;
    }

}
