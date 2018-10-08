<?php
$this->breadcrumbs=array(
	'สรุปงานรายรับ-รายจ่ายงานโครงการ ',
	
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
#print * { visibility: visible; }


#print { position: absolute; top: 40px; left: 30px; }
}

</style>




<div class="well">
  <div class="row-fluid">
	<div class="span2">
		<?php

            $projects =Project::model()->findAll(array(
    				'select'=>'pj_fiscalyear',
            'order'=>'pj_fiscalyear ASC', 
    				//'group'=>'t.Category',
    				'distinct'=>true,
				));   

			//print_r($projects);	     
     
            $list = CHtml::listData($projects,'pj_fiscalyear','pj_fiscalyear');

            echo CHtml::label('ปีงบประมาณ','fiscalyear');  
            echo CHtml::dropDownList('fiscalyear', '', 
                            $list,
                            array('empty' => '--------','class'=>'span12'
                            	,
                            	'ajax' => array(
							                'type' => 'POST', //request type
							                'url' => CController::createUrl('ajax/getProjectList2'), //url to call.                
							                'update' => '#project', //selector to update   
							                'data' => array('year' => 'js:this.value','workcat_id' => 'js:$("#workcat").val()'),
							        )
                            	));
             	
		?>

	</div>
	<div class="span3">
		<?php

		     $user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
        {
              $workcat = Yii::app()->db->createCommand()
                    ->select('wc_id,wc_name as name')
                    ->from('work_category')
                    ->where('department_id='.$user_dept)
                    ->queryAll();
        }
        else 
        {
              $workcat = Yii::app()->db->createCommand()
                    ->select('wc_id,wc_name as name')
                    ->from('work_category')
                    ->queryAll();
        }            

     
            $list = CHtml::listData($workcat,'wc_id','name');
    
            echo CHtml::label('ประเภทงาน','workcat');  
            echo CHtml::dropDownList('workcat', '', 
                            $list,array('empty' => 'ทั้งหมด','class'=>'span12'
                            	,
                            	'ajax' => array(
							                'type' => 'POST', //request type
							                'url' => CController::createUrl('ajax/getProjectList2'), //url to call.                
							                'update' => '#project', //selector to update   
							                'data' => array('workcat_id' => 'js:this.value','year' => 'js:$("#fiscalyear").val()'),
							        )	
                            	));
             	
		?>

	</div>
	<div class="span4">
		<?php

		    
         $user_dept = Yii::app()->user->userdept;
      if(!Yii::app()->user->isExecutive())
      {
        $projects =Project::model()->findAll(array(
            'select'=>'pj_id,pj_name',
            'join'=>'LEFT JOIN user ON pj_user_create=user.u_id',
            'condition'=>'department_id='.$user_dept,
            'order'=>'pj_name ASC',
            'distinct'=>true,
        ));   
      
      }
      else{
        $projects =Project::model()->findAll(array(
            'select'=>'pj_id,pj_name',
            'order'=>'pj_name ASC',
            'distinct'=>true,
        ));   


      }
			//print_r($projects);	     
     
            $list = CHtml::listData($projects,'pj_id','pj_name');
    
            echo CHtml::label('โครงการ','project');  
            echo CHtml::dropDownList('project', '', 
                            $list,array('empty' => 'ทั้งหมด','class'=>'span12'
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

<!-- <div class="row"> -->
    <!-- <div id="reportContent" class="" style="overflow: auto;"> -->
  <div id="print">
    <div id='title' style="text-align:center" ><h4>สรุปงานรายรับ-รายจ่ายงานโครงการ ปี </h4></div> 
    <div id="reportContent" class="" style="overflow:scroll; height:600px;">
      
    </div>
    <div class="pull-right" id="dateprint"></div>
  </div>    
<!-- </div> -->
<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();
    if($("#fiscalyear").val()!="")
    { 
        $.ajax({
            url: "genSummaryCashflow",
            data: {project: $("#project").val(),fiscalyear: $("#fiscalyear").val(),workcat: $("#workcat").val()},
        
            success:function(response){
                 var now = new Date();
              
                //$("#dateprint").html(now.getDate()+"/"+now.getMonth()+"/"+now.getFullYear());
                $("#reportContent").html(response);
                
            }

        });

        $("#title").html("<h4>สรุปงานรายรับ-รายจ่ายงานโครงการ ปี "+$("#fiscalyear").val()+"</h4>");
   }
    else
    {
        js:bootbox.alert("<font color=red>!!!!กรุณาเลือกปีงบประมาณ</font>","ตกลง");
                                                                            
    }
});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('printReport', '
$("#printReport").click(function(e){
    e.preventDefault();
      
   $.ajax({
        url: "printSummaryCashflow",
        data: {project: $("#project").val(),fiscalyear: $("#fiscalyear").val(),workcat: $("#workcat").val()},
        
        success:function(response){
            
            //var success = new PDFObject({ url: "../tempReport.pdf",height: "800px" }).embed("pdf");
             window.open("../tempReport.pdf", "_blank", "fullscreen=yes");              
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('exportExcel', '
$("#exportExcel").click(function(e){
    e.preventDefault();

     window.location.href = "genSummaryCashflowExcel?project="+$("#project").val()+"&fiscalyear="+$("#fiscalyear").val()+"&workcat="+$("#workcat").val();
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