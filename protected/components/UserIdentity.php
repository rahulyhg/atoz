<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
         private $id;
         public function __construct($username = null,$password = null) {
             $this->username = $username;
             $this->password = $password;
             
         }
	public function authenticate()
	{
             $userArr = Yii::app()->db->createCommand()->select("user_id,first_name,last_name,mobile,role_id, password,hospital_name,company_name")->from("az_user_details t")->where(" mobile = :uname  AND is_active = 1", array(":uname" => trim($this->username) ))->queryRow();

            if ($userArr != "" && $userArr != NULL) {
		   if ($userArr['password'] !== md5($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $this->errorCode = self::ERROR_NONE;
                $this->id = $userArr['user_id'];
                $session = new CHttpSession;
                $session->open();
                $session["user_id"] = $userArr['user_id'];
                $session["user_role_id"] = $userArr['role_id'];
                $this->setState('user_role_id', $userArr['role_id']);
                $session["user_fullname"] = $userArr['first_name'] . " " . $userArr['last_name'];
                Yii::app()->user->setState("name", $userArr['first_name'] . " " . $userArr['last_name']);
                $session["mobile"] = $userArr['mobile'];
                $session["hospital_name"] = $userArr['hospital_name'];
                $session["company_name"] = $userArr['company_name'];
               // print_r($session);exit;
            }
        } else {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->id;
    }
}
