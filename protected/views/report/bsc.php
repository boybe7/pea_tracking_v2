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
	<div class="span2">
		<?php

                    echo CHtml::label('เดือน-ปี เริ่มต้น', 'month_start');
                    echo CHtml::dropDownList('month_start', '', 
                              array(1=>'มกราคม',2=>'กุมภาพันธ์',3=>'มีนาคม',4=>'เมษายน',5=>'พฤษภาคม',6=>'มิถุนายน',7=>'กรกฎาคม',8=>'สิงหาคม',9=>'กันยายน',10=>'ตุลาคม',11=>'พฤศจิกายน',12=>'ธันวาคม'),
                              array('class'=>'span12'));
              ?>

	</div>
  <div class="span1">
    <?php

                    echo CHtml::label('&nbsp;', 'year_start');
                    $list = array();
                    for ($i=2551; $i <= date("Y")+543 ; $i++) { 
                        $list[] = $i;
                    }
                    echo CHtml::dropDownList('year_start', '', 
                              $list,
                              array('class'=>'span12'));
              ?>

  </div>
	<div class="span2">
    <?php

                    echo CHtml::label('เดือน-ปี สิ้นสุด', 'month_end');
                    echo CHtml::dropDownList('month_end', '', 
                              array(1=>'มกราคม',2=>'กุมภาพันธ์',3=>'มีนาคม',4=>'เมษายน',5=>'พฤษภาคม',6=>'มิถุนายน',7=>'กรกฎาคม',8=>'สิงหาคม',9=>'กันยายน',10=>'ตุลาคม',11=>'พฤศจิกายน',12=>'ธันวาคม'),
                              array('class'=>'span12'));
              ?>

  </div>
  <div class="span1">
    <?php

                    echo CHtml::label('&nbsp;', 'year_end');
                    $list = array();
                    for ($i=2551; $i <= date("Y")+543 ; $i++) { 
                        $list[] = $i;
                    }
                    echo CHtml::dropDownList('year_end', '', 
                              $list,
                              array('class'=>'span12'));
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

    $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'info',
              'label'=>'',
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

    if($("#project").val()!="")
    {    
        $.ajax({
            url: "genSummary",
            cache:false,
            data: {project: $("#project").val()},
            success:function(response){
                $("#printcontent").html("");
                //var success = new PDFObject({ url: "../summaryReport.pdf",height: "800px" }).embed("printcontent");
                
               $("#printcontent").html(response);                 
            }

        });
    }
    else
    {
        js:bootbox.alert("<font color=red>!!!!กรุณาเลือกโครงการ</font>","ตกลง");
                                                                            
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