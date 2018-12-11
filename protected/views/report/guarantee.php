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


<h4>หนังสือขอคืนค้ำประกันสัญญา</h4>




<?php
/*$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่ม โครงการ',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;'),
)); 


$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'danger',
    'label'=>'ลบ โครงการ',
    'icon'=>'minus-sign',
    //'url'=>array('delAll'),
    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
    'htmlOptions'=>array(
        //'data-toggle'=>'modal',
        //'data-target'=>'#myModal',
        'onclick'=>'      
                       if($.fn.yiiGridView.getSelection("vendor-grid").length==0)
                          js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");  
                       else   
                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
                         function(confirmed){
                            
                           //console.log("Confirmed: "+confirmed);
                           //console.log($.fn.yiiGridView.getSelection("user-grid"));
                                if(confirmed)
                           $.ajax({
                    type: "POST",
                    url: "deleteSelected",
                    data: { selectedID: $.fn.yiiGridView.getSelection("vendor-grid")}
                    })
                    .done(function( msg ) {
                      $("#vendor-grid").yiiGridView("update",{});
                    });
                        })',
        'class'=>'pull-right'
    ),
));
*/

 $this->widget('bootstrap.widgets.TbGridView',array(
  'id'=>'vendor-grid',
  'type'=>'bordered condensed',
  'dataProvider'=>$model->search(),
  'filter'=>$model,
  'selectableRows' =>2,
  'htmlOptions'=>array('style'=>'padding-top:40px'),
    'enablePagination' => true,
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
    'oc_code'=>array(
          'name' => 'oc_code',
          'filter'=>CHtml::activeTextField($model, 'oc_code',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("oc_code"))),
        'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),                     
        'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
      ),
    //'v_address',
    'oc_vendor_id'=>array(
          'name' => 'oc_vendor_id',
         
         'filter'=>CHtml::activeTextField($model, 'oc_vendor_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("oc_vendor_id"))),
        'headerHtmlOptions' => array('style' => 'width:25%;text-align:center;background-color: #f5f5f5'),                     
        'htmlOptions'=>array('style'=>'text-align:center')
      ),
    
  
    array(
      'class'=>'bootstrap.widgets.TbButtonColumn',
      'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
      'template' => '{view}',
      'buttons'=>array(
                        'guarantee' => array
                                    (
                                                        
                                        'icon'=>'icon-book',
                                        'url'=>'Yii::app()->createUrl("report/formGuarantee?id=".$data["pj_id"])',
                                        'options'=>array(
                                                         'title'=>'แบบฟอร์มคืนค้ำประกัน',
                                                            //'id'=>'$data["pj_id"]',
                                                            //'new_attribute'=> '$data["your_key"]',
                                                        ),
                                    ),
                        'adv_guarantee' => array
                                    (
                                                        
                                        'icon'=>'icon-file',
                                        'url'=>'Yii::app()->createUrl("report/formAdvGuarantee?id=".$data["pj_id"])',
                                        'options'=>array(
                                                 'title'=>'แบบฟอร์มคืนค้ำประกันล่วงหน้า'
                                                            //'id'=>'$data["id"]',
                                                            //'new_attribute'=> '$data["your_key"]',
                                                        ),
                                    ),            
            )

    ),
  ),
));





?>