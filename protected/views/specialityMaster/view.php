<?php
/* @var $this SpecialityMasterController */
/* @var $model SpecialityMaster */

$this->breadcrumbs = array(
    'Speciality Masters' => array('index'),
    $model->speciality_id,
);

//$this->menu=array(
//	array('label'=>'List SpecialityMaster', 'url'=>array('index')),
//	array('label'=>'Create SpecialityMaster', 'url'=>array('create')),
//	array('label'=>'Update SpecialityMaster', 'url'=>array('update', 'id'=>$model->speciality_id)),
//	array('label'=>'Delete SpecialityMaster', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->speciality_id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage SpecialityMaster', 'url'=>array('admin')),
//);
?>

<section class="content-header">

    <h3>View speciality</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php echo CHtml::link('<i class = "fa  fa-plus  fa-fw"></i> Create speciality ', array('SpecialityMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                            <?php
                            $enc_key = Yii::app()->params->enc_key;
                            echo CHtml::link('<i class = "fa fa-edit "></i>Update speciality', array('SpecialityMaster/update', 'id' => Yii::app()->getSecurityManager()->encrypt($model->speciality_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'));
                            ?>
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage speciality ', array('SpecialityMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')); ?>
                        </div><!--link End-->    
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr class="odd"><th>Speciality Name</th><td><?php echo CHtml::encode($model->speciality_name); ?></td></tr>
                                <tr class="odd"><th>Speciality Picture</th><td>
                                        <img alt="shortcut icon" src="<?php echo Yii::app()->request->baseUrl . '/uploads/' . $model->img_name; ?>" width= "160px" border=" 1px solid #dfdfdf" height="137px"/></td></tr>

                            </tbody>
                        </table>
                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->










