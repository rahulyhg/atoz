<?php
$enc_key = Yii::app()->params->enc_key;
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<?php
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
              $('#user-details-grid').yiiGridView('update', {
                    data: $('.search-form form').serialize()
            });

          }
      });
       
    }

", CClientScript::POS_END);
?>
<!-- Page Content Start -->

<section class="content-header">

    <h3>Manage Doctor</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->

                        <h3 class="box-title text-left col-md-12">  <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>  </h3><br>
                        <div class="search-form " style="display:none">

                            <?php
                            $role_id = 3;
                            $this->renderPartial('_search', array(
                                'model' => $model, 'role_id' => $role_id
                            ));
                            ?>

                        </div><!-- search-form -->
                        <div class="text-right"><!--link div-->

                            <?php
                            echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Doctor', array('userDetails/CreateAdminDoctor'), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            <?php
                            echo CHtml::link('<i class = "fa fa-trash fa-fw"></i>Inactive Doctor', array('userDetails/manageInactiveDoctor'), array("style" => "color: white;", 'class' => 'btn btn-info'))
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
                            $model->role_id = 3;
                            $model->is_active = 1;
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'user-details-grid',
                                'dataProvider' => $model->search("clinic"),
                                'itemsCssClass' => 'table table-bordered table-hover table-striped',
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
                                        'value' => '$data->first_name ',
                                    ),
                                    'speciality',
                                    'mobile',
                                    array(
                                        'header' => 'Apt Contact No',
                                        'value' => '$data->apt_contact_no_1 ',
                                    ),
                                    array(
                                        'header' => 'Email',
                                        'value' => '$data->email_1 ',
                                    ),
                                    array(
                                        'name' => 'is_active',
                                        'type' => 'raw',
                                        'value' => '$data->ActiveStatus($data->is_active, $data->user_id)',
                                        'htmlOptions' => array("style" => "text-align:center;")
                                    ),
                                    array(
                                        'header' => 'Manage Clinic',
                                        'type' => 'raw',
                                        'value' => 'CHtml::link("Manage Clinic",array("clinicDetails/adminclinic","id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '")))',
                                        'htmlOptions' => array("style" => "text-align:center;")
                                    ),
                                    array(
                                        'class' => 'CButtonColumn',
                                        'header' => 'Action',
                                        'template' => '{update} {view} {manage}',
                                        'buttons' =>
                                        array(
                                            'update' =>
                                            array(
                                                'label' => '<i class="fa fa-edit fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("userDetails/updateAdminDoctor",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'Edit'),
                                            ),
                                            'view' =>
                                            array(
                                                'label' => '<i class="fa fa-search fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("userDetails/viewDoctor",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'View'),
                                            ),
                                            'manage' =>
                                            array(
                                                'label' => '<i class="fa fa-edit fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("doctorExperience/adminDocExperience",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'Manage Doctor Experience'),
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


