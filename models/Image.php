<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "image".
 *
 * @property int $id
 * @property int $id_photographer
 * @property string $img
 *
 * @property Photographer $photographer
 */
class Image extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'image';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_photographer', 'img'], 'required'],
            [['id_photographer'], 'integer'],
            [['img'], 'string', 'max' => 255],
            [['id_photographer'], 'exist', 'skipOnError' => true, 'targetClass' => Photographer::class, 'targetAttribute' => ['id_photographer' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_photographer' => 'Id Photographer',
            'img' => 'Img',
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

}
