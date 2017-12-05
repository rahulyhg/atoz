<?php
/* @var $this DocumentDetailsController */
/* @var $model DocumentDetails */

$this->breadcrumbs=array(
	'Document Details'=>array('index'),
	$model->doc_id=>array('view','id'=>$model->doc_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DocumentDetails', 'url'=>array('index')),
	array('label'=>'Create DocumentDetails', 'url'=>array('create')),
	array('label'=>'View DocumentDetails', 'url'=>array('view', 'id'=>$model->doc_id)),
	array('label'=>'Manage DocumentDetails', 'url'=>array('admin')),
);
?>

<h1>Update DocumentDetails <?php echo $model->doc_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>