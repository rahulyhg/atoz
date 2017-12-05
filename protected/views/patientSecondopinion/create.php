<?php
/* @var $this PatientSecondopinionController */
/* @var $model PatientSecondopinion */

$this->breadcrumbs=array(
	'Patient Secondopinions'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PatientSecondopinion', 'url'=>array('index')),
	array('label'=>'Manage PatientSecondopinion', 'url'=>array('admin')),
);
?>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>