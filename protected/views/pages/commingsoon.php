<?php
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style_pages.css');
?>
<section class="section-details container-fuild" style="border-bottom: 1px solid #e9e9e9; padding-bottom:35px">
    <div class="overlay">
        <div class="row">

            <!-- 2-column layout -->
            <div class="row">                              		
                <div class="col-md section" style="padding:0">                               	

                    <div class="col-md-12">

                        <div class="second-opinion">
                            <div class="background_col">
                                <div class="container apoint-note text-left" style="padding-left:15px">
                                    <a href="<?=  Yii::app()->createUrl("site/index"); ?>">Home /</a> <span> Coming Soon</span> 
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="container">
                                <img src="<?php echo $baseUrl; ?>/images/coming-soon.png" class="img-responsive">
                            </div>
                            <div class="clearfix"></div>


                        </div>  

                    </div>                                   

                </div>
            </div> <!--col-md-12 end-->  

            <div class="clearfix"></div>                

        </div><!--/row-->
    </div>   
</div>
</section>