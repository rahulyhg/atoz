<?php
/* @var $this LabBookDetailsController */
/* @var $model LabBookDetails */

$this->breadcrumbs=array(
	'Lab Book Details'=>array('index'),
	$model->book_id=>array('view','id'=>$model->book_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LabBookDetails', 'url'=>array('index')),
	array('label'=>'Create LabBookDetails', 'url'=>array('create')),
	array('label'=>'View LabBookDetails', 'url'=>array('view', 'id'=>$model->book_id)),
	array('label'=>'Manage LabBookDetails', 'url'=>array('admin')),
);
?>

<h1>Update LabBookDetails <?php echo $model->book_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>