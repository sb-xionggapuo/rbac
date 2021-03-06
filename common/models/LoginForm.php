<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    const EVENT_AFTER_LOGIN = "afterLogin";
    public $username;
    public $password;
    public $rememberMe = true;
    public $verifyCode;
    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','verifyCode'], 'required'],
            ['verifyCode', 'captcha', 'captchaAction' => '/site/captcha'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
                return false;
            }
            $module = Yii::$app->controller->module->id;
            if ($module == "app-backend"){
                if ($user->identity == 1){
                    $this->addError($attribute, 'This user is customer.');
                }
            }else{
                if ($user->identity == 2){
                    $this->addError($attribute, 'This user is Administrator.');
                }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $flag = Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            $this->trigger(LoginForm::EVENT_AFTER_LOGIN);
            return $flag&&$this->_user->UpLast();
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
