<?php
$this->breadcrumbs=array(
	'Income Report',
	
);


?>

<style>

.reportTable thead th {
	text-align: center;
	font-weight: bold;
	background-color: #eeeeee;
	vertical-align: middle;
	}

.reportTable td {
	
}

</style>
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdfobject.js"></script> -->
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdf.js"></script> -->
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/compatibility.js"></script> -->


<h4>รายงานรายได้</h4>
<form class="" id="search-form" action="/pea_track/report/income" method="get">
<div class="well">
  <div class="row-fluid">
	
	
	
  <div class="span2">
               
              <?php
                echo CHtml::label('เดือน','monthStart');  
                $list_month = array("01" => "ม.ค.", "02" => "ก.พ.", "03" => "มี.ค.","04" => "เม.ย.", "05" => "พ.ค.", "06" => "มิ.ย.","07" => "ก.ค.", "08" => "ส.ค.", "09" => "ก.ย.","10" => "ต.ค.", "11" => "พ.ย.", "12" => "ธ.ค.");
                $mm = date("m");
                echo CHtml::dropDownList('monthStart', '', 
                        $list_month,array('class'=>'span12',"options"=>array($mm=>array("selected"=>true))
                    ));
               

              ?>
    </div>
    <div class="span2">
            <?php
                
                echo CHtml::label('ปี เริ่มต้น','yearStart');  
                $yy = date("Y")+543;

                $sql = "SELECT MAX(YEAR(pj_date_approved)) as max_year,MIN(YEAR(pj_date_approved)) as min_year FROM Project WHERE  (pj_date_approved IS NOT NULL) AND (pj_date_approved != ' 
0000-00-00') AND YEAR(pj_date_approved)>2000";
                $command = Yii::app()->db->createCommand($sql);
                $result = $command->queryAll();
               
                $list_year = array();
                for ($i=$result[0]['max_year']; $i >= $result[0]['min_year']; $i--) { 
                  $list_year[$i] = $i+543;
                }


                echo CHtml::dropDownList('yearStart', '', 
                        $list_year,array('class'=>'span12',"options"=>array($yy=>array("selected"=>true))
                  
                    ));

              ?>
    </div>

    <div class="span2">
               
              <?php
                echo CHtml::label('เดือน','monthEnd');  
             
                echo CHtml::dropDownList('monthEnd', '', 
                        $list_month,array('class'=>'span12',"options"=>array($mm=>array("selected"=>true))
                    ));
               

              ?>
    </div>
    <div class="span2">
            <?php
                
                echo CHtml::label('ปี สิ้นสุด','yearEnd');  
        
                echo CHtml::dropDownList('yearEnd', '', 
                        $list_year,array('class'=>'span12',"options"=>array($yy=>array("selected"=>true))
                  
                    ));

              ?>
    </div>
	<div class="span3">
      <?php


        $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'inverse',
              'label'=>'view',
              'icon'=>'list-alt white',
              
              'htmlOptions'=>array(
                'class'=>'span4',
                'style'=>'margin:25px 10px 0px 0px;',
                'id'=>'gentReport'
              ),
          ));
      ?>
    <!-- </div> -->
    <!-- <div class="span1"> -->
      <?php
        $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'success',
              'label'=>'Excel',
              'icon'=>'excel',
              
              'htmlOptions'=>array(
                'class'=>'span4',
                'style'=>'margin:25px 10px 0px 0px;padding-left:0px;padding-right:0px',
                'id'=>'exportExcel'
              ),
          ));

    // $this->widget('bootstrap.widgets.TbButton', array(
    //           'buttonType'=>'link',
              
    //           'type'=>'info',
    //           'label'=>'',
    //           'icon'=>'print white',
              
    //           'htmlOptions'=>array(
    //             'class'=>'span3',
    //             'style'=>'margin:25px 0px 0px 0px;',
    //             'id'=>'printReport'
    //           ),
    //       ));
      ?>
    </div>
  </div>

</form>
    
</div>


<div id="printcontent" style="">
  <?php
/*
      $this->widget('bootstrap.widgets.TbGridView',array(
      'id'=>'vendor-grid',
      'dataProvider'=>$model->searchManager(),
      'type'=>'bordered condensed',
      'filter'=>$model,
      'selectableRows' =>2,
      'htmlOptions'=>array('style'=>'padding-top:40px'),
        'enablePagination' => true,
        'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
        'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
      'columns'=>array(
         'pj_name'=>array(
            'name' => 'pj_name',
            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),                     
            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
          ),
         'manager_name'=>array(
            'name' => 'manager_name',
            'header' => '<a class="sort-link">ชื่อ-นามสกุล</a>',
            'value' => function($model){
                           return $model->getManagerName($model);
                              },
            'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),                     
            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
          ),
         'pj_director_name'=>array(
            'name' => 'pj_director_name',
            //'header' => '<a class="sort-link">ชื่อ-นามสกุล</a>',
            //'value' => 'number_format($data->sumcost,2)',
            'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),                     
            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
          ),
         'position'=>array(
            //'name' => 'manager_name',
            'header' => '<a class="sort-link">ตำแหน่ง</a>',
            'value' => 'number_format($data->sumcost,2)',
            'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),                     
            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
          ),
        
        
        'pj_fiscalyear'=>array(
              'name' => 'pj_fiscalyear',
             
            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
            'htmlOptions'=>array('style'=>'text-align:center')
          ),
          'pj_cost'=>array(
              'header' => '<a class="sort-link">วงเงินรวม</a>',
              //'name'=>'cost',
              'headerHtmlOptions'=>array(),
              'value' => 'number_format($data->sumcost,2)',
              //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
            'htmlOptions'=>array('style'=>'text-align:center')
          ),
       
        
      ),
    ));
*/

  ?>


</div>


<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();

       
        $.ajax({
            url: "genIncome",
            cache:false,
            data: {monthStart:$("#monthStart").val(),yearStart:$("#yearStart").val(),monthEnd:$("#monthEnd").val(),yearEnd:$("#yearEnd").val()
              },
            success:function(response){
               
               $("#printcontent").html(response);                 
            }

        });
    
});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('printReport', '
$("#printReport").click(function(e){
    e.preventDefault();

    $.ajax({
        url: "printManager",
        data: {manager_name:$("#manager_name").val(),monthStart:$("#monthStart").val(),yearStart:$("#yearStart").val(),monthEnd:$("#monthEnd").val(),yearEnd:$("#yearEnd").val()},
        success:function(response){
            window.open("'.Yii::app()->baseUrl.'/report/temp/tempReport.pdf'.'", "_blank", "fullscreen=yes");              
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('exportExcel', '
$("#exportExcel").click(function(e){
    e.preventDefault();
    window.location.href = "IncomeExcel?monthStart="+$("#monthStart").val()+"&yearStart="+$("#yearStart").val()+"&monthEnd="+$("#monthEnd").val()+"&yearEnd="+$("#yearEnd").val();
              


});
', CClientScript::POS_END);


?>