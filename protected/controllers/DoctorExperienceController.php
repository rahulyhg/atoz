<?php

class DoctorExperienceController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
     public $layout = '//layouts/adminlayout';

    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view', 'adminDocExperience','updateAdminDoctorExp','viewDoctorExp','createDoctorExperience'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete'),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }
    public function actionViewDoctorExp($id)
    {
         $this->layout = 'adminLayout';
        try {
            $enc_key = Yii::app()->params->enc_key;
            $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        } catch (Exception $ex) {
            $model->addError(NULL, $ex->getMessage());
        }

        $this->render('view', array(
            'model' => $this->loadModel($id)
        ));
    }
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actioncreate() {
         $this->layout = 'adminlayout';
        $model = new DoctorExperience;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DoctorExperience'])) {
            $model->attributes = $_POST['DoctorExperience'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
         $this->layout = 'adminLayout';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['DoctorExperience'])) {
            $model->attributes = $_POST['DoctorExperience'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    public function actionUpdateAdminDoctorExp($id)
    {
         $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
      
        $model = $this->loadmodel($id);
       
        $doctorid = $model->doctor_id;
        $ClinicDetails = ClinicDetails::model()->findAllByAttributes(array('doctor_id' => $doctorid));
         if (isset($_POST['DoctorExperience'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $postArr = Yii::app()->request->getParam('DoctorExperience');
                //echo"<pre>";print_r($postArr);exit;
                $purifiedObj = Yii::app()->purifier;
                $model->work_from = $purifiedObj->getPurifyText($postArr['work_from']);
                $model->work_to = $purifiedObj->getPurifyText($postArr['work_to']);
//                $model->doctor_role =$purifiedObj->getPurifyText($postArr['doctor_role']);
                $model->doctor_id = $doctorid;
//                $model->ex_clinic_name = $purifiedObj->getPurifyText($postArr['ex_clinic_name']);
//                $model->city_name = $postArr['city_name'];
               
               
                if ($model->save()) {
          
                    $transaction->commit();
                  
                $this->redirect(array('viewDoctorExp', 'id' => Yii::app()->getSecurityManager()->encrypt($model->id, $enc_key)));
                }
                
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }
         $this->render('update_admin_docexp', array(
            'model' => $model,'ClinicDetails'=>$ClinicDetails,'doctorid'=>$doctorid
        )); 
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actiondelete($id) {
         $this->layout = 'adminlayout';
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionindex() {
        $dataProvider = new CActiveDataProvider('DoctorExperience');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionadmin() {
         $this->layout = 'adminLayout';
        $model = new DoctorExperience('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DoctorExperience']))
            $model->attributes = $_GET['DoctorExperience'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminDocExperience($id) {
        $this->layout = 'adminLayout';
         $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = new DoctorExperience('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['DoctorExperience']))
            $model->attributes = $_GET['DoctorExperience'];

        $this->render('admindocexp', array(
            'model' => $model,'id'=>$id
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return DoctorExperience the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = DoctorExperience::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param DoctorExperience $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'doctor-experience-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
public function actionCreateDoctorExperience($id)
{
     $this->layout = 'adminLayout';
      $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
         $model = new DoctorExperience;
       
       
        $doctorid = $id;
      //  echo $doctorid;
        if (isset($_POST['DoctorExperience'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $postArr = Yii::app()->request->getParam('DoctorExperience');
               
                $purifiedObj = Yii::app()->purifier;
                 $model->doctor_id = $doctorid;
                $model->work_from = $postArr['work_from'];
                $model->work_to = $postArr['work_to'];
//                $model->doctor_role =$purifiedObj->getPurifyText($postArr['doctor_role']);
               
//                $model->ex_clinic_name = $purifiedObj->getPurifyText($postArr['ex_clinic_name']);
//                $model->city_name = $postArr['city_name'];
               
               
                if ($model->save()) {
                  
                   // 
//                    if (!empty($_POST['clinic_Hospital_Name'])) {
//                    }
                 
                    $transaction->commit();
                  
                $this->redirect(array('viewDoctorExp', 'id' => Yii::app()->getSecurityManager()->encrypt($model->id, $enc_key)));
                }else{
                    print_r($model->getErrors());
                }
                
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }
         $this->render('CreateDoctorExperience', array(
            'model' => $model,'id'=>$id
        )); 
    
}
}
