<?php
$this->breadcrumbs=array(
	'BSC Report ',
	
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


<h4>BSC Report </h4>

<div class="well">
  <div class="row-fluid">
	<div class="span3">
		<?php


                    echo CHtml::label('วันที่เริ่มต้น', 'date_start');
                    echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'date_start',
                            'id'=>'date_start',
                            'model'=>'',
                            'value'=>'',
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
        
    ?>

	</div>
  <div class="span3">
    <?php

                     echo CHtml::label('วันที่สิ้นสุด', 'date_end');
                    echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'date_end',
                            'id'=>'date_end',
                            'model'=>'',
                            'value'=>'',
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span12','autocomplete'=>'off'),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
              ?>

  </div>
	
  
	<div class="span6">
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

    $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'info',
              'label'=>'print',
              'icon'=>'print white',
              
              'htmlOptions'=>array(
                'class'=>'span3',
                'style'=>'margin:25px 0px 0px 0px;',
                'id'=>'printReport'
              ),
          ));
      ?>
	</div>
  </div>
</div>


<div id="printcontent" style="" ></div>


<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();

    if($("#date_start").val()!="" && $("#date_end").val()!="")
    {    
        $.ajax({
            url: "genBSC",
            cache:false,
            data: {date_start: $("#date_start").val(),date_end: $("#date_end").val()},
            success:function(response){
                $("#printcontent").html("");
 
               $("#printcontent").html(response);                 
            }

        });
    }
    else
    {
        js:bootbox.alert("<font color=red>!!!!กรุณาเลือกวันที่</font>","ตกลง");
                                                                            
    }
});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('printReport', '
$("#printReport").click(function(e){
    e.preventDefault();
    //window.location.href = "printSummary?project="+$("#project").val();
    //window.print();
    $.ajax({
        url: "printSummary",
        data: {project: $("#project").val()},
        success:function(response){
            
            //var success = new PDFObject({ url: "../summaryReport.pdf",height: "800px" }).embed("pdf");
             window.open("../tempReport.pdf", "_blank", "fullscreen=yes");              
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('exportExcel', '
$("#exportExcel").click(function(e){
    e.preventDefault();
    window.location.href = "genSummaryExcel?project="+$("#project").val();
    // $.ajax({
    //     url: "genExcel",
    //     data: {project: $("#project").val()},
    //     success:function(response){
            
    //         //$("#reportContent").html(response);
            
    //     }

    // });

});
', CClientScript::POS_END);


?>