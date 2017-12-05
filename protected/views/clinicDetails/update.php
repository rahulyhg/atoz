<?php
/* @var $this ClinicDetailsController */
/* @var $model ClinicDetails */

$this->breadcrumbs=array(
	'Clinic Details'=>array('index'),
	$model->clinic_id=>array('view','id'=>$model->clinic_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClinicDetails', 'url'=>array('index')),
	array('label'=>'Create ClinicDetails', 'url'=>array('create')),
	array('label'=>'View ClinicDetails', 'url'=>array('view', 'id'=>$model->clinic_id)),
	array('label'=>'Manage ClinicDetails', 'url'=>array('admin')),
);
?>

<h1>Update ClinicDetails <?php echo $model->clinic_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>