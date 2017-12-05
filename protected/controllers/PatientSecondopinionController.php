<?php

class PatientSecondopinionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','create','update','manageFeedback'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PatientSecondopinion;
           
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PatientSecondopinion']))
		{
                        $doctorid=$_GET['user_id'];
                        $userid = Yii::app()->user->id;
                     $request = Yii::app()->request;
                     $purifiedObj = Yii::app()->purifier;
                     $postArr = $request->getPost("PatientSecondopinion");
			 $model->doctor_id =$doctorid;
                         $model->user_id =$userid;
                         $model->mobile =$postArr['mobile'];
                         $model->fullname =  $purifiedObj->getPurifyText($postArr['fullname']); 
                         $model->nature_of_visit =  $purifiedObj->getPurifyText($postArr['nature_of_visit']); 
                         $model->description =  $purifiedObj->getPurifyText($postArr['description']);
                         $model->age =$postArr['age'];
                         $model->pay_amt = $postArr['pay_amt'];
                         $model->doctor_feedback ="";
                         $model->status = "pending";
                         $model->created_date = date("Y-m-d H:i:s");
                         
                    $baseDir = Yii::app()->basePath . "/../uploads/";
                    if (!is_dir($baseDir)) {
                        mkdir($baseDir);
                    }
                    $docDir = 'document/';               //document
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("Y") . "/";                      //year
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }
                    $docDir = $docDir . date("M") . "/";
                    if (!is_dir($baseDir . $docDir)) {
                        mkdir($baseDir . $docDir);
                    }


                    $docImageObj = CUploadedFile::getInstance($model, "docs");
                   // print_r($docImageObj);exit;
                    if (!empty($docImageObj)) {
                        $path_part = pathinfo($docImageObj->name);
                        $fname = $docDir . time() . "_" . rand(111, 9999) . "." . $path_part['extension'];
                        $model->docs = $fname;
                        if ($docImageObj->saveAs($baseDir . $model->docs)) {
                            $model->save();
                        }
                    }
			if($model->save())
				
                    Yii::app()->user->setFlash('Success', 'You have successfully registered. Your Request For The Second Opinion.');
                    $this->redirect(array('PatientSecondopinion/create'));
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PatientSecondopinion']))
		{
			$model->attributes=$_POST['PatientSecondopinion'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->opinion_id));
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('PatientSecondopinion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PatientSecondopinion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PatientSecondopinion']))
			$model->attributes=$_GET['PatientSecondopinion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        public function actionManageFeedback($id)
        {
                $userid = base64_decode($id);
            //  echo $userid;exit;
              $model = PatientSecondopinion::model()->findByAttributes(array('user_id' => $userid));
            // echo"<pre>";print_r($model);exit;
              	if(isset($_POST['PatientSecondopinion']))
		{
                     $request = Yii::app()->request;
                     $purifiedObj = Yii::app()->purifier;
                     $postArr = $request->getPost("PatientSecondopinion");
			 if(isset($postArr['doctor_feedback']))
                         {
                             $model->doctor_feedback =$purifiedObj->getPurifyText($postArr['doctor_feedback']);
                             $model->status = "attempt";
                             $model->save();
                              Yii::app()->user->setFlash('Success', 'You have successfully  Submitted Feedback.');
                    $this->redirect(array('PatientSecondopinion/admin'));
                         }
                   
                }
                
              $this->render('managefeedback',array(
			'model'=>$model,'id'=>$userid
		));
        }
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PatientSecondopinion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PatientSecondopinion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PatientSecondopinion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='patient-secondopinion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
