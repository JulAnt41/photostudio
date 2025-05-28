<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Image;

class ImageSearch extends Image
{
    public function rules()
    {
        return [
            [['id', 'id_photographer'], 'integer'],
            [['img'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Image::find();

        // Добавляем условие для фотографа
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->photographer) {
            $query->andWhere(['id_photographer' => Yii::$app->user->identity->photographer->id]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // Здесь могут быть другие условия поиска

        return $dataProvider;
    }
}
