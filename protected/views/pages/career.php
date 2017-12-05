<?php
$baseUrl = Yii::app()->baseUrl;
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/style_pages.css');
?>
<section class="section-details container-fuild" style="border-bottom: 1px solid #e9e9e9; padding-bottom:35px">
    <div class="overlay">
        <div class="row">
            <div class="col-md-12">
                <img src="<?php echo $baseUrl;?>/images/banner5.jpg" class="img-responsive">
            </div>
            <!-- 2-column layout -->
            <div class="row">                              		
                <div class="col-md section" style="padding:0">                               	

                    <div class="col-md-12">

                        <div class="second-opinion">
                            <div class="background_col">
                                <div class="container apoint-note text-left" style="padding-left:15px">
                                    <div class="col-md-12"><a href="<?php echo $baseUrl;?>">Home /</a> <span> Career </span> </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="container">
                                <div class="col-md-12 footer-top">

                                    <p>People who recognize the freedom they are given to make an impact and evolve the company. To attract, and nurture competent human capital through innovative and value based Human Resource Practices. We also understand that each individual has unique talents and expectations from the organization. Based on those principles, human resources development at <strong style="font-weight: 700;">AtoZ Health+</strong> is customized, flexible and well planned. </p>
                                    <p class="footer-top"><strong style="font-weight: 700;">AtoZ Health+'s</strong> wide range of businesses and exciting pace of growth presents a range of opportunities and exposure that few others can match. Employment at <strong style="font-weight: 700;">AtoZ Health+</strong> is synonymous with growth. Our people can expect that they will sharpen their talents, embrace new capabilities, and embark upon transforming leadership challenges. We give you the ability to manage your own development, providing you with the tools to chart your own career path.</p>
                                    <p class="footer-top">If you feel you can make a difference Apply Now </p>

                                    <form action="post-form.php" method="post" enctype="application/x-www-form-urlencoded">
                                        <h3 class="footer-top title wow bounceIn animated" style="font-weight:300">Career Opportunity  </h3>
                                        <div class="row footer-top">
                                            <div class="form-group col-md-4">
                                                <label for="exampleInputEmail1">Your name</label>
                                                <input type="text" class="form-control" name="sender_name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name" required>

                                            </div>   
                                            <div class="form-group col-md-4">
                                                <label for="exampleInputEmail1">Email address</label>
                                                <input type="email" class="form-control" name="sender_email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>

                                            </div>
                                            <div class="clearfix"></div>

                                            <div class="form-group col-md-4">
                                                <label for="exampleInputPassword1">Mobile No.</label>
                                                <input type="text" name="subject" class="form-control" id="exampleInputPassword1" placeholder="Mobile No." required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exampleInputPassword1">Subject</label>
                                                <input type="text" name="subject" class="form-control" id="exampleInputPassword1" placeholder="Subject" required>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="form-group col-md-4">
                                                <label for="exampleTextarea">Message </label>
                                                <textarea class="form-control" name="message" id="exampleTextarea" rows="3" required></textarea>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="exampleInputFile">upload your CV </label>
                                                <input type="file" class="form-control-file" name="my_file" id="exampleInputFile" aria-describedby="fileHelp">
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