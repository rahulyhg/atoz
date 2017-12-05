<?php
/* @var $this PatientSecondopinionController */
/* @var $model PatientSecondopinion */

$this->breadcrumbs=array(
	'Patient Secondopinions'=>array('index'),
	$model->opinion_id=>array('view','id'=>$model->opinion_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PatientSecondopinion', 'url'=>array('index')),
	array('label'=>'Create PatientSecondopinion', 'url'=>array('create')),
	array('label'=>'View PatientSecondopinion', 'url'=>array('view', 'id'=>$model->opinion_id)),
	array('label'=>'Manage PatientSecondopinion', 'url'=>array('admin')),
);
?>

<h1>Update PatientSecondopinion <?php echo $model->opinion_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>