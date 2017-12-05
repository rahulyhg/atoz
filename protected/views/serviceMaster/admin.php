
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js"></script>

<?php
/* @var $this ServiceMasterController */
/* @var $model ServiceMaster */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#service-master-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('search1', "
 function testFun(serviceid, htmlObj) {
    var is_active;
    var result = jQuery(htmlObj).is(':checked');
    if(result==true)
         is_active = '1';
    else
        is_active = '0';
       
    $.ajax({
          url:'" . Yii::app()->createUrl('ServiceMaster/ActiveStatus') . "', 
          type : 'POST', 
          data : {is_active:is_active, service_id:serviceid},
          success:function(data) {
              if(is_active === '1'){
                  alert('User Activated successfully');
              }else{
                alert('User Deactivated successfully');
              }

          }
      });
       
    }

", CClientScript::POS_END);
?>
<section class="content-header">
    <h3>Manage Services</h3>
</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->

                        <h3 class="box-title text-left col-md-12"><?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?></h3><br>
                        <div class="search-form" style="display:none">


                            <?php
                            $this->renderPartial('_search', array(
                                'model' => $model,
                            ));
                            ?>

                        </div><!-- search-form -->
                        <div class="text-right">
                            <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create service', array('serviceMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                        </div>
                        <?php if (Yii::app()->user->hasFlash('Success')): ?>

                            <div class="alert alert-success col-lg-12" role="alert">
                                <?php echo Yii::app()->user->getFlash('Success'); ?>
                            </div>
                        <?php endif; ?> 
                         <div class="table-responsive">
        <?php
        $enc_key = Yii::app()->params->enc_key;
        // $model->role_id = 5;
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'service-master-grid',
            'dataProvider' => $model->search(),
            //'filter'=>$model,
            'itemsCssClass' => 'table  table-hover table-striped',
            'summaryCssClass' => 'label btn-info info-summery',
            'pagerCssClass' => 'text-center middlepage',
            'pager' => array(
                'htmlOptions' => array('class' => 'pagination'),
                'header' => false,
                'prevPageLabel' => '&lt;&lt;',
                'nextPageLabel' => '&gt;&gt;',
            ),
            'columns' => array(
                //'service_id',
                'service_name',
                //'user_id',
                // 'is_active',
                array(
                    'name' => 'is_active',
                    'type' => 'raw',
                    'value' => '$data->ActiveStatus($data->is_active, $data->service_id)',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'header' => 'Action',
                    'template' => '{update} {view}',
                    'buttons' =>
                    array(
                        'update' =>
                        array(
                            'label' => '<i class="fa fa-edit fa-fw"></i>',
                            'url' => 'Yii::app()->createUrl("serviceMaster/update",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->service_id,"' . $enc_key . '")))',
                            'imageUrl' => false,
                            'options' => array('title' => 'Edit'),
                        ),
                        'view' =>
                        array(
                            'label' => '<i class="fa fa-search fa-fw"></i>',
                            'url' => 'Yii::app()->createUrl("serviceMaster/view",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->service_id,"' . $enc_key . '")))',
                            'imageUrl' => false,
                            'options' => array('title' => 'View'),
                        ),
                    ),
                    'htmlOptions' => array("style" => "text-align:center;")
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





</div>




   



<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 54px;
        height: 26px;
    }

    .switch input {display:none;}

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 19px;
        width: 19px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked + .slider {
        background-color: #2196F3;
    }

    input:focus + .slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked + .slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 34px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>


