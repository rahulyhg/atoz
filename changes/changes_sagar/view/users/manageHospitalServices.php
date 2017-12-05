<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

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

          }
      });
       
    }

", CClientScript::POS_END);
?>
<!-- Page Content Start -->

<section class="content-header">
    <h3>Manage Hospital Services</h3>
</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->

                        <h3 class="box-title text-left col-md-12">  <?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button'));         ?>  </h3><br>
                       
                        <div class="text-right"><!--link div-->
                            <?php
                            $hospitalservices = array("6" => "Pathology", "7" => "Diagnostic", "8" => "Blood Bank", "9" => "Medical Store");
                            $finalhospitalservices = $hospitalservices;

                            $role = Yii::app()->db->createCommand()
                                    ->selectDistinct('role_id')
                                    ->from('az_user_details t')
                                    ->where('parent_hosp_id=:id And role_id != 3', array(':id' => Yii::app()->user->id))
                                    ->queryColumn();
                           
                            $str = '';
                            foreach ($hospitalservices as $key => $value) {

                                if (in_array($key, $role)) {
                                    
                                } else {
                                 
                                    if ($key == 6 || $key == 7) {
                                        $str .= '<li>'.CHtml::link( $value , array('userDetails/createAdminPathology','role'=>$key)).'</li>';
                                    }
                                    if ($key == 8 || $key == 9) {
                                        $str .= '<li>'.CHtml::link( $value , array('users/createAdminBloodBank','role'=>$key)).'</li>';
                                        
                                    }
                                }
                            }
                            ?>



                        </div><!--link End-->

                        <div class="btn-group  pull-right">
                            <button type="button" class="btn btn-info">Add Services</button>
                            <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu" role="menu">

                                <?php echo $str; ?>
                            </ul>

                        </div>
                        <div class="clearfix"></div>
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
                        <?php $hospitalid = Yii::app()->user->id; ?>
                        <div class="table-responsive">
                            <?php
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'user-details-grid',
                                'dataProvider' => $model->addHospitalServices($hospitalid),
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
                                        'value' => '$data->hospital_name ',
                                    ),
                                    array(
                                        'header' => 'Services',
                                        'value' => '$data->rolename',
                                    ),
                                    array(
                                        'header' => 'Mobile',
                                        'value' => '$data->apt_contact_no_1 ',
                                    ),
                                    array(
                                        'class' => 'CButtonColumn',
                                        'header' => 'Action',
                                        'template' => '{update} {update1} {view} ',
                                        'buttons' =>
                                        array(
                                            'update' =>
                                            array(
                                                'label' => '<i class="fa fa-edit fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("userDetails/updateAdminPathology",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '"), "role" =>$data->role_id))',
                                                'imageUrl' => false,
                                                'visible'=> '$data->role_id == 6 || $data->role_id == 7',
                                                'options' => array('title' => 'Edit'),
                                            ),'update1' =>
                                            array(
                                                'label' => '<i class="fa fa-edit fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("users/updateAdminBloodBank",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '"), "role" =>$data->role_id))',
                                                'imageUrl' => false,
                                                'visible'=> '$data->role_id == 8 || $data->role_id == 9',
                                                'options' => array('title' => 'Edit'),
                                            ),
                                            'view' =>
                                            array(
                                                'label' => '<i class="fa fa-search fa-fw"></i>',
                                                'url' => 'Yii::app()->createUrl("users/viewServices",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '"), "role" =>$data->role_id))',
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

                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script type="text/javascript">

    $(function () {



    });
    function Addservice()
    {
        var roleid = $(".services option:selected").val();
        if (roleid == 6 || roleid == 7) {
            window.location.href = '<?php echo Yii::app()->createUrl("users/addHospitalServices"); ?>' + '/role_id/' + encodeURI(roleid);
        } else if (roleid == 8 || roleid == 9) {
            window.location.href = '<?php echo Yii::app()->createUrl("users/addHospitalServices"); ?>' + '/role_id/' + encodeURI(roleid);
        }

    }
</script>