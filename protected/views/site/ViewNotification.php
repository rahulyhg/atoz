<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<section class="container-fuild" style=" background-color:#fff;border-bottom: 1px solid #ededed;">
    <div class="overlay">
        <div class="row">
            <!-- 2-column layout -->
            <div class="container section">

            <?php
             $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'user-details-grid',
                            'dataProvider' => $dataProvider,
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
            ));
            ?>
            <?php //$this->endWidget(); ?>
            </div><!--/.container section-->
        </div>
    </div>
</section>