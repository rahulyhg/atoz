<?php
/* @var $this CityMasterController */
/* @var $model CityMaster */
?>
<section class="content-header">

    <h1>Create City </h1>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->


                            <?php echo CHtml::link('<i class = "fa fa-gear fa-fw"></i> Manage city', array('cityMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>


                        </div><!--link End-->    
                        <?php $this->renderPartial('_form', array('model' => $model)); ?>

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->






