<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

$theme = Yii::app()->theme;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile( $theme->getBaseUrl() . '/js/highcharts.js' );
//$cs->registerCssFile($theme->getBaseUrl() . '/css/ProgressTracker.css');

?>



<div id="modal-content" class="hide">

    <div id="modal-body">
<!-- put whatever you want to show up on bootbox here -->
    	<?php 
    	
      
        $this->renderPartial('/notify/_content',array(),false); 

    	?>
    </div>
</div>


<?php

if(!Yii::app()->user->isExecutive())
{

	Yii::app()->clientScript->registerScript('loadnotify', '
    var _url = "'. Yii::app()->controller->createUrl("notify/getnotify").'";
    var _url2 = "'. Yii::app()->controller->createUrl("notify/content").'";
    $.ajax({
        url: _url,
        success:function(msg){

            if(msg>0)    
    			js:bootbox.alert($("#modal-body").html(),"close","รายการแจ้งเตือน");
    	}
    });			


	', CClientScript::POS_END);

}


?>

<h1>ภาพรวมโครงการ ปี <?php echo date("Y")+543;?></h1>

 <?php

        $year = date("Y")+543;
        $user_dept = Yii::app()->user->userdept;
        //echo $year;
        if(Yii::app()->user->isExecutive())
           $sql = "SELECT wc_name,wc_id FROM project LEFT JOIN work_category ON wc_id= pj_work_cat WHERE pj_fiscalyear='$year' GROUP BY pj_work_cat";
		else
		   $sql = "SELECT wc_name,wc_id FROM project LEFT JOIN work_category ON wc_id= pj_work_cat WHERE pj_fiscalyear='$year'  AND department_id='$user_dept' GROUP BY pj_work_cat";
		
		$command = Yii::app()->db->createCommand($sql);
		$workcats = $command->queryAll();	
		//echo $sql;
		//print_r($results);

		$collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); 
		$alert = array("success","info","warning","danger");
		$id = 0;
        foreach ($workcats as $key => $workcat):
        	  $wid = $workcat['wc_id'];	
	          
			  $Criteria = new CDbCriteria();
			  if(!Yii::app()->user->isExecutive())
			  {
			  	$Criteria->join = 'LEFT JOIN user ON pj_user_create=user.u_id';
			  	$Criteria->condition = "pj_work_cat='$wid' AND pj_fiscalyear='$year' AND department_id='$user_dept'";
			  }
			  else   
			    $Criteria->condition = "pj_work_cat='$wid' AND pj_fiscalyear='$year'";
			  $projects = Project::model()->findAll($Criteria);//$command->queryAll();	


			 // print_r($sql);
              echo '';
              echo '<div class="panel-group" id="accordion'.$wid.'">
					<div class="panel panel-default">
					<div class="panel-heading">
					<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$wid.'">
					  <div class="alert alert-'.$alert[$id%4].'" role="alert">'.$workcat['wc_name'].'</div>
					</a>
					</h4>
					</div>
					<div id="collapse'.$wid.'" class="panel-collapse collapse in">
					<div class="panel-body">';
			  $index = 1;			
	          foreach ($projects as $key => $project):
                 // print_r($project);     
	              $this->renderPartial('application.views.project._track', array(
	                  'model' => $project,
	                  'root'=>$id,
	                  'index'=>$index,
	                  'display' => 'block'
	              ));
	              $index++;
	          endforeach;

	          echo '</div>
   			 </div>
 		 </div>';

 		 $id++;
        endforeach;  
$this->endWidget();
        
?>
