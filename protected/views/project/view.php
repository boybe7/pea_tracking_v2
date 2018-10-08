<?php
$this->breadcrumbs=array(
	'Projects'=>array('index'),
	$model->pj_id,
);


?>

<h3>ข้อมูลโครงการ : <?php echo $model->pj_name." ปีงบประมาณ ".$model->pj_fiscalyear;?></h3>

<style type="text/css">
	
	.the-legend {
    
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 0;
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
}
.the-fieldset {
    background-color: whiteSmoke;
	border: 1px solid #E3E3E3;
	-webkit-border-radius: 4px;
	-moz-border-radius: 4px;
	border-radius: 4px;
	-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
	-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
	box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
}
hr {
  border-bottom: 1px solid #E3E3E3;
  margin: -5px 0 18px 0;
}

.ui-autocomplete { max-height: 180px; overflow-y: auto; overflow-x: hidden;}
</style>
<script type="text/javascript">
	
	$(function(){
        //autocomplete search on focus    	
	   
  });

    
	$('#tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('a[data-toggle="tab"]').on('shown', function (e) {
    	e.target // activated tab
    	e.relatedTarget // previous tab
    });
   
   
</script>
	<!-- <p class="help-block">Fields with <span class="required">*</span> are required.</p> -->
<div class="well">
	<ul class="nav nav-tabs">
      <?php  
        
        	echo '<li  class="active"><a href="#projTab" data-toggle="tab">โครงการ</a></li>
                 <li ><a href="#outTab" data-toggle="tab">สัญญาจ้างช่วง/ซื้อ</a></li>
                ';	
       
      ?>
        
    </ul>
        
    <div class="tab-content">
        
      <?php 

   
          echo '<div class="tab-pane active" id="projTab">';

        	
        	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
      			'id'=>'project-form',
      			'enableAjaxValidation'=>false,
      			'type'=>'vertical',
        			'htmlOptions'=>  array('class'=>'','style'=>''),
      		)); 

      ?>
     <h4>รายละเอียดโครงการ</h4>
     <hr>

		
		<div class="row-fluid">
			<div class="well span8">
      			
      				<!-- <span style='display: block;margin-bottom: 5px;'>คู่สัญญา</span>  -->
      				
				<div class="row-fluid">
					<div class="span4">
      					<?php echo $form->textFieldRow($model,'pj_fiscalyear',array('class'=>'span12','maxlength'=>4,'readonly'=>true)); ?>
    				</div>
    				<div class="span8">
      					<?php echo $form->textFieldRow($model,'pj_date_approved',array('class'=>'span6','readonly'=>true));?>
    				
		      		</div>
		      		
		    		<?php 
      				//echo $form->textFieldRow($model,'pj_work_cat',array('class'=>'span12')); 
      				$workcat = Yii::app()->db->createCommand()
                    ->select('wc_id,wc_name as name')
                    ->from('work_category')
                    ->where('wc_id=:id', array(':id'=>$model->pj_work_cat))
                    ->queryAll();
              
              $workcatName = "";
              if(!empty($workcat))
             	  $workcatName = $workcat[0]["name"];

              echo $form->labelEx($model,'pj_work_cat',array('class'=>'span12','style'=>'text-align:left;margin-left:-1px;margin-bottom:-5px'));
               
              echo CHtml::textField('pj_work_cat',$workcatName,array('class'=>'span12','readonly'=>true));
            

      				?>
      				<!-- <input type="hidden" name="vendor_id" id="vendor_id"> -->
      				<?php 
  						echo $form->hiddenField($model,'pj_vendor_id');
  						echo $form->labelEx($model,'pj_vendor_id',array('class'=>'span12','style'=>'text-align:left;margin-left:-1px;margin-bottom:-5px'));
    					 
  						$vendor = Yii::app()->db->createCommand()
                    ->select('v_name as name')
                    ->from('vendor')
                    ->where('v_id=:id', array(':id'=>$model->pj_vendor_id))
                    ->queryAll();
              
              $vendorName = "";
              if(!empty($vendor))
                $vendorName = $vendor[0]["name"];

              echo CHtml::textField('pj_vendor_id',$vendorName,array('class'=>'span12','readonly'=>true));
            
						
				      ?>
    			</div>


          <div class="row-fluid">
          <div class="span6">
           <?php 
             $mc = Yii::app()->db->createCommand()
                    ->select('mc_cost')
                    ->from('management_cost')
                    ->where('mc_proj_id=:id AND mc_in_project=1 AND mc_type=0', array(':id'=>$model->pj_id))
                    ->queryAll();

             $value = "";
             if(!empty($mc))
               $value = $mc[0]["mc_cost"];       
     
             echo CHtml::label('เงินประมาณการค่าใช้จ่ายในการบริหารโครงการ (บาท)','expect_cost1');        
             echo "<input type='text' id='expect_cost1' name='expect_cost1' class='span12' style='text-align:right' value='$value' readonly>"; 
          ?>
          </div>
          <div class="span6">
           <?php 
             $mc = Yii::app()->db->createCommand()
                    ->select('mc_cost')
                    ->from('management_cost')
                    ->where('mc_proj_id=:id AND mc_in_project=2 AND mc_type=0', array(':id'=>$model->pj_id))
                    ->queryAll();

             $value = "";
             if(!empty($mc))
              $value = $mc[0]["mc_cost"]; 
             echo CHtml::label('เงินประมาณการค่าใช้จ่ายด้านบุคลากร (บาท)','expect_cost2');        
             echo "<input type='text' id='expect_cost2' name='expect_cost2' class='span12' style='text-align:right' value='$value' readonly>";

          ?>
          </div>
          </div>
          <div class="row-fluid">
            <div class="span6">
           <?php 
             $mc = Yii::app()->db->createCommand()
                    ->select('mc_cost')
                    ->from('management_cost')
                    ->where('mc_proj_id=:id AND mc_in_project=3 AND mc_type=0', array(':id'=>$model->pj_id))
                    ->queryAll();

             $value = "";
             if(!empty($mc))
              $value = $mc[0]["mc_cost"]; 
             echo CHtml::label('เงินประมาณการค่ารับรอง (บาท)','expect_cost2');        
             echo "<input type='text' id='expect_cost2' name='expect_cost2' class='span12' style='text-align:right' value='$value' readonly>";

          ?>
          </div>
          </div>
    		</div>	
			<div class="well span4">
      			<?php 
      			//echo $form->textFieldRow($model,'pj_code',array('class'=>'span10','maxlength'=>100)); 
      			echo "<span style='display: block;'>หมายเลขงาน</span>"; 
            
      			?>
      			<table class="table table-bordered " style="background-color: #eeeeee"name="tgrid" id="tgrid" width="100%" cellpadding="0" cellspacing="0">                    
	                <tbody>
                            <?php
                                    $workCode = Yii::app()->db->createCommand()
                                                ->select('code,id')
                                                ->from('work_code')
                                                ->where('pj_id=:id', array(':id'=>$model->pj_id))
                                                ->queryAll();
                                    if(!empty($workCode))
                                    {    
                                       foreach ($workCode as $key => $value) {
                                         //print_r($value["code"]);
                                         echo "<tr><td>".$value["code"]."</td></tr>";

                                       }
                                    }else{
                                      echo "<tr><td></td></tr>";
                                    }
                            ?>
                            
                        </tbody>
                        
            </table>

             <?php echo $form->textFieldRow($model,'pj_CA',array('class'=>'span12','maxlength'=>200,'readonly'=>true)); ?>
            
    		</div>
    		
    		
  		</div>
      <h4>สัญญาหลัก</h4>
      <hr>
      <?php 
                  $project_contract = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('project_contract')
                        ->where('pc_proj_id=:id', array(':id'=>$model->pj_id))
                        ->queryAll();

            if(!empty($project_contract))
            {    
                $id = 1; 
                foreach ($project_contract as $key => $value) {
                    $modelPC =new ProjectContract;

                    //print_r($value);
                    $modelPC->attributes = $value;
                    $str_date = explode("-", $value["pc_sign_date"]);
                    if(count($str_date)>1)
                      $modelPC->pc_sign_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                    $str_date = explode("-", $value["pc_end_date"]);
                    if(count($str_date)>1)
                      $modelPC->pc_end_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                    $str_date = explode("-", $value["pc_garantee_date"]);
                    if(count($str_date)>1)
                      $modelPC->pc_garantee_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
                    $modelPC->pc_details = $value["pc_details"];
                    $modelPC->pc_PO = $value["pc_PO"];
                    $modelPC->pc_id = $value["pc_id"];
                    $modelPC->pc_last_update = $value["pc_last_update"];
                    $modelPC->pc_cost = number_format($value["pc_cost"],2);


                         //cal %A
                      //sum income;
                                $data = Yii::app()->db->createCommand()
                                ->select('sum(money) as sum')
                                ->from('payment_project_contract')
                                ->where('proj_id=:id AND (bill_date!="" AND bill_date!="0000-00-00")', array(':id'=>$modelPC->pc_id))
                                ->queryAll();
                                                          
                      $sum_income = $data[0]["sum"];

                       $data = Yii::app()->db->createCommand()
                                ->select('sum(cost) as sum')
                                ->from('contract_change_history')
                                ->where('contract_id=:id  AND type=1', array(':id'=>$modelPC->pc_id))
                                ->queryAll();
                                                          
                      $change = $data[0]["sum"];      

                      // $data = Yii::app()->db->createCommand()
                      //          ->select('sum(money) as sum')
                      //          ->from('payment_outsource_contract')
                      //          ->where('contract_id=:id AND (approve_date!="" AND approve_date!="0000-00-00")', array(':id'=>$modelPC->pc_id))
                      //          ->queryAll();
                                                          
                      // $sum_payment = $data[0]["sum"];  
                      $cost = str_replace(",", "", $modelPC->pc_cost) + $change;
                     // echo($cost);
                      $modelPC->pc_A_percent =number_format((1 - ($cost - $sum_income)/$cost)*100,2);//number_format(($cost - $sum_income)*100/$cost,2);


                    //print_r($modelPC->pc_id);
                    echo'<fieldset class="well the-fieldset">';
                    echo'  <legend class="the-legend contract_no">สัญญาที่ '.$id.'</legend>';
                    echo '<div class="row-fluid">';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_code',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_cost',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_sign_date',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_end_date',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                        echo '</div>';
                        echo '<div class="row-fluid">';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_PO',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span9">';
                          echo $form->textFieldRow($modelPC,'pc_details',array('rows'=>2, 'cols'=>50, 'class'=>'span12','readonly'=>true));
                          echo '</div>';
                         
                        echo '</div>';
                        echo '<div class="row-fluid">';
                          
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_guarantee',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_garantee_date',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_T_percent',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_A_percent',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                        echo '</div>';
                        
                        echo '<div class="row-fluid">';
                          
                          
                          echo '<div class="span6">';
                          echo $form->textFieldRow($modelPC,'pc_garantee_end',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          echo '<div class="span3">';
                          echo $form->textFieldRow($modelPC,'pc_num_payment',array('class'=>'span12','readonly'=>true));
                          echo '</div>';
                          
                        echo '</div>';
                         echo '<fieldset class="well the-fieldset">
                        <legend class="the-legend">รายละเอียดการเพิ่ม-ลดวงเงิน</legend>
                        <div class="row-fluid">'; 
                  

                            
                      $this->widget('bootstrap.widgets.TbGridView',array(
                    
                      'type'=>'bordered condensed',
                      'dataProvider'=>ContractChangeHistory::model()->searchByContractID($modelPC->pc_id,1),
                      //'filter'=>$model,
                      'selectableRows' => 2,
                      'enableSorting' => false,
                      'rowCssClassExpression'=>'"tr_white"',

                      // 'template'=>"{summary}{items}{pager}",
                      'htmlOptions'=>array('style'=>'padding-top:0px;'),
                      'enablePagination' => true,
                      'summaryText'=>'',//'Displaying {start}-{end} of {count} results.',
                      'columns'=>array(
                        'No.'=>array(
                            'header'=>'ลำดับ',
                            'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #eeeeee'),                        
                            'htmlOptions'=>array(
                                    'style'=>'text-align:center'

                              ),
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                          ),
                        'detail'=>array(
                            'name' => 'detail',

                            'headerHtmlOptions' => array('style' => 'width:35%;text-align:center;background-color: #eeeeee'),                       
                              //'headerHtmlOptions' => array('style' => 'width: 110px'),
                              'htmlOptions'=>array(
                                            'style'=>'text-align:left'

                              )
                          ),
                          'ref_no'=>array(
                          // 'header'=>'', 
                        
                              'header' => 'เลขที่หนังสืออ้างอิง',
                              'name' => 'ref_no',
                              'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #eeeeee'),                       
                              //'headerHtmlOptions' => array('style' => 'width: 110px'),
                              'htmlOptions'=>array(
                                                  'style'=>'text-align:center'

                              )
                          ),
                          'cost'=>array(
                            'header'=>'วงเงินเพิ่ม-ลด', 
                        
                            'name' => 'cost',
                        // 'type'=>'raw', //to use html tag
                            'value'=> function($data){
                                    return number_format($data->cost, 2);
                                },  
                            'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array(
                                                'style'=>'text-align:right'

                              )
                          )
                        )  

                    ));

                     
                    echo '</div></fieldset>';  





                        echo '<fieldset class="well the-fieldset">
                        <legend class="the-legend">รายละเอียดการอนุมัติ</legend>
                        <div class="row-fluid">'; 
                  

                            
                      $this->widget('bootstrap.widgets.TbGridView',array(
                    
                      'type'=>'bordered condensed',
                      'dataProvider'=>ContractApproveHistory::model()->searchByContractID($modelPC->pc_id,1),
                      //'filter'=>$model,
                      'selectableRows' => 2,
                      'enableSorting' => false,
                      'rowCssClassExpression'=>'"tr_white"',

                      // 'template'=>"{summary}{items}{pager}",
                      'htmlOptions'=>array('style'=>'padding-top:0px;'),
                      'enablePagination' => true,
                      'summaryText'=>'',//'Displaying {start}-{end} of {count} results.',
                      'columns'=>array(
                          'No.'=>array(
                              'header'=>'ลำดับ',
                              'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #eeeeee'),                        
                              'htmlOptions'=>array(
                                      'style'=>'text-align:center'

                                ),
                              'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            ),
                          'detail'=>array(
                            // 'header'=>'', 
                          
                          'name' => 'detail',

                          'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;background-color: #eeeeee'),                       
                          //'headerHtmlOptions' => array('style' => 'width: 110px'),
                          'htmlOptions'=>array(
                                              'style'=>'text-align:left'

                                )
                            ),
                            'approve by'=>array(
                            // 'header'=>'', 
                          
                          'header' => 'อนุมัติโดย/<br>ลงวันที่',
                          'type'=>'raw', //to use html tag
                          'value'=> '$data->approveBy."<br>".$data->dateApprove', 
                          'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #eeeeee'),                       
                          //'headerHtmlOptions' => array('style' => 'width: 110px'),
                          'htmlOptions'=>array(
                                              'style'=>'text-align:center'

                                )
                            ),
                            'cost'=>array(
                            'header'=>'วงเงิน/<br>เป็นเงินเพิ่ม', 
                          
                          'name' => 'cost',
                          // 'type'=>'raw', //to use html tag
                          'value'=> function($data){
                                  return number_format($data->cost, 2);
                              },  
                          'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #eeeeee'),                       
                          'htmlOptions'=>array(
                                              'style'=>'text-align:right'

                                )
                            ),
                            'time'=>array(
                            'header'=>'ระยะเวลาแล้วเสร็จ/<br>ระยะเลาขอขยาย', 
                          
                          'name' => 'timeSpend',
                          // 'type'=>'raw', //to use html tag
                            
                          'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #eeeeee'),                       
                          'htmlOptions'=>array(
                                              'style'=>'text-align:left'

                                )
                            )
                      )

                    ));

                     
                    echo '</div></fieldset>';
                    $user = User::model()->findByPk($modelPC->pc_user_update);  
                    echo '<div class="pull-right"><b>แก้ไขล่าสุดโดย : '.$user->title.$user->firstname.'  '.$user->lastname.'</b>';
                    echo '<br><b>วันที่ : '.$modelPC->pc_last_update.'</b></div>';  
                    echo'</fieldset>'; 
                    
                    $id++;  
                }
            }              
          
    
            
        ?>   
           
           


						
		</div>
        <?php $this->endWidget(); ?>
		
        <!-- tab@2  Outsource Contracts -->
		<?php 
			
				echo '<div class="tab-pane" id="outTab">';		    
		 

		    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
				'id'=>'project-form2',
				'enableAjaxValidation'=>false,
				'type'=>'vertical',
  				'htmlOptions'=>  array('class'=>'','style'=>''),
			   ));
     
          
    ?>  

	    <div id="outsource">
         
	        <?php
	     

	        $outsourceContracts = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('outsource_contract')
                        ->where('oc_proj_id=:id', array(':id'=>$model->pj_id))
                        ->queryAll();
            $index = 1;  
            if(!empty($outsourceContracts))
            {    
                $index = 1;	 
                foreach ($outsourceContracts as $key => $value) {
                	//$modelOS =new OutsourceContract;
                  //$modelOS->attributes = $value;
                  $modelOS = OutsourceContract::model()->findByPk($value["oc_id"]);



                         //cal %A
                      //sum income;
                                
                       $data = Yii::app()->db->createCommand()
                                ->select('sum(cost) as sum')
                                ->from('contract_change_history')
                                ->where('contract_id=:id  AND type=2', array(':id'=>$modelOS->oc_id))
                                ->queryAll();
                                                          
                      $change = $data[0]["sum"];      

                      $data = Yii::app()->db->createCommand()
                               ->select('sum(money) as sum')
                               ->from('payment_outsource_contract')
                               ->where('contract_id=:id AND (approve_date!="" AND approve_date!="0000-00-00")', array(':id'=>$modelOS->oc_id))
                               ->queryAll();
                                                          
                       $sum_payment = $data[0]["sum"];  
                      $cost = str_replace(",", "", $modelOS->oc_cost) + $change;
                     // echo($cost);
                      $modelOS->oc_A_percent =number_format((1 - ($cost - $sum_payment)/$cost)*100,2);//number_format(($cost - $sum_income)*100/$cost,2);



                	$this->renderPartial('//outsourceContract/_formView', array(
		                'model' => $modelOS,
		                'index' => $index,
		                'display' => 'block'
	            	));
	            	$index++;	
                }
            }

	      /*
	             
	        foreach ($outsource as $id => $child):

	            $this->renderPartial('//outsourceContract/_form', array(
	                'model' => $child,
	                'index' => $index,
	                'display' => 'block'
	            ));
	            $index++;
	        endforeach;*/
	        ?>
	    </div>
	  
   
		   
		  <?php $this->endWidget();//end form widget ?>
		</div><!--  endtab2 -->
	</div>		
