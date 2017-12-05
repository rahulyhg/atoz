<?php
/* @var $this DoctorExperienceController */
/* @var $model DoctorExperience */

$this->breadcrumbs=array(
	'Doctor Experiences'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DoctorExperience', 'url'=>array('index')),
	array('label'=>'Manage DoctorExperience', 'url'=>array('admin')),
);
?>

<h1>Create DoctorExperience</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>