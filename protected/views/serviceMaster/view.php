<?php
/* @var $this ServiceMasterController */
/* @var $model ServiceMaster */
?>

<section class="content-header">

    <h3>View Services </h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->

                            <?php echo CHtml::link('<i class = "fa fa-plus "></i>Create service', array('serviceMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                            <?php
                            $enc_key = Yii::app()->params->enc_key;
                            echo CHtml::link('<i class = "fa fa-edit "></i>Update service', array('serviceMaster/update', 'id' => Yii::app()->getSecurityManager()->encrypt($model->service_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'))
                            ?>

                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage service ', array('serviceMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>


                        </div><!--link End-->    
                        <table class="table table-hover table-striped">
                            <tbody>
                            </tbody>  
                            <tr class="odd"><th>Service Name</th><td><?php echo CHtml::encode($model->service_name); ?></td></tr>
                        </table> 

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->














