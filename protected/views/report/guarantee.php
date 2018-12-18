<?php
$this->breadcrumbs=array(
	'หนังสือขอคืนค้ำประกัน ',
	
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

@media print
{
body * { visibility: hidden; }
#printcontent * { visibility: visible; }
#printcontent { position: absolute; top: 40px; left: 30px; }
a[href]:after {
     content:"" !important;
}

}

</style>
<script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdfobject.js"></script>
<!-- <script type="text/javascript" src="/pea_track/themes/bootstrap/js/pdf.js"></script> -->
<script type="text/javascript" src="/pea_track/themes/bootstrap/js/compatibility.js"></script>
<script type="text/javascript">


window.onload = function (){

         //var success = new PDFObject({ url: "../test.pdf",height: "800px" }).embed("pdf");

   
     
   }; 
</script>


<h2>หนังสือขอคืนค้ำประกันสัญญา</h2>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>false,
    'type'=>'vertical',
    'htmlOptions'=>  array('class'=>'well','style'=>'margin:0 auto;padding-top:20px;'),
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row-fluid">
        
       <div class="span6"> 
        <?php 
              //echo Yii::app()->user->userdept;

              $pname = '';
              if(isset($_GET["pname"]))
                $pname = $_GET["pname"];
              echo "<input type='hidden' id='pname' name='pname' value='$pname'>";

            
  
              echo CHtml::activeHiddenField($model, 'oc_proj_id'); 
              

              $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'pj_vendor_id',
                            'id'=>'pj_vendor_id',
                            'value'=>$pname,
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('Project/GetProject').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term,
                                       
                                    },
                                    success: function (data) {
                                            response(data);

                                    }
                                })
                             }',
                            // additional javascript options for the autocomplete plugin
                            'options'=>array(
                                     'showAnim'=>'fold',
                                     'minLength'=>0,
                                     'select'=>'js: function(event, ui) {
                                        
                                           $("#pname").val(ui.item.label);
                                           $("#OutsourceContract_oc_proj_id").val(ui.item.id);
                                          
                                           $("#search-form").submit();

                                            
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span12',
                                'placeholder'=>"ค้นหาตาม ปี ชื่อโครงการ เช่น 2558 เอบีบี "
                            ),
                                  
                        ));
            

         ?>
       </div>
        <div class="span3">
          <?php

              $this->widget('bootstrap.widgets.TbButton', array(
                  'buttonType'=>'link',
                  
                  'type'=>'info',
                  'label'=>'แบบฟอร์มขอคืนค้ำฯ',
                  'icon'=>'icon-book',
                  //'url'=>array('create'),
                  'htmlOptions'=>array('class'=>'span12','style'=>'',
                      'onclick'=>'      
                            if($.fn.yiiGridView.getSelection("vendor-grid").length==0)
                                js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการ?","ตกลง");
                            else  
                            {    
                                 // window.location = page;
                                  $.ajax({
                                      type: "POST",
                                      url: "gentFormGuarantee",
                                      data: { pj_id: $("#OutsourceContract_oc_proj_id").val(), selectedID: $.fn.yiiGridView.getSelection("vendor-grid")}
                                  })
                                  .done(function( data ) {
                                     var $a = $("<a>");
                                    $a.attr("href",$.parseJSON(data).file);
                                    //console.log($.parseJSON(data).file)
                                    $("body").append($a);
                                    $a.attr("download","guarantee.xls");
                                    $a[0].click();
                                    $a.remove();
                                  });
                            }'
                ),
              )); 
          ?>
        </div>
        <div class="span3">
          <?php


                $this->widget('bootstrap.widgets.TbButton', array(
                    'buttonType'=>'link',
                    
                    'type'=>'inverse',
                    'label'=>'แบบฟอร์มขอคืนค้ำฯล่วงหน้า',
                    'icon'=>'icon-tag',
                    //'url'=>array('delAll'),
                    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
                    'htmlOptions'=>array(
                        //'data-toggle'=>'modal',
                        //'data-target'=>'#myModal',
                        'onclick'=>'      
                                   if($.fn.yiiGridView.getSelection("vendor-grid").length==0)
                                        js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการ?","ตกลง");
                                    else  
                                    {    
                                         // window.location = page;
                                          $.ajax({
                                              type: "POST",
                                              url: "gentFormAdvGuarantee",
                                              data: { pj_id: $("#OutsourceContract_oc_proj_id").val(), selectedID: $.fn.yiiGridView.getSelection("vendor-grid")}
                                          })
                                          .done(function( data ) {
                                             var $a = $("<a>");
                                            $a.attr("href",$.parseJSON(data).file);
                                            //console.log($.parseJSON(data).file)
                                            $("body").append($a);
                                            $a.attr("download","adv_guarantee.xls");
                                            $a[0].click();
                                            $a.remove();
                                          });
                                    }',
                        'class'=>'span12',
                        'style'=>'',
                    ),
                )); 


          ?>
        </div>
    </div>
    
<?php $this->endWidget(); ?>



<?php 




 $this->widget('bootstrap.widgets.TbGridView',array(
  'id'=>'vendor-grid',
  'type'=>'bordered condensed',
  'dataProvider'=>$model->search(),
  //'filter'=>$model,
  'selectableRows' =>2,
  'htmlOptions'=>array('style'=>'padding-top:40px;width:100%'),
    'enablePagination' => true,
    'enableSorting'=>true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
  'columns'=>array(
    'checkbox'=> array(
              'id'=>'selectedID',
              'class'=>'CCheckBoxColumn',
              //'selectableRows' => 2, 
             'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
               'htmlOptions'=>array(
                            'style'=>'text-align:center'

                          )           
        ),
     'code'=>array(
          'name' => 'oc_code',
          'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
        'htmlOptions'=>array('style'=>'text-align:left')
      ),
    'detail'=>array(
          'name' => 'oc_detail',
          'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),                     
        'htmlOptions'=>array('style'=>'text-align:left')
      ),
    'guarantee_date'=>array(
          'name' => 'oc_guarantee_date',
          'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
        'htmlOptions'=>array('style'=>'text-align:center')
      ),
    // 'oc_cost'=>array(
    //       'name' => 'oc_cost',
    //       'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
    //     'htmlOptions'=>array('style'=>'text-align:right')
    //   ),
    // array(
    //       'name' => 'sumpay',
    //       'value' => 'number_format($data->sumpay,2)',
    //       'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
    //     'htmlOptions'=>array('style'=>'text-align:right')
    //   ),
    array(
          'header' => '<a class="sort-link">คงเหลือจ่ายเงิน</a>',
          'value' => 'number_format($data->sumremain,2)',
          'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
        'htmlOptions'=>array('style'=>'text-align:right')
      ),
    
  ),
));



 ?>
