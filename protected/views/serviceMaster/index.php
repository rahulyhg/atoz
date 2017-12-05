<?php
/* @var $this ServiceMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Service Masters',
);

$this->menu=array(
	array('label'=>'Create ServiceMaster', 'url'=>array('create')),
	array('label'=>'Manage ServiceMaster', 'url'=>array('admin')),
);
?>

<h1>Service Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
