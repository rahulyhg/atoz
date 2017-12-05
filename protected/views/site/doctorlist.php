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
                        <a class="back-home" href="<?=  Yii::app()->createUrl("site/index"); ?>">Home / </a> <a class="back-sub" href="<?php echo Yii::app()->createUrl("site/doctordetails");?>">Doctors / </a>  <a class="back-sub" href="<?php echo Yii::app()->createUrl("site/searchResult",array("speciality" => $speciality, "location" => "","iscity" => "Y"));?>"><?php echo $speciality;?> </a>
                    </div>

                    <!-- Start Search box -->
                    <?php  $this->renderPartial('_searchbox'); ?>
                    <!-- End Search box -->
                    <div class="row">
                        <div class="col-md-2 back-backward">
                            <a class="back-title" href=""><?php echo $speciality;?> </a>
                            <div class="underline-line"></div>
                        </div>
                        <div class="col-md-6">&nbsp;</div>
                        <div class="col-md-4 text-right rating">
                           <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'id' => 'sort-form',
                        'method' => 'get'
                    ));
                    ?>
                            <?php
                           $sortarray = array();
                           $sortarray = array("Experience" => "Experience", "Savings" => "Savings", "Rating" => "Rating", "feehighlow" => "feehighlow", "feelowhigh" => "feelowhigh");
                           ?>
                            <span>Sort By: <select class="minimal" name="sortby"  id="sort">
                                    <option value="Selecttype">Select Type</option>
                                   <?php foreach ($sortarray as $sorttype => $value) {
                                                        echo "<option value='$value' ";
                                                        if ($sortoption == $value) {
                                                            echo " selected ";
                                                        }
                                                        echo ">$value</option>";
                                                    }?>
                                </select> </span>
                             <?php $this->endWidget(); ?>
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
                'itemView' => '_searchview',
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
<!--                <span class='pull-right'><a href="" style="font-size:11px; color:grey">*T&amp;C apply </a> </span>-->
            </div><!--/.container section-->
        </div>


    </div>
</section>
<div class="container loginmodel">
    <!-- Modal -->
    <div class="modal" id="myModallogin" role="dialog">
        <div class="modal-dialog modal-sm">
            <div class="modal-content mobileno">
                <div class="modal-header" style="background-color:#0db7a8;color:#fff;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title text-center">Doctor Mobile Number</h4>
                </div>
                <div class="modal-body text-centert "style="background-color:#0db7a8;color:#fff">
                    <span id="doctormobile"></span>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="appointModal" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content appointcontent">
      </div>
    </div>
  </div>
<?php $actual_link = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$redirectUrl = Yii::app()->request->getUrl(); ?>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/select2.min.js"></script>
<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/jquery-2.2.3.min.js"></script>
<script type="text/javascript">
     var redirectUrl = '<?php echo $redirectUrl;?>';
    var action = '<?php echo $action;?>';
    var source = '<?php echo $source;?>';
   //alert(source);
    $(document).ready(function() {
        $('#sort').on('change', function() {
            var $form = $(this).closest('form');
            $("#sort-form").submit();
        });
        if(action != ""){
            if(action == "appoint") {
                showAppointment(<?php echo $param;?>);
            }
        }

        var showChar = 100;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "Show more >";
    var lesstext = "Show less";
    

    $('.more').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent" ><span >' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".morelink").click(function(){
        if($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });

   });


    function showAppointment(docid,docfee,clinicid){
       $.ajax({
            //async: false,
            type: 'POST',
            cache: false,
            url: '<?php echo Yii::app()->createUrl("site/bookappoint"); ?> ',
            data: {docid: docid,docfee:docfee,redirectUrl : redirectUrl, source : source ,clinicid:clinicid},
            success:function(data)
            {
                $(".appointcontent").html(data);
                $("#appointModal").modal("show");
            }
        });
    }
    function checkuser(mobile,user_id)
    {
        var session = '<?php echo $session['user_id']; ?>';
        if (session === '') {

            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
        }
        else
        {
            $("#doctormobile").html(mobile);
            $('#myModallogin').modal('show');
            $.ajax({
                //async: false,
                type: 'POST',
                dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/addNotification"); ?> ',
                data: {userid: user_id, module: 'site', action: 'Search Result', opertion: 'Book Appointment', notification: 'You Have successfully Book Appointment'},
            });

        }

    }
    function rate(userid,rateval)
    {

        var session = '<?php echo $session['user_id']; ?>';
        if (session === '') {

            window.location.href = "<?php echo Yii::app()->createUrl("site/getlogin", array('param1' => Yii::app()->getSecurityManager()->encrypt($actual_link, $enc_key))); ?>";
        }
        else
        {
            $.ajax({
                //async: false,
                type: 'POST',
                //dataType: 'json',
                cache: false,
                url: '<?php echo Yii::app()->createUrl("site/addRating"); ?> ',
                data: {userid: userid, rate: rateval},
                success:function(data)
                {
                    alert("Review submitted successfully Thank you For Review");
                    $('.example_'+userid).barrating('readonly', true);
                    var reviewno = parseInt($(".reviewCount_"+userid).text());
                    $(".reviewCount_"+userid).text(reviewno+1);
                }
            });

        }

    }


</script>

<style type="text/css">

.morecontent span {
    display: none;
    
}
.morelink {
    display: block;
}

</style>