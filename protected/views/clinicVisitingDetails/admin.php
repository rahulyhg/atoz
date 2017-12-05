<?php
/* @var $this ClinicVisitingDetailsController */
/* @var $model ClinicVisitingDetails */

$this->breadcrumbs=array(
	'Clinic Visiting Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ClinicVisitingDetails', 'url'=>array('index')),
	array('label'=>'Create ClinicVisitingDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#clinic-visiting-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Clinic Visiting Details</h1>

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
	'id'=>'clinic-visiting-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'clinic_id',
		'doctor_id',
		'day',
		'clinic_open_time',
		'clinic_close_time',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
