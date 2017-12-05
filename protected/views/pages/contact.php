<?php
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style_pages.css');
?>
<section class="section-details container-fuild" style="border-bottom: 1px solid #e9e9e9; padding-bottom:35px">
    <div class="overlay">
        <div class="row">
            <div class="col-md-12">
                <img src="<?php echo $baseUrl; ?>/images/banner5.jpg" class="img-responsive">
            </div>
            <!-- 2-column layout -->
            <div class="row">                              		
                <div class="col-md section" style="padding:0">                               	

                    <div class="col-md-12">

                        <div class="second-opinion">
                            <div class="background_col">
                                <div class="container apoint-note text-left" style="padding-left:15px">
                                    <div class="col-md-12"><a href="<?php echo $baseUrl; ?>">Home /</a> <span> Contact Us </span> </div> 
                                </div>
                            </div>
                            <div class="clearfix"></div>

                            <div class="container">
                                <div class="col-md-12 footer-top">

                                    <p>Do you have other questions?  </p>
                                    <p class="footer-top">Just fill out the form below and we’ll get back to you as soon as possible. </p>

                                    <form action="post-form.php" method="post" enctype="application/x-www-form-urlencoded">
                                        <h3 class="footer-top title wow bounceIn animated" style="font-weight:300">Feedback Form  </h3>
                                        <div class="footer-top row">
                                            <div class="form-group col-md-4">
                                                <label for="exampleInputEmail1">Your name</label>
                                                <input type="text" class="form-control" name="sender_name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name" required>

                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exampleInputPassword1">Mobile No. </label>
                                                <input type="text" name="mob" class="form-control" id="exampleInputPassword1" placeholder="Mobile No." required>
                                            </div>   

                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-4">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" name="sender_email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>

                                            </div>                                              
                                            <div class="form-group col-md-4">
                                                <label for="exampleTextarea">Message </label>
                                                <textarea class="form-control" name="message" id="exampleTextarea" rows="3" required></textarea>
                                            </div>
                                            <div class="clearfix"></div>                                             

                                            <div class="col-md-4">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>   
                                    </form>
                                </div>	

                            </div>


                        </div>  

                    </div>                                   

                </div>
            </div> <!--col-md-12 end-->  

            <div class="clearfix"></div>                

        </div><!--/row-->
    </div>   
</div>
</section>