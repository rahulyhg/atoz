<?php
/* @var $this LabBookDetailsController */
/* @var $model LabBookDetails */

$this->breadcrumbs=array(
	'Lab Book Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LabBookDetails', 'url'=>array('index')),
	array('label'=>'Create LabBookDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#lab-book-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Lab Book Details</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'lab-book-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'book_id',
		'patient_id',
		'role_id',
		'center_id',
		'relation',
		'full_name',
		/*
		'mobile_no',
		'patient_age',
		'service_name',
		'discription_doc',
		'collect_home',
		'pincode',
		'country_id',
		'country_name',
		'city_id',
		'city_name',
		'area_id',
		'area_name',
		'landmark',
		'address',
		'created_date',
		'updated_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
