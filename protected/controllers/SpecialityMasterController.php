<?php

class SpecialityMasterController extends Controller {

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
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update', 'activeStatus', 'admin'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('delete'),
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
    public function actionview($id) {
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actioncreate() { //adding speciality of doctor
        $enc_key = Yii::app()->params->enc_key;
        $model = new SpecialityMaster;
        $comFuncObj = new CommonFunction();
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['SpecialityMaster'])) {
            try {
                $model->attributes = $_POST['SpecialityMaster'];
                $baseDir = Yii::app()->basePath . "/../uploads/";
//            echo $model->img_name;
//            echo "<br>";
//            echo $model->speciality_name;
//            exit;
                if (!is_dir($baseDir)) {
                    mkdir($baseDir);
                }
                $specialityDir = 'speciality/';               //speciality
                if (!is_dir($baseDir . $specialityDir)) {
                    mkdir($baseDir . $specialityDir);
                }
                $specialityDir = $specialityDir . date("Y") . "/";         //year
                if (!is_dir($baseDir . $specialityDir)) {
                    mkdir($baseDir . $specialityDir);
                }
                $specialityDir = $specialityDir . date("M") . "/";         //month
                if (!is_dir($baseDir . $specialityDir)) {
                    mkdir($baseDir . $specialityDir);
                }
                $imagethumb = $specialityDir;
                $specialityDir = $specialityDir . 'main' . "/";         //month
                if (!is_dir($baseDir . $specialityDir)) {
                    mkdir($baseDir . $specialityDir);
                }
                $imagethumbDir = $imagethumb . 'thumbnail' . "/"; {
                    if (!is_dir($baseDir . $imagethumbDir)) {
                        mkdir($baseDir . $imagethumbDir);
                    }
                }

                $filename = CUploadedFile::getInstanceByName("SpecialityMaster[img_name]");

                if (!empty($filename)) {
                    $path_part = pathinfo($filename->name);

                    $fname = $specialityDir . time() . "_" . rand(1111, 9999) . "." . $path_part['extension'];
                    if ($filename->saveAs($baseDir . $fname)) {

                        $image = Yii::app()->image->load($baseDir . $fname);
                        $image->resize(200, 400);
                        $thumbnailName = $imagethumbDir . time() . "_" . rand(1111, 9999) . "." . $path_part['extension'];
                        $model->img_name = $thumbnailName;

                        $image->save($baseDir . $thumbnailName);
                    }
                }
                if ($model->save()) {
                    $this->redirect(array('view', 'id' => Yii::app()->getSecurityManager()->encrypt($model->speciality_id, $enc_key)));
                }
                $comFuncObj->refresh_cache();
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
            }
        }

        //$result = Yii::app()->cache->get('specialitycache');

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
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $enc_key = Yii::app()->params->enc_key;
        $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
        $model = $this->loadModel($id);

        $oldimg = $model->img_name;
        if (isset($_POST['SpecialityMaster'])) {
            try {
                $model->attributes = $_POST['SpecialityMaster'];
                $filename = CUploadedFile::getInstanceByName("SpecialityMaster[img_name]");
               
                if (!empty($filename)) {
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $specialityDir = 'speciality/';               //speciality
                    if (!is_dir($baseDir . $specialityDir)) {
                        mkdir($baseDir . $specialityDir);
                    }
                    $specialityDir = $specialityDir . date("Y") . "/";         //year
                    if (!is_dir($baseDir . $specialityDir)) {
                        mkdir($baseDir . $specialityDir);
                    }
                    $specialityDir = $specialityDir . date("M") . "/";         //month
                    if (!is_dir($baseDir . $specialityDir)) {
                        mkdir($baseDir . $specialityDir);
                    }
                    $imagethumb = $specialityDir;
                    $specialityDir = $specialityDir . 'main' . "/";         //month
                    if (!is_dir($baseDir . $specialityDir)) {
                        mkdir($baseDir . $specialityDir);
                    }
                    $imagethumbDir = $imagethumb . 'thumbnail' . "/"; {
                        if (!is_dir($baseDir . $imagethumbDir)) {
                            mkdir($baseDir . $imagethumbDir);
                        }
                    }

                    $path_part = pathinfo($filename->name);

                    $fname = $specialityDir . time() . "_" . rand(1111, 9999) . "." . $path_part['extension'];

                    if ($filename->saveAs($baseDir . $fname)) {
                        $image = Yii::app()->image->load($baseDir . $fname);
                        $image->resize(200, 400);
                        $thumbnailName = $imagethumbDir . time() . "_" . rand(1111, 9999) . "." . $path_part['extension'];
                        $model->img_name = $thumbnailName;
                        $image->save($baseDir . $thumbnailName);
                    }
                }else {
                    
                    $model->img_name = $oldimg;
                }
                
                if($model->validate()){
                    
                    if ($model->save()){ //echo"<pre>";print_r($model); exit;
                        $this->redirect(array('view', 'id' => Yii::app()->getSecurityManager()->encrypt($model->speciality_id, $enc_key)));
                    }
                }
            } catch (Exception $e) {
                $model->addError(NULL, $e->getMessage());
            }
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
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionindex() {
        $dataProvider = new CActiveDataProvider('SpecialityMaster');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionadmin() {
        $model = new SpecialityMaster('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['SpecialityMaster']))
            $model->attributes = $_GET['SpecialityMaster'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return SpecialityMaster the loaded model
     * @throws CHttpException
     */
    public function loadModel($id) {
        $model = SpecialityMaster::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param SpecialityMaster $model the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'speciality-master-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionActiveStatus() {
        $update = Yii::app()->db->createCommand()->update('az_speciality_master', array('is_active' => $_POST['is_active']), 'speciality_id = :id', array(":id" => $_POST['speciality_id']));
    }

}
