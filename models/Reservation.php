<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reservation".
 *
 * @property int $id
 * @property int $id_user
 * @property int $id_studio
 * @property int $id_photographer
 * @property string $date
 * @property string $created_at
 * @property string|null $comment
 * @property int $id_status
 *
 * @property Photographer $photographer
 * @property Review[] $reviews
 * @property Status $status
 * @property Studio $studio
 * @property User $user
 */
class Reservation extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reservation';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comment'], 'default', 'value' => null],
            [['id_status'], 'default', 'value' => 1],
            [['id_user', 'id_studio', 'id_photographer', 'date'], 'required'],
            [['id_user', 'id_studio', 'id_photographer', 'id_status'], 'integer'],
            [['date', 'created_at'], 'safe'],
            [['comment'], 'string'],
            [['id_photographer'], 'exist', 'skipOnError' => true, 'targetClass' => Photographer::class, 'targetAttribute' => ['id_photographer' => 'id']],
            [['id_status'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['id_status' => 'id']],
            [['id_studio'], 'exist', 'skipOnError' => true, 'targetClass' => Studio::class, 'targetAttribute' => ['id_studio' => 'id']],
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
            'id_studio' => 'Id Studio',
            'id_photographer' => 'Id Photographer',
            'date' => 'Date',
            'created_at' => 'Created At',
            'comment' => 'Comment',
            'id_status' => 'Id Status',
        ];
    }

    /**
     * Gets query for [[Photographer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotographer()
    {
        return $this->hasOne(Photographer::class, ['id' => 'id_photographer']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_reservation' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'id_status']);
    }

    /**
     * Gets query for [[Studio]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStudio()
    {
        return $this->hasOne(Studio::class, ['id' => 'id_studio']);
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
