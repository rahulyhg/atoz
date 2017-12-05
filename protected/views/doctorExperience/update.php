<?php
/* @var $this DoctorExperienceController */
/* @var $model DoctorExperience */

$this->breadcrumbs=array(
	'Doctor Experiences'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DoctorExperience', 'url'=>array('index')),
	array('label'=>'Create DoctorExperience', 'url'=>array('create')),
	array('label'=>'View DoctorExperience', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DoctorExperience', 'url'=>array('admin')),
);
?>

<h1>Update DoctorExperience <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>