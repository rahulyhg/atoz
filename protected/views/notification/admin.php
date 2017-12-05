<?php
/* @var $this NotificationController */
/* @var $model Notification */

$this->breadcrumbs = array(
    'Notifications' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Notification', 'url' => array('index')),
    array('label' => 'Create Notification', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#notification-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<section class="page-content">
    <div class="container">
        <div class="row">
            <div class="col-md-12 wow fadeIn" data-wow-delay="0.5s">

                <h3 class="section-title">Manage Notifications</h3>

            </div>
            <div class="col-md-12 section-content">

                <div class="search-form panel panel-default" style="display:none">
                    <div class="panel-body">
                        <?php
                        $this->renderPartial('_search', array(
                            'model' => $model,
                        ));
                        ?>
                    </div>
                </div><!-- search-form -->
                <?php if (Yii::app()->user->hasFlash('Success')): ?>
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span aria-hidden="true">×</span>
                        </button>
                        <div>
                            <?php echo Yii::app()->user->getFlash('Success'); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="panel panel-primary">
                    <div class="panel-body">


                        <?php
                        $id = Yii::app()->user->id;
                        $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'notification-grid',
                            'dataProvider' => $model->search($id),
                            'itemsCssClass' => 'table table-bordered  table-hover table-striped',
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
                            //'filter'=>$model,
                            'columns' => array(
                                array(
                                    'header' => 'Name',
                                    'value' => '$data->created_by',
                                ),
                                array(
                                    'header' => 'Notification',
                                    'value' => '$data->displayNotification($data->notification,$data->viewed)',
                                    'type' => 'raw',
                                ),
                                array(
                                    'header' => 'Date',
                                    'value' => ' date("d-m-Y-h:i:A", strtotime($data->created_date))',
                                ),
                            ),
                        ));
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        setTimeout(function () {
            send_notification();
        }, 3000);
        function send_notification()
        {
            $.ajax({
                url: '<?php echo Yii::app()->createUrl("Notification/confirmNotification"); ?>',
                type: 'POST',
                data: {$view: "1"},
                success: function (data) {


                }
            });
        }
    });
</script>