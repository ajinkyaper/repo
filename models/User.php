<?php

namespace app\models;

use Exception;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\helpers\Security;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "tbl_user".
 *
 * @property string $userid
 * @property string $username
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public $rememberMe = true;
    private $_user = false;
    public static function tableName()
    {
        return 'users';
    }
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors[] = [
            'class' => '\giannisdag\yii2CheckLoginAttempts\behaviors\LoginAttemptBehavior',

            // Amount of attempts in the given time period
            'attempts' => 3000,

            // the duration, in seconds, for a regular failure to be stored for
            // resets on new failure
            'duration' => 100,

            // the duration, in seconds, to disable login after exceeding `attemps`
            'disableDuration' => 600,

            // the attribute used as the key in the database
            // and add errors to
            'usernameAttribute' => 'username',

            // the attribute to check for errors
            'passwordAttribute' => 'password',

            // the validation message to return to `usernameAttribute`
            'message' => Yii::t('app', 'Due to multiple Invalid attempts, login has been disabled for 10 minutes.'),
        ];

        return $behaviors;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
            [['username', 'password', 'first_name', 'last_name'], 'string', 'max' => 100,],
            [['email'], 'email'],
            ['status', 'integer'],
            ['username', 'unique', 'message' => 'This username has already been taken.', 'except' => ['login']],
            ['email', 'unique', 'message' => 'This email has already been taken.', 'except' => ['login']],
            ['password', 'match', 'pattern' => '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\@\#\$\%\&\*\(\)\-\_\+\]\[\'\;\:\?\.\,\!\d]{8,16}$/', 'message' => 'Password must have Minimum 8 maximum 16 characters, at least one uppercase letter, one lowercase letter and one number.', 'except' => ['login']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userid' => 'Userid',
            'username' => 'Username',
            'password' => 'Password'
        ];
    }

    /** INCLUDE USER LOGIN VALIDATION FUNCTIONS* */

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * @inheritdoc
     */
    /* modified */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /* removed
      public static function findIdentityByAccessToken($token)
      {
      throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
      }
     */

    /**
     * Finds user by username
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param  string      $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        $expire = \Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        if ($timestamp + $expire < time()) {
            // token expired
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($attribute)
    {

        $user = $this->getUser();
        if (!$user) {
            return  $this->addError($attribute, 'Incorrect username or password.');
        }
        if (sha1($this->password) !== $user->password) {

            return $this->addError($attribute, 'Incorrect username or password.');
        }
    }


    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {

        $this->password = sha1($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
