<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/jquery-ui.min.css');

?>
<div class="section-body"> 
    <section id="intro" class="section-doctors">
        <div class="overlay">
            <div class="row search-banner">
                <div class="container main-text">
                    <div class="col-md-12 backward">
                        <a class="back-home" href="<?=  Yii::app()->createUrl("site/index"); ?>">Home / </a> <a class="back-sub" href="<?php echo Yii::app()->createUrl("site/doctordetails");?>">Doctors  </a>
                    </div>
                    <!-- Start Search box -->
                    <?php  $this->renderPartial('_searchbox'); ?>
                    <!-- End Search box -->
                    <div class="col-md-2 back-backward">
                        <a class="back-title" href="">Doctors </a> 
                        <div class="underline-line"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
</div> 
<div class="container-fuild" style=" background-color:#fff;border-bottom:1px solid #f0f0f0;">
    <div class="container">
        <div class="section col-pad">
            <?php 
            $baseUrl = Yii::app()->request->baseUrl."/uploads/";
            foreach($specialityArr as $key => $value)
            { 
                $path = $baseUrl.$value;
                if(empty($value)) {
                    $path = Yii::app()->request->baseUrl."/images/no-image.png";
                }
                $link = Yii::app()->createUrl("site/searchResult", array("speciality" => $key, "location" => "", "iscity" => "Y"));
            ?>
            <div class="col-md-4 col-mar text-center">
                <a href="<?php echo $link;?>">
                    <img src="<?php echo $path;?>" class="img-responsive" style="width:380px;height:215px;">
                <span class="col-sub"><?php echo $key;?> </span>
                </a>
            </div>
            <?php }?>
        </div>
    </div>
</div>