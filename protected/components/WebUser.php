<?php
 
// this file must be stored in:
// protected/components/WebUser.php
class WebUser extends CWebUser 
{
    
    // Store model to not repeat query.
    private $model;
    
    public $user_role_id;
    // Load user model.
    protected function loadUserRole()
    {
        $session=new CHttpSession;
        $session->open();
        $this->user_role_id = $session["user_role_id"];
    }
    
    /*public function checkAccess($operation, $params=array())
    {
        //echo "id->".$this->id;exit;
        if (empty($this->id)) {
            // Not identified => no rights
            return false;
        }
        $roleID = Yii::app()->user->getState('user_role_id');
        
        if ($roleID === '1') {
            return true; // admin role has access to everything
        }
        // allow access if the operation request is the current user's role
        return ($operation === $roleID);
    }*/
    
    public function checkAccess($operation, $params=array())
    {
        if (empty($this->id)) {
            // Not identified => no rights
            return false;
        }
        $roleID = Yii::app()->user->getState('user_role_id');
        if ($roleID === '1') {
            return true; // admin role has access to everything
        }
        // allow access if the operation request is the current user's role
        return ($operation === $roleID);
         
            
    }
    
}
?>