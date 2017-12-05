<?php
/* @var $this AreaMasterController */
/* @var $model AreaMaster */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#area-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<section class="content-header">
    <h1>Manage Area</h1>
</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row">
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning">
                    <div class="box-header with-border">
<div class="col-lg-12">

    
    
     <h3 class="box-title text-left col-md-12"><?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?> </h3><br>
    <div class="search-form panel panel-default" style="display:none">
        <div class="panel-body">

            <?php
            $this->renderPartial('_search', array(
                'model' => $model,
            ));
            ?>
        </div>     
    </div><!-- search-form -->
    <div class="text-right">
                            <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Area', array('areaMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                        </div>
    <?php if (Yii::app()->user->hasFlash('Success')): ?>

        <div class="alert alert-success col-lg-12" role="alert">
            <?php echo Yii::app()->user->getFlash('Success'); ?>
        </div>
    <?php endif; ?> 
</div>


<div class="col-lg-12 posRelative">
    <div class="table-responsive">
        <?php
         $enc_key = Yii::app()->params->enc_key;
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'state-master-grid',
            'dataProvider' => $model->search(),
            'itemsCssClass' => 'table table-bordered  table-hover table-striped',
            'summaryCssClass' => 'label btn-info info-summery',
            'pagerCssClass' => 'text-center middlepage',
            'pager' => array(
                'htmlOptions' => array('class' => 'pagination'),
                'header' => false,
                'prevPageLabel' => '&lt;&lt;',
                'nextPageLabel' => '&gt;&gt;',
            ),
            //'filter' => $model,
            'columns' => array(
                'city_id',
		'area_name',
		'pincode',
		
                array(
                    'class' => 'CButtonColumn',
                    'header' => 'Action',
                    'template' => '{update} {view}',
                    'buttons' =>
                    array(
                        'update' =>
                        array(
                            'label' => '<i class="fa fa-edit fa-fw"></i>',
                            //'url' => 'Yii::app()->createUrl("stateMaster/update",array("id"=>$data->state_id))',
                            'url' => 'Yii::app()->createUrl("AreaMaster/update",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->area_id,"' . $enc_key . '")))',
                            'imageUrl' => false,
                            'options' => array('title' => 'Edit'),
                        ),
                        'view' =>
                        array(
                            'label' => '<i class="fa fa-search fa-fw"></i>',
                            //'url' => 'Yii::app()->createUrl("stateMaster/view",array("id"=>$data->state_id))',
                            'url' => 'Yii::app()->createUrl("AreaMaster/view",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->area_id,"' . $enc_key . '")))',
                            'imageUrl' => false,
                            'options' => array('title' => 'View'),
                        ),
                    ),
                ),
            ),
        ));
        ?>
    </div>         
</div>