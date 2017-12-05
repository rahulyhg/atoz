

<section class="content-header">

    <h3>Upload file</h3>

</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <div class="text-right"><!--link div-->


                            <?php // echo CHtml::link('<i class = "fa fa-gear fa-fw"></i> Manage Patients', array('userDetails/adminpatient'), array("style" => "color: white;", 'class' => 'btn btn-info')) ?>


                        </div><!--link End-->    
                        <?php
                        $baseUrl = Yii::app()->request->baseUrl;
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'update-admin-corporate-form',
                            'htmlOptions' => array('enctype' => 'multipart/form-data'),
                            'enableAjaxValidation' => false,
                        ));
                        ?>
                        
                        <div class="col-sm-4">
                            <label>Upload file</label>
                                <?php
                                
                                echo $form->fileField($model, 'tmp_file', array("class" => "tmpfile"));
                                echo $form->error($model, 'tmp_file');
                                ?>
                        </div>
                        
                        <a href="<?php echo $baseUrl; ?>/uploads/Template/corporate employee details.xlsx">Click Here For Download Tempate </a>
                        
                        <div class="clearfix"></div>
                        <div class="box-footer text-center">
                            <?php
                            echo CHtml::submitButton("Save", array('class' => 'btn btn-primary'));
                            ?>
                        </div>
                        
                        
                        <?php $this->endWidget(); ?>


                    </div><!-- box header end -->
                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->
