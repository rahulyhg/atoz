<?php

    //echo $PatientInfoArr['first_name'];
   // echo $roleid.$id;
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
	$('#couser-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>
<!-- Page Content Start -->

<section class="content-header">

    <h3>Manage Co Users</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->


<!--    <h3 class="box-title text-left col-md-12">  <?php //echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>  </h3><br>-->
                        <div class="search-form " style="display:none">

                            <?php
//                            $role_id = 4;
//                            $this->renderPartial('_search', array(
//                                'model' => $model,'role_id'=>$role_id
//                            ));
                            ?>

                        </div><!-- search-form -->
                         <div class="text-right"><!--link div-->

                            <?php
                            echo CHtml::link('<i class = "fa fa-edit "></i>Create User', array('UserDetails/updateAdminCorporate', 'id' => Yii::app()->getSecurityManager()->encrypt($id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            

                        </div><!--link End-->    
 <div class="table-responsive">
<?php
$model->role_id = 4;

$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'couser-details-grid',
'dataProvider' => $model->searchCorporateList($id),
    'itemsCssClass' => 'table table-bordered table-hover table-striped',
    'summaryCssClass' => 'label btn-info info-summery',
    'summaryText' => '',
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
            'value' => '$data->first_name',
        ),
   
        'mobile',
        array(
            'header' => 'Email',
            'value' => '$data->email_1 ',
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
                    'url' => 'Yii::app()->createUrl("userDetails/updateAdminPatient",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '")))',
                    'imageUrl' => false,
                    'options' => array('title' => 'Edit'),
                ),
                'view' =>
                array(
                    'label' => '<i class="fa fa-search fa-fw"></i>',
                    'url' => 'Yii::app()->createUrl("userDetails/ViewPatient",array("id"=>Yii::app()->getSecurityManager()->encrypt($data->user_id,"' . $enc_key . '")))',
                    'imageUrl' => false,
                    'options' => array('title' => 'View'),
                ),
                
            ),
            'htmlOptions' => array('style' => 'text-align:center; width:20%;'),
        )
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