</div>	

<div id="modal-content" class="hide">
    <div id="modal-body">
<!-- put whatever you want to show up on bootbox here -->
    	<?php 
    	//$model = Vendor::model()->findByPk(14);
    	$model2=new Vendor;
    	$this->renderPartial('/vendor/_form2',array('model'=>$model2),false); 

    	?>
    </div>

    <div id="modal-body-contract">
<!-- put whatever you want to show up on bootbox here -->
    	<?php 
    	//$model = Vendor::model()->findByPk(14);
    	//$modelContract = new Vendor;
    	//$this->renderPartial('/vendor/_form2',array('model'=>$model2)); 

    	?>
    </div>
</div>
<script type="text/javascript">

	var _index = $("#num").val();
	$("#loadOutsourceByAjax2").click(function(e){
	     var _index = $("#num").val();
	     _index++;
	    e.preventDefault();
	    var _url = "../loadOutsourceByAjax?load_for=create2&index="+_index;
	    $.ajax({
	        url: _url,
	        success:function(response){
	            $("#outsource").append(response);
	            $("#outsource .crow").last().animate({
	                opacity : 1,
	                left: "+0",
	                height: "toggle"
	            });

	           
	            $("#num").val(_index);
	            
	             _index = $("#num").val();
	         
	        }

	    });
	});
