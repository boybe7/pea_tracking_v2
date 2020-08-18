<?php
$this->breadcrumbs=array(
	'รายงานค่ารับรองโครงการ',
	
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


<h2>รายงานค่ารับรองโครงการ</h2>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>false,
    'type'=>'vertical',
    'htmlOptions'=>  array('class'=>'well','style'=>'margin:0 auto;padding-top:20px;'),
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row-fluid">
        
       <div class="span8"> 
        <?php 
              //echo Yii::app()->user->userdept;

              $pname = '';
              if(isset($_GET["pname"]))
                $pname = $_GET["pname"];
              echo "<input type='hidden' id='pname' name='pname' value='$pname'>";

               echo "<input type='hidden' id='project' name='project' >";
  
              //echo CHtml::activeHiddenField($model, 'oc_proj_id'); 
              

              $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'pj_id',
                            'id'=>'pj_id',
                            'value'=>$pname,
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('Project/GetMProject').'",
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
                                           $("#project").val(ui.item.id);
                                            
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
        <div class="span4">
        <?php
        $this->widget('bootstrap.widgets.TbButton', array(
                  'buttonType'=>'link',
                  
                  'type'=>'inverse',
                  'label'=>'view',
                  'icon'=>'list-alt white',
                  
                  'htmlOptions'=>array(
                    'class'=>'span4',
                    //'style'=>'margin:25px 10px 0px 0px;',
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
                    'style'=>'padding-left:0px;padding-right:0px',
                    'id'=>'exportExcel',

                    'onclick'=>'      
                                  
                                          $.ajax({
                                              type: "POST",
                                              url: "gentManagementExcel",
                                              data: { pj_id: $("#project").val()}
                                          })
                                          .done(function( data ) {
                                             var $a = $("<a>");
                                            $a.attr("href",$.parseJSON(data).file);
                                            //console.log($.parseJSON(data).file)
                                            $("body").append($a);
                                            $a.attr("download","management_cost.xls");
                                            $a[0].click();
                                            $a.remove();
                                          });
                                    ',
                       
                  ),
              ));

        // $this->widget('bootstrap.widgets.TbButton', array(
        //           'buttonType'=>'link',
                  
        //           'type'=>'info',
        //           'label'=>'Print',
        //           'icon'=>'print white',
                  
        //           'htmlOptions'=>array(
        //             'class'=>'span4',
        //             //'style'=>'margin:25px 0px 0px 0px;',
        //             'id'=>'printReport'
        //           ),
        //       ));
          ?>
      </div>
    </div>
    
<?php $this->endWidget(); ?>



<div id="printcontent" style="" ></div>


<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();

    if($("#project").val()!="")
    {    
        $.ajax({
            url: "genManagement",
            cache:false,
            data: {project: $("#project").val()},
            success:function(response){
                $("#printcontent").html("");
               
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
    filename = "summary"+$.now()+".pdf";
    $.ajax({
        url: "printSummary",
        data: {project: $("#project").val(),filename:filename},
        success:function(response){
    
             window.open("../report/temp/"+filename, "_blank", "fullscreen=yes");       
        }

    });

});
', CClientScript::POS_END);




?>