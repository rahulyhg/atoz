<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$enc_key = Yii::app()->params->enc_key;
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<?php
/* @var $this UserDetailsController */
/* @var $model UserDetails */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#clinic-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('search1', "
 
", CClientScript::POS_END);
?>
<!-- Page Content Start -->


<section class="content-header">
    <h3>Manage clinic</h3>
</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="search-form" style="display:none">

                            <?php
                            $this->renderPartial('_search', array(
                                'model' => $model,
                            ));
                            ?>

                        </div><!-- search-form -->
                        <div class="text-right"><!--link div-->

                            <?php
                            echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Clinic', array('clinicDetails/createClinic', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                             ?> 
                             <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Doctor ', array('UserDetails/admindoctor'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                            
                        </div><!--link End-->   
                        <?php if (Yii::app()->user->hasFlash('Success')): ?>
                            <div class="alert alert-success" role="alert">
                                <button type="button" class="close" data-dismiss="alert">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <div>
                                    <?php echo Yii::app()->user->getFlash('Success'); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="table-responsive">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'clinic-details-grid',
                                'dataProvider' => $model->search($id),
                                'itemsCssClass' => 'table table-hover table-striped',
                                'summaryCssClass' => 'label btn-info info-summery',
                                'cssFile' => false,
                                'pagerCssClass' => 'text-center middlepage',
                                'pager' => array(
                                    'htmlOptions' => array('class' => 'pagination'),
                                    'header' => false,
                                    'prevPageLabel' => '&lt;&lt;',
                                    'nextPageLabel' => '&gt;&gt;',
                                    'internalPageCssClass' => '',
                                    'selectedPageCssClass' => 'active'
                                ),
                                'columns' => array(
                                    'clinic_name',
                                    'doctor_id',
                                    'opd_consultation_fee',
                                    array(
                                        'class' => 'CButtonColumn',
                                        'header' => 'Action',
                                        'template' => '{update} {view}',
                                    
                                        'buttons' =>
                                        
                                        array(
                                            'update' =>
                                            array(
                                                'label' => '<i class="fa fa-edit fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("ClinicDetails/updateAdminClinic",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->clinic_id,"' . $enc_key . '")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'Edit'),
                                            ),
                                            'view' =>
                                            array(
                                                'label' => '<i class="fa fa-search fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("ClinicDetails/viewClinic",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->clinic_id,"' . $enc_key . '")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'View'),
                                            ),
                                        ),
                                        'htmlOptions' => array('style' => 'text-align:center; width:20%;'),
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














