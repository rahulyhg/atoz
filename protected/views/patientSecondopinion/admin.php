<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.ba-bbq.js"></script>
<script src="<?php echo Yii::app()->baseUrl; ?>/js/jquery.yiigridview.js"></script>
<?php
/* @var $this PatientSecondopinionController */
/* @var $model PatientSecondopinion */

$this->breadcrumbs = array(
    'Patient Secondopinions' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List PatientSecondopinion', 'url' => array('index')),
    array('label' => 'Create PatientSecondopinion', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#patient-secondopinion-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('search', "
$('.sarchfield').blur(function(){
    $('#secondopinion-grid').yiiGridView('update', {
            data: $('form').serialize()
    });

    return false;
});
");
?>



<section class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">

                <h3 class="section-title">Manage Second Opinions</h3>
                <?php if (Yii::app()->user->hasFlash('Success')): ?>
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">x</span>
                        </button>
                        <div>
                            <?php echo Yii::app()->user->getFlash('Success'); ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <div class="appointment-button text-right pull-right">
                                        <?php
                                        $form = $this->beginWidget('CActiveForm', array(
                                            'action' => Yii::app()->createUrl($this->route),
                                            'method' => 'get',
                                        ));
                                        echo $form->textField($model, 'fullname', array("class" => "sarchfield","placeholder"=>"Enter Name to search"));
                                        $this->endWidget(); ?>
                                    </div>
            <div class="col-md-12 section-content">
               
                        <?php $doctorid = Yii::app()->user->id; ?>
                        <?php
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'secondopinion-grid',
                            'dataProvider' => $model->search($doctorid),
                            'itemsCssClass' => 'table table-condensed table-hover table-stiped',
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
                                    'value' => '$data->fullname ',
                                ),
                                array(
                                    'header' => 'Mobile',
                                    'value' => '$data->mobile ',
                                ),
                                array(
                                    'header' => 'Age',
                                    'value' => '$data->age ',
                                ),
                                array(
                                    'header' => 'Description',
                                    'type' => 'raw',
                                    'value' => '(strlen("$data->description")<=45)?$data->description:substr("$data->description",0,45)." "."..."',
                                ),
                                array(
                                    'header' => 'Status',
                                    'value' => '$data->status ',
                                ),
                                array(
                                    'header' => 'Feedback',
                                    'type' => 'raw',
                                    'value' => 'CHtml::link("Feedback",array("patientSecondopinion/managefeedback", "id" => base64_encode($data->user_id) ))',
                                    'htmlOptions' => array("class" => "btn-link", "style" => "text-align:center;")
                                ),
                            ),
                        ));
                        ?>
                   
            </div>
        </div>
    </div>
</section>