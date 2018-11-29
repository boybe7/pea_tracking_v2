<style type="text/css">
	
	.the-legend {
    
    font: 16px/1.6em 'Boon700',sans-serif;
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
	    $("#pj_vendor_id").autocomplete({
       
                minLength: 0
            }).bind('focus', function () {
                $(this).autocomplete("search");
      });
 
  });

    function addWorkCode(){
  
        if($("#work_code").val()!="")
        { 
         $('#tgrid').find('tbody').append('<tr id='+$("#work_code").val()+'><td width="90%">'+
                 $("#work_code").val()+
                 '</td><td style="text-align:center;width:10%;"><a href="#" onclick=deleteRow("'+$("#work_code").val()+'")><i class="icon-red icon-remove"></i></a></td></tr>');
        
         id=0;
         var code = '';
         $('#tgrid tbody tr td').each(function(key, value) {
            
                 //  console.log($(this).text())
                 if(key%2==0)  
                   code += $(this).text()+",";
                                       
               // console.log(key+":"+$(this).text())
         });
         $("#workCode").val(code.substring(0,code.length-1));
         //console.log($("#workCode").val());
         $("#work_code").val("");
        } 
    }
    function deleteRow(id){
     
         $("#tgrid tr[id='"+id+"']").remove();
         id=0;
         var code = '';
         $('#tgrid tbody tr td').each(function(key, value) {
              
                //   console.log($(this).text())
                if(key%2==0)  
                   code += $(this).text()+",";
                     
                  
              //  console.log(key+":"+$(this).text())
         });
         $("#workCode").val(code.substring(0,code.length-1));
         //console.log($("#workCode").val());
    }
</script>
	<!-- <p class="help-block">Fields with <span class="required">*</span> are required.</p> -->


