<?php
/* @var $this CountryMasterController */
/* @var $model CountryMaster */
?>



<section class="content-header">

    <h3>View Country</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->
                            <?php echo CHtml::link('<i class = "fa fa-plus "></i>Create Country', array('countryMaster/create'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>
                            <?php
                            $enc_key = Yii::app()->params->enc_key;
                            echo CHtml::link('<i class = "fa fa-edit "></i>Update Country', array('countryMaster/update', 'id' => Yii::app()->getSecurityManager()->encrypt($model->country_id, $enc_key)), array("style" => "color: white;", 'class' => 'btn btn-info'))
                            ?>
                            <?php echo CHtml::link('<i class = "fa  fa-gear  fa-fw"></i> Manage Country ', array('countryMaster/admin'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>

                        </div><!--link End-->    

                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr class="odd"><th>Country Name</th><td><?php echo CHtml::encode($model->country_name); ?></td></tr>
                            </tbody>
                        </table>

                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->












