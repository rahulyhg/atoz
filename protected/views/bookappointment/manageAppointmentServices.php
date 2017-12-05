<section class="content-header">
    <h3>Services Appointment Request</h3>
</section>
<div class="tab-content"><!-- tab-content start-->
    <section class="content"> <!-- section content start -->
        <div class="row"><!-- row start-->
            <div class="col-lg-12"> <!-- column col-lg-12 start -->
                <div class="box box-warning direct-chat direct-chat-warning"> <!-- box start -->
                    <div class="box-header with-border"><!-- box header start -->
                        <?php
                        $enc_key = Yii::app()->params->enc_key;
                        $hospitalid = Yii::app()->user->id;
                        ?>
                        <div class="table-responsive">
                            <?php
                            $model->status = "Pending";
                            $this->widget('zii.widgets.grid.CGridView', array(
                                'id' => 'user-details-grid',
                                'dataProvider' => $model->getHospitalLabAppointment($hospitalid),
                                'itemsCssClass' => 'table table-bordered table-hover table-striped',
                                'summaryCssClass' => 'label btn-info info-summery',
                                'cssFile' => false,
                                'pagerCssClass' => 'text-center middlepage',
                                'pager' => array(
                                    'htmlOptions' => array('class' => 'pagination'),
                                    'header' => false,
                                    'prevPageLabel' => '&lt;&lt;',
                                    'nextPageLabel' => '&gt;&gt;',
                                    'internalPageCssClass' => '',
                                    'selectedPageCssClass' => 'active'
                                ),
                                'columns' => array(
                                    array(
                                        'header' => 'Patient Name',
                                        'value' => '$data->full_name',
                                    ),
                                    array(
                                        'header' => 'Patient Mobile',
                                        'value' => '$data->mobile_no',
                                    ),
                                    array(
                                        'header' => ' Center Name',
                                        'value' => '$data->hospital_name',
                                    ),
                                    array(
                                        'header' => 'Apt Request Date',
                                        'value' => '!empty($data->appointment_date) ? date("d-m-Y",strtotime($data->appointment_date)) : "ff"',
                                    ),
                                    array(
                                        'header' => 'BOOK APPOINTMENT',
                                        'type' => 'raw',
                                        //'value' => 'CHtml::link("Book Appointment",array("site/addHospitalAppointment","id"=>$data->center_id))',
                                        'value' => 'CHtml::link("Book Appointment",array("bookappointment/hospitalService","enquiry"=>$data->book_id))',
                                        'htmlOptions' => array("style" => "text-align:center;")
                                    ),
                                ),
                            ));
                            ?>
                        </div>
                    </div><!-- box header end -->

                </div><!-- box end -->
            </div> <!-- column col-lg-12 end -->
        </div><!--row end-->
    </section> <!-- section content End -->
</div><!-- tab-content end-->