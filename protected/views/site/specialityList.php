<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$session = new CHttpSession;
$session->open();
$baseUrl = Yii::app()->baseUrl;
$enc_key = Yii::app()->params->enc_key;

//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/bootstrap-modal.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.yiilistview_new.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ba-bbq_new.js', CClientScript::POS_END);

?>
<div class="section-body"> 
    <section id="intro" class="section-doctors">
        <div class="overlay">
            <div class="row search-banner">
                <div class="container main-text">
                    <div class="col-md-12 backward">
                        <a class="back-home" href="<?php echo Yii::app()->baseUrl;?>">Home / </a> <a class="back-sub" href="">speciality </a>  <a class="back-sub" href=""> </a>
                    </div>
                    
                    
                    
                     <div class="row">
                        <div class="col-md-2 back-backward">
                            <a class="back-title" href="">Speciality</a> 
                            <div class="underline-line"></div>
                        </div>
                        <div class="col-md-6">&nbsp;</div>
                        <div class="col-md-4 text-right rating">
                            <span>Sort By: <select class="minimal">
                                    <option>Rating</option>
                                    <option>Distance</option>
                                </select> </span> 

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div> 
<section class="container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container section">

            <?php
            $this->widget('zii.widgets.CListView', array(
                'dataProvider' => $dataProvider,
                'itemView' => '_searchspeciality',
                'summaryText' => '',
                'pagerCssClass' => 'pagination-box clearfix text-center',
                'pager' => array(
                    'htmlOptions' => array('class' => 'list-inline'),
                    'header' => false,
                    'prevPageLabel' => '&lt;&lt;',
                    'nextPageLabel' => '&gt;&gt;',
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
                ),
            ));
            ?>
            <?php //$this->endWidget(); ?>
                <span class='pull-right'><a href="">*T&amp;C apply </a> </span>
            </div><!--/.container section-->
        </div>
        

    </div>
</section>

<?php $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];?>


<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
    function checkuser(user_id)
    {
     
        var session = '<?php echo $session['user_id']; ?>';
        if (session === '') {
            
            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin",array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
        }
        else
        {
             window.location.href = '<?php echo Yii::app()->createUrl("PatientSecondopinion/create"); ?>'+ '/user_id/'+encodeURI(user_id);
        }

    }

          
</script>