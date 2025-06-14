<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $login
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $birthday
 * @property int $id_sex
 * @property int $id_role
 *
 * @property Photographer[] $photographers
 * @property Reservation[] $reservations
 * @property Review[] $reviews
 * @property Role $role
 * @property Sex $sex
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_role'], 'default', 'value' => 1],
            [['login', 'name', 'email', 'phone', 'password', 'birthday', 'id_sex'], 'required', 'message' => 'Обязательное поле'],
            ['login', 'unique', 'message' => 'Этот логин уже занят.'],
            ['email', 'email', 'message' => 'Введите корректный email'],
            ['phone', 'match', 'pattern' => '/^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/', 'message' => 'Телефон должен быть в формате +7(XXX)-XXX-XX-XX.'],
            ['birthday', 'match', 'pattern' => '/^\d{4}-\d{2}-\d{2}$/', 'message' => 'Дата должна быть в формате гггг-мм-дд.'],
            ['password', 'string', 'tooShort' => 'Пароль должен содержать минимум 6 символов', 'min' => 6],
            ['name', 'match', 'pattern' => '/^[а-яА-ЯёЁ\s]+$/u', 'message' => 'Имя должно содержать только кириллицу и пробелы.'],
            [['birthday'], 'safe'],
            [['id_sex', 'id_role'], 'integer'],
            [['login', 'name', 'email', 'password'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['login'], 'unique'],
            [['id_role'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['id_role' => 'id']],
            [['id_sex'], 'exist', 'skipOnError' => true, 'targetClass' => Sex::class, 'targetAttribute' => ['id_sex' => 'id']],
        ];
    }

    public function register()
    {
        if ($this->validate()) {
            return $this->save(false);
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'password' => 'Password',
            'birthday' => 'Birthday',
            'id_sex' => 'Id Sex',
            'id_role' => 'Id Role',
        ];
    }

    /**
     * Gets query for [[Photographers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPhotographers()
    {
        return $this->hasMany(Photographer::class, ['id_user' => 'id']);
    }

    public function getPhotographer()
    {
        return $this->hasOne(Photographer::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Reservations]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReservations()
    {
        return $this->hasMany(Reservation::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::class, ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'id_role']);
    }

    /**
     * Gets query for [[Sex]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSex()
    {
        return $this->hasOne(Sex::class, ['id' => 'id_sex']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['login' => $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return null;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
        // return Yii::$app->security->validatePassword($password, $this->password);
    }

}