</script>
 
<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('loadoutsource', '
var _index = ' . $index . ';
var _index = $("#num").val();
$("#loadOutsourceByAjax").click(function(e){
     var _index = $("#num").val();
     _index++;
    e.preventDefault();
    var _url = "' . Yii::app()->controller->createUrl("loadOutsourceByAjax", array("load_for" => $this->action->id)) . '&index="+_index;
    $.ajax({
        url: _url,
        success:function(response){
            $("#outsource").append(response);
            $("#outsource .crow").last().animate({
                opacity : 1,
                left: "+0",
                height: "toggle"
            });

            //_index++;
            $("#num").val(_index);
            //console.log("add num:"+$("#num").val());
             _index = $("#num").val();
            //console.log("add index:"+_index);
        }

    });
    //_index++;
});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('delOutsource', '
$("#delOutsourceByAjax").click(function(e){
    var _index = $("#num").val();
    //console.log("del index:"+_index);
    elm = "#OutsourceContract_"+_index+"_oc_code";
    //console.log($(elm));
    element=$(elm).parent().parent().parent();
    /* animate div */

    $(element).animate(
    {
        opacity: 0.25,
        left: "+=50",
        height: "toggle"
    }, 500,
    function() {
        /* remove div */
        $(element).remove();
    });
    _index--;
    $("#num").val(_index);
    //console.log("del num:"+$("#num").val());
});
', CClientScript::POS_END);
?>