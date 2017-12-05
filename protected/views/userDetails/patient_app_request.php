<section class="section-details container-fuild" style="border-bottom: 1px solid #e9e9e9;"> 
<div class="container">                              		
                <div class="col-md section" style="padding:0">                                	
                    <div class="profile-note text-right" style="color:black;">
                       <a href="<?php echo $this->createUrl('userDetails/patientAppointments'); ?> "style="color:#0db7a8;">Home</a> | <a href=""style="color:#0db7a8;">Notification</a> | <a href="<?php echo $this->createUrl('userDetails/patientDetails'); ?>"style="color:#0db7a8;">Profile/Edit</a>
                    </div>
                    <?php
                   $this->renderPartial('patient_profile_view',array('PatientInfoArr' => $PatientInfoArr));
                    ?>
                    <div class="col-md-10"> 
                        <div class="col-sm-6" style="margin:0px;padding:0px;font-size:16px;font-weight: bold; color:#0db7a8;">
                            Other Details Request
                            
                        </div><div class="clearfix">&nbsp;</div>
                        <div class="table-list box-body">                      
                           
                                
                                

                                    <?php
                                    $model = new LabBookDetails;
                                 //   echo  $PatientInfoArr['user_id'];
                                    $this->widget('zii.widgets.grid.CGridView', array(
                                    'dataProvider' =>$model->getPatientRequest($PatientInfoArr['user_id']),
                                    'itemsCssClass' => 'table table-bordered  table-hover table-striped',
                                     'pagerCssClass' => 'pagination-box  center clearfix col-lg-12',
                                        'summaryText' => '',
                                        'pager' => array(
                                            'htmlOptions' => array('class' => 'list-inline'),
                                            'header' => false,
                                            'prevPageLabel' => '&lt;&lt;',
                                            'nextPageLabel' => '&gt;&gt;',
                                            'firstPageLabel' => 'First',
                                            'lastPageLabel' => 'Last',
                                        ),
                                        'columns' => array(
                                           
                                        
                                            array(
                                        'header' => 'Name',
                                        'value' => '$data->full_name ',
                                                'htmlOptions' => array("style" => "text-align:center;")
                                        ),
                                        array(
                                        'header' => 'Age',
                                        'value' => '$data->patient_age ',
                                            'htmlOptions' => array("style" => "text-align:center;")
                                        ),
                                        array(
                                        'header' => 'Center Name',
                                        'value' => '$data->hospital_name',
                                            'htmlOptions' => array("style" => "text-align:center;")
                                        ),
                                             array(
                                        'header' => 'Requested Date',
                                        'value' => '$data->created_date',
                                            'htmlOptions' => array("style" => "text-align:center;")
                                        ),
                                            
                                       
                                     ),
                                    ));
                                    ?>
                                    

                               
                            
                            
                            
                            

                            

                        </div>


                        <div class="clearfix"></div>                
                    </div> <!--col-md-10 end-->       
                </div><!--/row-->
            </div>
</section>