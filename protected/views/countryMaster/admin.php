<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js"></script>


<?php
/* @var $this CountryMasterController */
/* @var $model CountryMaster */

//$this->breadcrumbs=array(
//	'Country Masters'=>array('index'),
//	'Manage',
//);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#country-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<section class="content-header">
    <h3> Manage Country </h3>
</section>

<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <h3 class="box-title text-left col-md-12"><?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>  </h3> <br>
                        <div class="search-form" style="display:none">

                            <?php
                            $this->renderPartial('_search', array(
                                'model' => $model,
                            ));
                            ?>

                        </div><!-- end of form-->
                        <div class="text-right"><!--link div-->
                            <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Country', array('CountryMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                        </div><!--link End--> 

                        <?php if (Yii::app()->user->hasFlash('Success')): ?>

                            <div class="alert alert-success col-lg-12" role="alert">
                                <?php echo Yii::app()->user->getFlash('Success'); ?>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <?php
                            $enc_key = Yii::app()->params->enc_key;
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'country-master-grid',
                                'dataProvider' => $model->search(),
                                'itemsCssClass' => 'table   table-hover table-striped',
                                'summaryCssClass' => 'label btn-info info-summery',
                                'pagerCssClass' => 'text-center middlepage',
                                'pager' => array(
                                    'htmlOptions' => array('class' => 'pagination'),
                                    'header' => false,
                                    'prevPageLabel' => '&lt;&lt;',
                                    'nextPageLabel' => '&gt;&gt;',
                                ),
                                // 'filter' => $model,
                                'columns' => array(
                                    'country_name',
                                    array(
                                        'class' => 'CButtonColumn',
                                        'header' => 'Action',
                                        'template' => '{update} {view}',
                                        'buttons' =>
                                        array(
                                            'update' =>
                                            array(
                                                'label' => '<i class="fa fa-edit fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("countryMaster/update",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->country_id,"' . $enc_key . '")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'Edit'),
                                            ),
                                            'view' =>
                                            array(
                                                'label' => '<i class="fa fa-search fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("countryMaster/view",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->country_id,"' . $enc_key . '")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'View'),
                                            ),
                                        ),
                                        'htmlOptions' => array('style' => 'text-align:center; width:100px;'),
                                    ),
                                ),
                            ));
                            ?>
                        </div>        


                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->