<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#projTab" data-toggle="tab">โครงการ</a></li>
  </ul>

	<h4>รายละเอียดโครงการ</h4>
	<hr>
	<?php
      	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
			'id'=>'project-form',
			'enableAjaxValidation'=>false,
			'type'=>'vertical',
  			'htmlOptions'=>  array('class'=>'','style'=>''),
		)); ?>
    	

		<div style="text-align:left">กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน</div>
    <div style="text-align:left"><?php echo $form->errorSummary(array($model));?></div>
		
		<div class="row-fluid">
			<div class="well span8">
      			
      				<!-- <span style='display: block;margin-bottom: 5px;'>คู่สัญญา</span>  -->
      				
				<div class="row-fluid">
					<div class="span4">
      					<?php echo $form->textFieldRow($model,'pj_fiscalyear',array('class'=>'span12','maxlength'=>4)); ?>
    				</div>
    				<div class="span8">
      					<?php echo $form->labelEx($model,'pj_date_approved',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
    					   <?php 

      			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'pj_date_approved',
		                        'attribute'=>'pj_date_approved',
		                        'model'=>$model,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$model->pj_date_approved),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      		</div>
		      		
		    		<?php 
      				//echo $form->textFieldRow($model,'pj_work_cat',array('class'=>'span12')); 

              // $test = Yii::app()->db->createCommand()
              //       ->select('*')
              //       ->from('TempApproveTable')
              //       ->queryAll();
              // print_r($test);      


      				$workcat = Yii::app()->db->createCommand()
                    ->select('wc_id,wc_name as name')
                    ->from('work_category')
                    ->where('department_id='.Yii::app()->user->userdept)
                    ->queryAll();
     
             		$typelist = CHtml::listData($workcat,'wc_id','name');
             		echo $form->dropDownListRow($model, 'pj_work_cat', $typelist,array('class'=>'span12'), array('options' => array('pj_work_cat'=>array('selected'=>true)))); 
             

      				?>
      				<!-- <input type="hidden" name="vendor_id" id="vendor_id"> -->
      				<?php 
  						echo $form->hiddenField($model,'pj_vendor_id');
  						echo $form->labelEx($model,'pj_vendor_id',array('class'=>'span12','style'=>'text-align:left;margin-left:-1px;margin-bottom:-5px'));
    					 
  						$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'pj_vendor_id',
                            'id'=>'pj_vendor_id',
                            'value'=>$model->pj_name,
                           // 'source'=>$this->createUrl('Ajax/GetDrug'),
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('Vendor/GetVendor').'",
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
                                        
                                           //console.log(ui.item.id)
                                            $("#Project_pj_vendor_id").val(ui.item.id);
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span10'
                            ),
                                  
                        ));
						
						$this->widget('bootstrap.widgets.TbButton', array(
						    'buttonType'=>'link',
						    
						    'type'=>'success',
						    'label'=>'เพิ่มคู่สัญญา',
						    'icon'=>'plus-sign',
						    //'url'=>array('vendor/create'),
						    'htmlOptions'=>array(
						        //'data-toggle'=>'modal',
						        //'data-target'=>'#myModal',
						        'onclick'=>'js:bootbox.confirm($("#modal-body").html(),"ยกเลิก","ตกลง",
			                   			function(confirmed){
			                   	 	    console.log($(".modal-body #vendor-form").serialize());    
			                   	 			
                                			if(confirmed)
			                   	 		    {
			                   	 		    	$.ajax({
													type: "POST",
													url: "../vendor/create",
													dataType:"json",
													data: $(".modal-body #vendor-form").serialize()
													})
													.done(function( msg ) {
                            console.log(msg)
														if(msg.status=="failure")
														{
															$("#modal-body").html(msg.div);
															js:bootbox.confirm($("#modal-body").html(),"ยกเลิก","ตกลง",
								                   			function(confirmed){
								                   	 	        
								                   	 			
					                                			if(confirmed)
								                   	 		    {
								                   	 		    	$.ajax({
																		type: "POST",
																		url: "../vendor/create",
																		dataType:"json",
																		data: $(".modal-body #vendor-form").serialize()
																		})
																		.done(function( msg ) {
																			if(msg.status=="failure")
																			{
																				js:bootbox.alert("<font color=red>!!!!บันทึกไม่สำเร็จ</font>","ตกลง");
																			}
																			else{
																				js:bootbox.alert("บันทึกสำเร็จ","ตกลง");
																			}
																		});
								                   	 		    }
															})
														}
														else{
																				js:bootbox.alert("บันทึกสำเร็จ","ตกลง");
																			}
													});
			                   	 		    }
										})',
			                  
						        'class'=>'pull-right'
						    ),
						));
						
				?>
    			</div>
          <div class="row-fluid">
            <div class="span12">
             <?php 
               echo CHtml::label('เงินประมาณการค่าใช้จ่ายในการบริหารโครงการ (บาท)','expect_cost1');        
               echo "<input type='text' id='expect_cost1' name='expect_cost1' class='span6' style='text-align:right' >"; 
            ?>
            </div>
          </div>
          <div class="row-fluid">  
            <div class="span12">
             <?php 
               echo CHtml::label('เงินประมาณการค่าใช้จ่ายด้านบุคลากร (บาท)','expect_cost2');        
               echo "<input type='text' id='expect_cost2' name='expect_cost2' class='span6' style='text-align:right' >";

            ?>
            </div>
          </div>

          <div class="row-fluid">  
            <div class="span12">
             <?php 
               echo CHtml::label('เงินประมาณการค่ารับรอง (บาท)','expect_cost3');        
               echo "<input type='text' id='expect_cost3' name='expect_cost3' class='span6' style='text-align:right' >";

            ?>
            </div>
          </div>
          <div class="row-fluid">  
            <div class="span12">
            <?php echo $form->textFieldRow($model,'pj_close',array('class'=>'span12')); ?>
            </div>
          </div>
    		</div>	
			<div class="well span4">
      			<?php 
      			//echo $form->textFieldRow($model,'pj_code',array('class'=>'span10','maxlength'=>100)); 
      			echo "<span style='display: block;'>หมายเลขงาน</span>"; 
            echo CHtml::textField('work_code','',array('class'=>'span10'));

      			$this->widget('bootstrap.widgets.TbButton', array(
						    'buttonType'=>'link',
						    
						    'type'=>'success',
						    'label'=>'',
						    'icon'=>'plus-sign white',
						    //'url'=>array('vendor/create'),
						    'htmlOptions'=>array('class'=>'pull-right','onclick'=>'addWorkCode()')
						    ));	
      			?>
      			<table class="table" style="background-color: white" name="tgrid" id="tgrid" width="100%" cellpadding="0" cellspacing="0">                    
	                <tbody>
                            <?php
                                    // $workCode = Yii::app()->db->createCommand()
                                    //             ->select('code,id')
                                    //             ->from('work_code')
                                    //             ->where('pj_id=:id', array(':id'=>$model->pj_id))
                                    //             ->queryAll();
                                    // if(!empty($workCode))
                                    // {    
                                    //    echo "<tr id='".$model->pj_id."'><td>".$workCode->code."</td><td style='text-align:center'><a href='#' onclick=deleteRow('".$workCode->id."')><i class='icon-remove'></i></a></td></tr>";
                        
                                    // }
                            		 $workCodeArray = explode(",", $workcodes);
                            		 foreach ($workCodeArray as $i=>$workcode) {
                            		 	if($workcode!="")
                            		 	{ 
                            		 		echo "<tr id='".$workcode."'><td width='90%'>".$workcode."</td><td style='width:10%;text-align:center'><a href='#' onclick=deleteRow('".$workcode."')><i class='icon-red icon-remove'></i></a></td></tr>";
                        				    
                        				}
                            		 }
                            
                            	echo '<input type="hidden" name="workCode" id="workCode" value="'.$workcodes.'">';   
                            ?>
                            
                        </tbody>
                        
            </table>

            <?php echo $form->textFieldRow($model,'pj_CA',array('class'=>'span12','maxlength'=>200)); ?>
            
    		</div>
    		
    		
  		</div>
        

        
        <h4>สัญญาหลัก</h4>
        <hr>
  		<div class="row-fluid">
      <?php
        echo '<input type="hidden" id="numContract" name="numContract" value="'.$numContracts.'">';

  		$this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'success',
              'label'=>'เพิ่มสัญญา',
              'icon'=>'plus-sign',
              
              'htmlOptions'=>array(
                'class'=>'pull-right',
                'style'=>'margin:0px 10px 0px 10px;',
                'id'=>'loadContractByAjax'
              ),
          ));

         ?>
         </div>

         <div id="pj_contract">
         
          <?php

          echo  '<input type="hidden" id="num" name="num" value="'.$numContracts.'">';
          $index = 1;
          
          foreach ($contract as $id => $con):
              //print_r($con);
              $this->renderPartial('//ProjectContract/_form', array(
                  'model' => $con,
                  'index' => $index,
                  'display' => 'block'
              ));
              $index++;
          endforeach;
          ?>
      </div>
    

  			<div class="form-actions">
				<?php $this->widget('bootstrap.widgets.TbButton', array(
					'buttonType'=>'submit',
					'type'=>'primary',
					'label'=>$model->isNewRecord ? 'บันทึก' : 'บันทึก',
				)); ?>
			</div>
						
		</div>
        <?php $this->endWidget(); ?>
		
        
	</div>		
