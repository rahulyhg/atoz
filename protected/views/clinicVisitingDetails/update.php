<?php
/* @var $this ClinicVisitingDetailsController */
/* @var $model ClinicVisitingDetails */

$this->breadcrumbs=array(
	'Clinic Visiting Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClinicVisitingDetails', 'url'=>array('index')),
	array('label'=>'Create ClinicVisitingDetails', 'url'=>array('create')),
	array('label'=>'View ClinicVisitingDetails', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClinicVisitingDetails', 'url'=>array('admin')),
);
?>

<h1>Update ClinicVisitingDetails <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>