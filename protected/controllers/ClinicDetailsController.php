<?php

class ClinicDetailsController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/adminLayout';

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
                'actions' => array('index', 'view', 'adminClinic', 'updateAdminClinic', 'viewClinic', 'createClinic'),
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
        $this->layout = 'adminLayout';
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    public function actionviewClinic($id) {
        $this->layout = 'adminLayout';
         $enc_key = Yii::app()->params->enc_key;
         
         //  $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
         
            $clinicid = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = $this->loadmodel($clinicid);
        $clinicVisitingDetails = ClinicVisitingDetails::model()->findAllByAttributes(array('clinic_id' => $clinicid));
        if(empty($clinicVisitingDetails)){
            
          $clinicVisitingDetails[] = new ClinicVisitingDetails;
      }
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('clinic_id' => $clinicid));
        if(empty($serviceUserMapping)){
          $serviceUserMapping[] = new ServiceUserMapping;
      }
        
        
//        try {
//           
//        } catch (Exception $ex) {
//            $model->addError(NULL, $ex->getMessage());
//        }

        $this->render('viewClinic', array(
            'model' => $model, 'clinicVisitingDetails' => $clinicVisitingDetails, 'serviceUserMapping' => $serviceUserMapping,'id'=>$clinicid));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actioncreate() {
        $this->layout = 'adminLayout';
        $model = new ClinicDetails;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ClinicDetails'])) {
            $model->attributes = $_POST['ClinicDetails'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->clinic_id));
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
    public function actionupdate($id) {
        $this->layout = 'adminLayout';
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['ClinicDetails'])) {
            $model->attributes = $_POST['ClinicDetails'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->clinic_id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actiondelete($id) {
        $this->layout = 'adminLayout';
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $this->layout = 'adminLayout';
        $dataProvider = new CActiveDataProvider('ClinicDetails');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionadmin() {
        $this->layout = 'adminLayout';
        $model = new ClinicDetails('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ClinicDetails']))
            $model->attributes = $_GET['ClinicDetails'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionAdminClinic($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);

        $model = new ClinicDetails('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['ClinicDetails']))
            $model->attributes = $_GET['ClinicDetails'];
        $this->render('adminClinic', array(
            'model' => $model, 'id' => $id
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return ClinicDetails the loaded model
     * @throws CHttpException
     */
    public function actionUpdateAdminClinic($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $clinicid = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = $this->loadmodel($clinicid);
        $clinicVisitingDetails = ClinicVisitingDetails::model()->findAllByAttributes(array('clinic_id' => $clinicid));
        if(empty($clinicVisitingDetails)){
            
          $clinicVisitingDetails[] = new ClinicVisitingDetails;
      }
        $serviceUserMapping = ServiceUserMapping::model()->findAllByAttributes(array('clinic_id' => $clinicid));
        if(empty($serviceUserMapping)){
          $serviceUserMapping[] = new ServiceUserMapping;
      }
  
        $doctorid = $model->doctor_id;
  
          $paymentstr="";
        $freedays="";
//        echo '<pre>';
//        print_r($_POST);exit;
        if (isset($_POST['ClinicDetails'])) {

            try {
                $transaction = Yii::app()->db->beginTransaction();
                $postArr = Yii::app()->request->getParam('ClinicDetails');
                //echo"<pre>";print_r($postArr);exit;
                $purifiedObj = Yii::app()->purifier;
                $clinicReg = CUploadedFile::getInstance($model, 'clinic_reg_certificate');
                $model->clinic_name = $purifiedObj->getPurifyText($postArr['clinic_name']);
                $model->register_no = $postArr['register_no'];
                $model->opd_consultation_fee = $postArr['opd_consultation_fee'];
               // $model->opd_consultation_discount = $postArr['opd_consultation_discount'];
                $model->free_opd_perday = $postArr['free_opd_perday'];
                if(!empty($postArr['alldayopen']))
                $model->alldayopen = "Y";
                $model->landmark = $postArr['landmark'];
                $model->address = $postArr['address'];
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
                $model->country_id = 1;
                $model->state_id = $postArr['state_id'];
                $model->city_id = $postArr['city_id'];
                $model->area_id = $postArr['area_id'];
                $model->pincode = $postArr['pincode'];
                $model->country_name = "india";
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->doctor_id = $doctorid;
                   if(!empty($postArr['payment_type']))
               {
                    foreach ($postArr['payment_type'] as $key => $value) {
                           $paymentstr.=$value . ",";
                    }
                     $model->payment_type = $paymentstr;
               }
                      if(!empty($postArr['free_opd_preferdays']))
               {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                           $freedays.=$value . ",";
                    }
                     $model->free_opd_preferdays = $freedays;
               }
                $baseDir = Yii::app()->basePath . "/../uploads/";
               if (!empty($clinicReg)) {
                    $clinicDir = 'certificates/';                               //certificates
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicDir = $clinicDir . date("Y") . "/";                  //year
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicDir = $clinicDir . date("M") . "/";                  //month
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicdoc = CUploadedFile::getInstance($model, 'clinic_reg_certificate');
                $path_part = pathinfo($clinicdoc->name);
                    $cname = $clinicDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                   
                 if ($clinicReg->saveAs($baseDir . $cname)) {
                        $model->clinic_reg_certificate = $cname;

                        if (file_exists($baseDir . $clinicReg)) {
                            
                        }
                        
                    } else {
                        $model->clinic_reg_certificate = $clinicReg;
                    }
                
               }
                if ($model->save()) {
                   
                   
                    Yii::app()->db->createCommand()->delete('az_service_user_mapping', 'clinic_id=:id AND is_clinic=:noDelete', array(':id' => $clinicid, ':noDelete' => '1'));


                    if (!empty($postArr['service'])) {
                      
                        foreach ($postArr['service'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $doctorid;
                            $serviceUserMappingobj->clinic_id = $clinicid;
                            $serviceUserMappingobj->service_discount = $postArr['service_discount'][$key];
                            $serviceUserMappingobj->corporate_discount = $postArr['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $postArr['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 1;
                            if (!$serviceUserMappingobj->save()) {
                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                    Yii::app()->db->createCommand()->delete('az_clinic_visiting_details', 'clinic_id=:id', array(':id' => $clinicid));

                     if (isset($_POST['ClinicVisitingDetails'])) {
                        
                         $selecteddays = $_POST['ClinicVisitingDetails'];

                                foreach ($selecteddays['day'] as $key => $value) {

                            $ClinicVisitingDetailsobj = new ClinicVisitingDetails;
                            $ClinicVisitingDetailsobj->clinic_id = $clinicid;
                            $ClinicVisitingDetailsobj->doctor_id = $doctorid;
                            $ClinicVisitingDetailsobj->day = $value;
                            $ClinicVisitingDetailsobj->clinic_open_time = (!empty($selecteddays['clinic_open_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key])) : NULL;
                            $ClinicVisitingDetailsobj->clinic_close_time = (!empty($selecteddays['clinic_close_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key])) : NULL;
                            $ClinicVisitingDetailsobj->clinic_eve_open_time =(!empty($selecteddays['clinic_eve_open_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key])) : NULL;
                            $ClinicVisitingDetailsobj->clinic_eve_close_time = (!empty($selecteddays['clinic_eve_close_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key])) : NULL;

                            if (!$ClinicVisitingDetailsobj->save()) {
                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                    $transaction->commit();

                    $this->redirect(array('viewClinic', 'id' => Yii::app()->getSecurityManager()->encrypt($model->clinic_id, $enc_key)));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }

        $this->render('update_admin_clinic', array(
            'model' => $model, 'clinicVisitingDetails' => $clinicVisitingDetails, 'serviceUserMapping' => $serviceUserMapping,'id'=>$clinicid));
    }

    public function loadModel($id) {
        $model = ClinicDetails::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param ClinicDetails $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'clinic-details-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionCreateClinic($id) {
        $this->layout = 'adminLayout';
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = new ClinicDetails;
        $doctorid = $id;
        $paymentstr="";
        $freedays="";
        if (isset($_POST['ClinicDetails'])) {
            $transaction = Yii::app()->db->beginTransaction();
            try {
                
                $postArr = Yii::app()->request->getParam('ClinicDetails');
                $purifiedObj = Yii::app()->purifier;
               // echo"<pre>";print_r($postArr);exit;
                $model->clinic_name = $purifiedObj->getPurifyText($postArr['clinic_name']);
                 $model->register_no = $postArr['register_no'];
                $model->opd_consultation_fee = $postArr['opd_consultation_fee'];
                $model->opd_consultation_discount = $postArr['opd_consultation_discount'];
                $model->free_opd_perday = $postArr['free_opd_perday'];
                if(!empty($postArr['alldayopen']))
                    $model->alldayopen = "Y";
                $model->landmark = $postArr['landmark'];
                $model->address = $postArr['address'];
                $model->latitude = $postArr['latitude'];
                $model->longitude = $postArr['longitude'];
               
                $model->country_id = 1;
                $model->state_id = $postArr['state_id'];
                $model->city_id = $postArr['city_id'];
                $model->area_id = $postArr['area_id'];
                $model->pincode = $postArr['pincode'];
                $model->country_name = "india";
                $model->state_name = $purifiedObj->getPurifyText($postArr['state_name']);
                $model->city_name = $purifiedObj->getPurifyText($postArr['city_name']);
                $model->area_name = $purifiedObj->getPurifyText($postArr['area_name']);
                $model->doctor_id = $doctorid;
                    if(!empty($postArr['payment_type']))
               {
                    foreach ($postArr['payment_type'] as $key => $value) {
                           $paymentstr.=$value . ",";
                    }
                     $model->payment_type = $paymentstr;
               }
                    if(!empty($postArr['free_opd_preferdays']))
               {
                    foreach ($postArr['free_opd_preferdays'] as $key => $value) {
                           $freedays.=$value . ",";
                    }
                     $model->free_opd_preferdays = $freedays;
               }
                  $baseDir = Yii::app()->basePath . "/../uploads/";
                $clinicDir = 'certificates/';                               //certificates
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicDir = $clinicDir . date("Y") . "/";                  //year
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicDir = $clinicDir . date("M") . "/";                  //month
                if (!is_dir($baseDir . $clinicDir)) {
                    mkdir($baseDir . $clinicDir);
                }
                $clinicdoc = CUploadedFile::getInstance($model, 'clinic_reg_certificate');
                if (!empty($clinicdoc)) {
                    $path_part = pathinfo($clinicdoc->name);
                    $cname = $clinicDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                    $model->clinic_reg_certificate = $cname;
                    $clinicdoc->saveAs($baseDir . $model->clinic_reg_certificate);
                }

                if ($model->save()) {
                    $clinicid = $model->clinic_id;
                    if (!empty($postArr['service'])) {

                        foreach ($postArr['service'] as $key => $value) {
                            //$model->service_id = $purifiedObj->getPurifyText($key);

                            $serviceUserMappingobj = new ServiceUserMapping();
                            $serviceUserMappingobj->service_id = $purifiedObj->getPurifyText($value);
                            $serviceUserMappingobj->user_id = $clinicid;
                            $serviceUserMappingobj->service_discount = $postArr['service_discount'][$key];
                            $serviceUserMappingobj->corporate_discount = $postArr['corporate_discount'][$key];
                            $serviceUserMappingobj->is_available_allday = $postArr['twentyfour'][$key];
                            $serviceUserMappingobj->is_clinic = 1;
                            if (!$serviceUserMappingobj->save()) {
                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                   if (isset($_POST['ClinicVisitingDetails'])) {
                        
                         $selecteddays = $_POST['ClinicVisitingDetails'];

                                foreach ($selecteddays['day'] as $key => $value) {
                            $ClinicVisitingDetailsobj = new ClinicVisitingDetails;
                            $ClinicVisitingDetailsobj->clinic_id = $clinicid;
                            $ClinicVisitingDetailsobj->doctor_id = $doctorid;
                            $ClinicVisitingDetailsobj->day = $value;
                            $ClinicVisitingDetailsobj->clinic_open_time = (!empty($selecteddays['clinic_open_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_open_time'][$key])) : NULL;
                            $ClinicVisitingDetailsobj->clinic_close_time = (!empty($selecteddays['clinic_close_time'][$key])) ? date('H:i:s', strtotime($selecteddays['clinic_close_time'][$key])) : NULL;
                            $ClinicVisitingDetailsobj->clinic_eve_open_time =(!empty($selecteddays['clinic_eve_open_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_open_time'][$key])) : NULL;
                            $ClinicVisitingDetailsobj->clinic_eve_close_time = (!empty($selecteddays['clinic_eve_close_time'][$key])) ?  date('H:i:s', strtotime($selecteddays['clinic_eve_close_time'][$key])) : NULL;

                            if (!$ClinicVisitingDetailsobj->save()) {
                                throw new Exception("Error in saving data");
                            }
                        }
                    }

                    $transaction->commit();

                    $this->redirect(array('viewClinic', 'id' => Yii::app()->getSecurityManager()->encrypt($model->clinic_id, $enc_key)));
                }
            } catch (Exception $ex) {
                $transaction->rollback();
                $model->addError(NULL, $ex->getMessage());
            }
        }

        $this->render('CreateClinic', array(
            'model' => $model, 'id' => $id
        ));
    }

}
