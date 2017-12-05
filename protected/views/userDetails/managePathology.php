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
	$('#user-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('search1', "
 function testFun(userid, htmlObj) {
    var is_active;
    var result = jQuery(htmlObj).is(':checked');
    if(result==true)
         is_active = '1';
    else
        is_active = '0';
       
    $.ajax({
          url:'" . Yii::app()->createUrl('UserDetails/ActiveStatus') . "', 
          type : 'POST', 
          data : {is_active:is_active, user_id:userid},
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
<!-- Page Content Start -->


<section class="content-header">

    <h3>Manage Pathology</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->

                        <h3 class="box-title text-left col-md-12"> <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>   </h3><br>
                        <div class="search-form" style="display:none">

                            <?php
                            $this->renderPartial('searchPathology', array(
                                'model' => $model,
                            ));
                            ?>

                        </div><!-- search-form --> 

                        <div class="text-right"><!--link div-->

                            <?php
                            echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Pathology', array('userDetails/createAdminPathology', "role" => 6), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            <?php
                            echo CHtml::link('<i class = "fa fa-trash fa-fw"></i>Inactive Pathology', array('userDetails/manageInactivePathology'), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
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
                            $model->role_id = 6;
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'user-details-grid',
                                'dataProvider' => $model->searchHospial(),
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
                                    array(
                                        'header' => 'Name',
                                        'value' => '$data->hospital_name ',
                                    ),
                                    array(
                                        'header' => 'Type Of Pathology',
                                        'value' => '$data->type_of_hospital ',
                                    ),
                                    array(
                                        'header' => 'Pathology Registration No',
                                        'value' => '$data->hospital_registration_no ',
                                    ),
                                    'mobile',
                                    'email_1',
                                    array(
                                        'name' => 'is_active',
                                        'type' => 'raw',
                                        'value' => '$data->ActiveStatus($data->is_active, $data->user_id)',
                                        'htmlOptions' => array("style" => "text-align:center;")
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
                                                'url' => 'Yii::app()->createUrl("userDetails/updateAdminPathology",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '"), "role" => 6))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'Edit'),
                                            ),
                                            'view' =>
                                            array(
                                                'label' => '<i class="fa fa-search fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("users/viewAllLab",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '"), "role" => 6))',
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


