<?php

class ServiceMasterController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/adminLayout';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','ActiveStatus'),
				//'users'=>array('admin'),
                                 'roles'=>array('1', '2')
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionview($id)
	{
             $enc_key = Yii::app()->params->enc_key;
             $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key);
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actioncreate()
	{
		$model=new ServiceMaster;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ServiceMaster']))
		{
			$model->attributes=$_POST['ServiceMaster'];
			if($model->save())
                        {
                              $enc_key = Yii::app()->params->enc_key;
				$this->redirect(array('view','id'=>Yii::app()->getSecurityManager()->encrypt($model->service_id,$enc_key)));
                        }
                }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionupdate($id)
	{
                $enc_key = Yii::app()->params->enc_key;    
                $id = Yii::app()->getSecurityManager()->decrypt($id, $enc_key); 
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ServiceMaster']))
		{
			$model->attributes=$_POST['ServiceMaster'];
			if($model->save())
                            $enc_key = Yii::app()->params->enc_key;
				$this->redirect(array('view','id'=> Yii::app()->getSecurityManager()->encrypt($model->service_id,$enc_key)));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actiondelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionindex()
	{
		$dataProvider=new CActiveDataProvider('ServiceMaster');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionadmin()
	{
		$model=new ServiceMaster('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ServiceMaster']))
			$model->attributes=$_GET['ServiceMaster'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ServiceMaster the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ServiceMaster::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ServiceMaster $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='service-master-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
    public function actionactiveStatus() {
        $update = Yii::app()->db->createCommand()->update('az_service_master', array('is_active' => $_POST['is_active']), 'service_id = :serviceid', array(":serviceid" => $_POST['service_id']));
        if ($update)
            echo 1;
        
    }
        
       
        
           
        
}
        
