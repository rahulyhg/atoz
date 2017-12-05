<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<?php
/* @var $this CityMasterController */
/* @var $model CityMaster */
//$model1=new StateMaster();

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#city-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<section class="content-header">
    <h1>Manage City</h1>
</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
      <div class="row">
            <div class="col-lg-12"><!-- column col-lg-12 start -->
             
                    <div class="box box-warning direct-chat direct-chat-warning"><!-- box-warning start -->
                        <div class="box-header with-border"><!-- box-header start -->
                            <h3 class="box-title text-left col-md-12"><?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?> </h3><br>
                            <div class="search-form" style="display:none">
                                <?php
                                $this->renderPartial('_search', array(
                                    'model' => $model,
                                ));
                                ?>
                            </div><!-- search-form -->
                            <div class="text-right">
                                <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create City', array('cityMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                            </div>
                            <?php if (Yii::app()->user->hasFlash('Success')): ?>

                                <div class="alert alert-success col-lg-12" role="alert">
                                    <?php echo Yii::app()->user->getFlash('Success'); ?>
                                </div>
                            <?php endif; ?> 
                            <div class="table-responsive">
                                <?php
                                $enc_key = Yii::app()->params->enc_key;
                                $this->widget('zii.widgets.grid.CGridView', array(
                                    'id' => 'city-master-grid',
                                    'dataProvider' => $model->search(),
                                    'itemsCssClass' => 'table table-hover table-striped',
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
                                        // 'city_id',
                                        'state_id',
                                        'city_name',
                                        array(
                                            'class' => 'CButtonColumn',
                                            'header' => 'Action',
                                            'template' => '{update} {view}',
                                            'buttons' =>
                                            array(
                                                'update' =>
                                                array(
                                                    'label' => '<i class="fa fa-edit fa-fw"></i>',
                                                    'url' => 'Yii::app()->createUrl("cityMaster/update",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->city_id,"' . $enc_key . '")))',
                                                    'imageUrl' => false,
                                                    'options' => array('title' => 'Edit'),
                                                ),
                                                'view' =>
                                                array(
                                                    'label' => '<i class="fa fa-search fa-fw"></i>',
                                                    'url' => 'Yii::app()->createUrl("cityMaster/view",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->city_id,"' . $enc_key . '")))',
                                                    'imageUrl' => false,
                                                    'options' => array('title' => 'View'),
                                                ),
                                            ),
                                        ),
                                    ),
                                ));
                                ?>

                            </div><!--box-header end-->
                        </div><!-- box-warning end -->
                    </div><!-- column col-lg-12 start -->
               


            </div><!-- row end -->
        </div><!-- row end -->
    </section><!-- section content end -->


</div><!-- tab-content end-->
