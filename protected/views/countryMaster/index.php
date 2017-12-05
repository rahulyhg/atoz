<?php
/* @var $this CountryMasterController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Country Masters',
);

$this->menu=array(
	//array('label'=>'Create CountryMaster', 'url'=>array('create')),
	//array('label'=>'Manage CountryMaster', 'url'=>array('admin')),
);
?>

<h1>Country Masters</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
