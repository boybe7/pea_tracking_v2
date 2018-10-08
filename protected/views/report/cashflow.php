<?php
$this->breadcrumbs=array(
	'Cashflow Report',
	
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


<h4>รายงานสรุปรายได้/ค่าใช้จ่าย</h4>

<div class="well">
  <div class="row-fluid">
	<div class="span2">
		<?php

            $projects =Project::model()->findAll(array(
    				'select'=>'pj_fiscalyear',
    				//'group'=>'t.Category',
    				'distinct'=>true,
				));   

			//print_r($projects);	     
     
            $list = CHtml::listData($projects,'pj_fiscalyear','pj_fiscalyear');
            $fiscalyear = $projects[0]->pj_fiscalyear;
            //echo $fiscalyear;

            echo CHtml::label('ปีงบประมาณ','fiscalyear');  
            echo CHtml::dropDownList('fiscalyear', '', 
                            $list,array('class'=>'span12'
                            	,
                            	'ajax' => array(
							                'type' => 'POST', //request type
							                'url' => CController::createUrl('ajax/getProjectList'), //url to call.                
							                'update' => '#project', //selector to update   
							                'data' => array('year' => 'js:this.value','workcat_id' => 'js:$("#workcat").val()'),
							        )
                            	));
             	
		?>

	</div>
	<div class="span2">
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
							                'url' => CController::createUrl('ajax/getProjectList'), //url to call.                
							                'update' => '#project', //selector to update   
							                'data' => array('workcat_id' => 'js:this.value','year' => 'js:$("#fiscalyear").val()'),
							        )	
                            	));
             	
		?>

	</div>
	<div class="span3">
		<?php

		  //   $projects =Project::model()->findAll(array(
    // 				'select'=>'pj_id,pj_name',
    //                 'condition'=>'pj_fiscalyear='.$fiscalyear,
    // 				'distinct'=>true,
				// ));  
      $user_dept = Yii::app()->user->userdept;
      if(!Yii::app()->user->isExecutive())
      {
        $projects =Project::model()->findAll(array(
            'select'=>'pj_id,pj_name',
            'join'=>'LEFT JOIN user ON pj_user_create=user.u_id',
            'condition'=>'pj_fiscalyear='.$fiscalyear.' AND  department_id='.$user_dept,
            'order'=>'pj_name ASC',
            'distinct'=>true,
        ));   
      
      }
      else{
        $projects =Project::model()->findAll(array(
            'select'=>'pj_id,pj_name',
            'condition'=>'pj_fiscalyear='.$fiscalyear,
            'order'=>'pj_name ASC',
            'distinct'=>true,
        ));   


      }  
 

			//print_r($projects);	 
            //$projects = new Project();    
     
            $list = CHtml::listData($projects,'pj_id','pj_name');
    
            echo CHtml::label('โครงการ','project');  
            echo CHtml::dropDownList('project', '', 
                            $list,array('empty' => 'ทั้งหมด','class'=>'span12'
                            	));
             	
		?>

	</div>
  <div class="span1">
               
              <?php
                echo CHtml::label('ณ เดือน','monthEnd');  
                $list = array("1" => "ม.ค.", "2" => "ก.พ.", "3" => "มี.ค.","4" => "เม.ย.", "5" => "พ.ค.", "6" => "มิ.ย.","7" => "ก.ค.", "8" => "ส.ค.", "9" => "ก.ย.","10" => "ต.ค.", "11" => "พ.ย.", "12" => "ธ.ค.");
                $mm = date("n");
                echo CHtml::dropDownList('monthEnd', '', 
                        $list,array('class'=>'span12',"options"=>array($mm=>array("selected"=>true))
                    ));
               

              ?>
    </div>
    <div class="span1">
            <?php
                
                echo CHtml::label('ปี','yearEnd');  
                $yy = date("Y")+543;
                $list = array($yy-2=>$yy-2,$yy-1=>$yy-1,$yy=>$yy,$yy+1=>$yy+1,$yy+2=>$yy+2);
                echo CHtml::dropDownList('yearEnd', '', 
                        $list,array('class'=>'span12',"options"=>array($yy=>array("selected"=>true))
                  
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


<div id="printcontent" style=""></div>


<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '
$("#gentReport").click(function(e){
    e.preventDefault();

       
        $.ajax({
            url: "genCashflow",
            cache:false,
            data: {fiscalyear:$("#fiscalyear").val(),project: $("#project").val(),monthEnd:$("#monthEnd").val(),yearEnd:$("#yearEnd").val(),workcat:$("#workcat").val()
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
        url: "printCashflow",
        data: {fiscalyear:$("#fiscalyear").val(),project: $("#project").val(),monthEnd:$("#monthEnd").val(),yearEnd:$("#yearEnd").val(),workcat:$("#workcat").val()
              },
        success:function(response){
            window.open("../tempReport.pdf", "_blank", "fullscreen=yes");              
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('exportExcel', '
$("#exportExcel").click(function(e){
    e.preventDefault();
    window.location.href = "genCashflowExcel?fiscalyear="+$("#fiscalyear").val()+"&project="+$("#project").val()+"&monthEnd="+$("#monthEnd").val()+"&yearEnd="+$("#yearEnd").val()+"&workcat="+$("#workcat").val();
              


});
', CClientScript::POS_END);


?>