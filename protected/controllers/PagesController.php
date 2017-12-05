<?php

class PagesController extends Controller
{
	public function actionContact()
	{
		$this->render('contact');
	}
        public function actionWhatwedo() {
            $this->render('whatwedo');
        }
        public function actionInnovativetechnique() {
            $this->render('innovativetechnique');
        }
        public function actionServices() {
            $this->render('services');
        }
        public function actionCareer() {
            $this->render('career');
        }
        public function actionAbout() {
            $this->render('about');
        }
        public function actionEmergency() {
            $this->render('emergency');
        }
        public function actionCommingsoon() {
            $this->render('commingsoon');
        }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}