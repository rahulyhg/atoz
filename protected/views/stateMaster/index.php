<?php
/* @var $this StateMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'State Masters',
);

$this->menu=array(
	//array('label'=>'Create StateMaster', 'url'=>array('create')),
	//array('label'=>'Manage StateMaster', 'url'=>array('admin')),
);
?>

<h1>State Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
