<?php
$enc_key = Yii::app()->params->enc_key;
?>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<?php
Yii::app()->clientScript->registerScript('search1', "
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
$hospitalInfoArr = Yii::app()->db->createCommand()->select("hospital_name")->from("az_user_details")->where("user_id = :id", array(":id" => $hospId))->queryRow();
?>
<!-- Page Content Start -->


<section class="content-header">

    <h3>Manage <?php echo $hospitalInfoArr['hospital_name']; ?> Doctors</h3>

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
                            <?php echo CHtml::link('<i class = "fa fa-plus fa-fw"></i>Create Doctor', array('userDetails/createHospDoc', "param1" => base64_encode($hospId)), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                             <?php echo CHtml::link('<i class = "fa fa-trash fa-fw"></i>Inactive Doctor', array('userDetails/ManageInactiveHospitalDoctor', "param1" => base64_encode($hospId)), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
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

                          <input type="hidden" id="userid" value="">
                        <div class="table-responsive">
                            <?php
                            $model->role_id = 3;
                            $model->parent_hosp_id = $hospId;
                            $model->is_active = 1;
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'user-details-grid',
                                'dataProvider' => $model->search("hospital"),
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
                                        'header' => 'OPD No',
                                        'value' => '$data->opd_no ',
                                    ),
                                     array(
                                        'header' => 'Transfer OPD',
                                         'type' => 'raw',
                                         'value' => 'CHtml::link("transfer","javascript:",array("onclick" => "trasferopd($data->user_id,$data->parent_hosp_id,\'$data->opd_no\')"))',
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
                                                'url' => 'Yii::app()->createUrl("userDetails/updateHospitalDoctor",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"'.$enc_key.'")))',
                                                'imageUrl' => false,
                                                'options' => array('title' => 'Edit'),
                                            ),
                                            'view' =>
                                            array(
                                                'label' => '<i class="fa fa-search fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("userDetails/viewHospitalDoctor",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"'.$enc_key.'")))',
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

<div class="modal fade" id="opdtrans" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header" style="border:none;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Doctor Details</h4>
            </div>
            <div class="modal-body" style="padding: 0px;border:none;">

                <div class="form-group">
                    <div class="col-sm-5">
                        <label class="control-label">Transfer Current Appointment To:</label>
                      
                    </div>
                    <div class="col-sm-4">
                     <select class="docname form-control">
                            
                        </select>
                       
                          </div>
                    
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-info" onclick="transferrec();">Transfer</button>  
                    </div>
                    
                </div>
                <div class="col-sm-10">
                 <span id="transerror"style="color: red; display:none;"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                </div>
            </div>

        </div>
    </div>
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
<script type="text/javascript">

    function trasferopd(userid,phospitalid,opdno)
    {
         $("#transerror").hide();
             $("#userid").val(userid);
             jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("users/getOpdtrnsferDoctor"); ?> ',
            data: {userid: userid,phospitalid:phospitalid,opdno:opdno},
            success: function (data) {

                var dataobj = data.data;
                 var doctorname = "";
                doctorname +="<option value=''>Select Doctor</option>";
                $.each(dataobj, function (key, value) {

                   doctorname += "<option value='" + value.user_id +"'>"+value.first_name+" "+value.last_name+"</option>";
                });
               
                  $(".docname").html(doctorname);
            }
        });
        $('#opdtrans').modal('show');

    }
    function transferrec()
    {
         $("#transerror").hide();
        var olddoctorid = $("#userid").val();
        var selecteddocid = $(".docname").val();
       jQuery.ajax({
            type: 'POST',
            dataType: 'json',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("users/transferOpd"); ?> ',
            data: {olddoctorid: olddoctorid,selecteddocid:selecteddocid},
           success: function (result) {
                        if ( result.iserror) {
                         
                        $("#transerror").html('');
                        }else{
                           var error_msg='Appointment Can Not Transfer Successfully';
                        $("#transerror").html(error_msg).show();
                        }

                    }
        });
      
    }
</script>