</div>	

<?php echo'<div id="modalApproveCreate"  class="approveCreate modal hide fade">';?>
<!-- <div id="modalApproveCreate"  class="approveCreate modal hide fade"> -->
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>เพิ่มข้อมูลการอนุมัติ</h3>
    </div>
    <div class="modal-body" id="bodyApproveCreate">
      <?php 
      //$model = Vendor::model()->findByPk(14);
      $model3=new ContractApproveHistoryTemp;
      
      $this->renderPartial('/contractApproveHistory/_form2',array('model'=>$model3,'index'=>$index),false); 


      ?>
    <!-- Date here: <input type="text" id="datePicker2" > -->
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalCancel2">ยกเลิก</a>
   <?php echo '<a href="#" class="btn btn-primary" id="modalSubmit2">บันทึก</a>'; ?>
    </div>
</div>

<div id="modalApprove"  class="modal hide fade">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>แก้ไขข้อมูลการอนุมัติ</h3>
    </div>
    <div class="modal-body" id="bodyApprove">
      <?php 
      //$model = Vendor::model()->findByPk(14);
      //$model3=new ContractApproveHistoryTemp;
      
      //$this->renderPartial('/contractApproveHistory/_form',array('model'=>$model3),false); 


      ?>
    <!-- Date here: <input type="text" id="datePicker2" > -->
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalCancel">ยกเลิก</a>
    <a href="#" class="btn btn-primary" id="modalSubmit">บันทึก</a>
    </div>
</div>

<div id="modalChange"  class="modal hide fade">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>แก้ไขข้อมูลรายการเพิ่ม-ลดวงเงิน</h3>
    </div>
    <div class="modal-body" id="bodyChange">
     
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalChangeCancel">ยกเลิก</a>
    <a href="#" class="btn btn-primary" id="modalChangeSubmit">บันทึก</a>
    </div>
</div>


<input type="hidden" id="pre_index">

<div id="modal-content" class="hide">
    <div id="modal-body">
<!-- put whatever you want to show up on bootbox here -->
    	<?php 
    	//$model = Vendor::model()->findByPk(14);
    	$model2=new Vendor;
      $model2->type = 'Owner';
    	$this->renderPartial('/vendor/_form2',array('model'=>$model2),false); 

    	?>
    </div>
  
    <div id="modal-body2" class="modal-body">
<!-- put whatever you want to show up on bootbox here -->
    
      <?php 
      //$model = Vendor::model()->findByPk(14);
      $model3=new ContractApproveHistoryTemp;
      
      $this->renderPartial('/contractApproveHistory/_form',array('model'=>$model3),false); 


      ?>

      
    </div>
    <div id="modal-body3">
<!-- put whatever you want to show up on bootbox here -->
      <?php 
       $model4=new ContractChangeHistoryTemp;
      
      $this->renderPartial('/contractChangeHistory/_form',array('model'=>$model4),false); 

      ?>
    </div>
</div>

<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('loadcontract', '
var _index = ' . $index . ';
var _index = $("#num").val();
$("#loadContractByAjax").click(function(e){
     var _index = $("#num").val();
     _index++;
    e.preventDefault();
    var _url = "' . Yii::app()->controller->createUrl("loadContractByAjax", array("load_for" => $this->action->id)) . '&index="+_index;
    $.ajax({
        url: _url,
        success:function(response){
            $("#pj_contract").append(response);
            $("#pj_contract .crow").last().animate({
                opacity : 1,
                left: "+0",
                height: "toggle"
            });

            //_index++;
            $("#num").val(_index);
            //console.log("add num:"+$("#num").val());
             _index = $("#num").val();
            //console.log("add index:"+_index);
             
              
              //rearrange no.
              var collection = $(".contract_no");
              for(var i=0; i<collection.length; i++){
                  var element = collection.eq(i);
                  element.html("สัญญาที่ "+(i+1));
                  //console.log(element.html());
              }                  
              
        }

    });

  
    //_index++;
});
', CClientScript::POS_END);

?>
