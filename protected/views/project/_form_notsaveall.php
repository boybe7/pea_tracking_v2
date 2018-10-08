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
         console.log($("#workCode").val());
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
         console.log($("#workCode").val());
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
      				$workcat = Yii::app()->db->createCommand()
                    ->select('wc_id,wc_name as name')
                    ->from('work_category')
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
			    	'onclick'=>'
                         var no = $("#numContract").val();
                         no++;
                         if(no<6)
                         {	
                           $("#numContract").val(no);                         
                           $("#contract"+no).removeClass("hide");
                         } 
			    	'
			    ),
			)); 

			$this->widget('bootstrap.widgets.TbButton', array(
			    'buttonType'=>'link',
			    
			    'type'=>'danger',
			    'label'=>'ลบสัญญา',
			    'icon'=>'minus-sign',
			    //'url'=>array('delAll'),
			    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
			    'htmlOptions'=>array(
			        //'data-toggle'=>'modal',
			        //'data-target'=>'#myModal',
			        'onclick'=>'      
								var no = $("#numContract").val();
                         		if(no>1)
                         		{
                         			$("#contract"+no).addClass("hide");
                         			no--;
                         			$("#numContract").val(no);             
                         		}
                         		

			                    ',
			        'class'=>'pull-right'
			    ),
			)); 
         ?>
         </div>
  		<?php

  		    //money format with 2 decimal  x,xxx.xx
  			$this->widget('application.extensions.moneymask.MMask',array(
                    'element'=>'#ProjectContract_0_pc_cost,#ProjectContract_1_pc_cost,#ProjectContract_2_pc_cost,#ProjectContract_3_pc_cost,#ProjectContract_4_pc_cost',
                    'currency'=>'บาท',
                    'config'=>array(
                        'symbolStay'=>true,
                        'thousands'=>',',
                        'decimal'=>'.',
                        'precision'=>2,
                    )
                ));


  		?>
  		<fieldset class="well the-fieldset">
           <legend class="the-legend">สัญญาที่ 1</legend>
           <div style="text-align:left"><?php echo $form->errorSummary(array($modelContract));?></div>
           <div class="row-fluid">
	  			<div class="span3">
	  			    <?php echo $form->textFieldRow($modelContract,'[0]pc_code',array('class'=>'span12')); ?>

	  			</div>
	  			<div class="span3">
					<?php echo $form->textFieldRow($modelContract,'[0]pc_cost',array('class'=>'span12')); ?>
	  			</div>
	  			<div class="span3">
      					<?php echo $form->labelEx($modelContract,'pc_sign_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
    					<?php 

      			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[0]pc_sign_date',
		                        'attribute'=>'[0]pc_sign_date',
		                        'model'=>$modelContract,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract->pc_sign_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
		      	<div class="span3">
      					<?php echo $form->labelEx($modelContract,'pc_end_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>    					
    					<?php       			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'pc_end_date',
		                        'attribute'=>'[0]pc_end_date',
		                        'model'=>$modelContract,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract->pc_end_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
	  		</div>
	  		<div class="row-fluid">
	  			<div class="span6">
	  			 <?php echo $form->textAreaRow($modelContract,'[0]pc_details',array('rows'=>2, 'cols'=>50, 'class'=>'span12')); ?>
	  			</div>
	  			<div class="span4">
	                  <?php echo $form->textFieldRow($modelContract,'[0]pc_guarantee',array('class'=>'span12','maxlength'=>100)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract,'[0]pc_T_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract,'[0]pc_A_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  		</div>		
        </fieldset>
        <?php 
           if($numContracts>1)
 		       echo '<fieldset id="contract2" class="well the-fieldset">';
            else
               echo '<fieldset id="contract2" class="hide well the-fieldset">';
        ?>   
           <legend class="the-legend">สัญญาที่ 2</legend>
           <div style="text-align:left"><?php echo $form->errorSummary(array($modelContract2));?></div>
           <div class="row-fluid">
	  			<div class="span3">
	  			    <?php echo $form->textFieldRow($modelContract2,'[1]pc_code',array('class'=>'span12')); ?>

	  			</div>
	  			<div class="span3">
					<?php echo $form->textFieldRow($modelContract2,'[1]pc_cost',array('class'=>'span12')); ?>
	  			</div>
	  			<div class="span3">
      					<?php echo $form->labelEx($modelContract2,'pc_sign_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
    					<?php 

      			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[1]pc_sign_date',
		                        'attribute'=>'[1]pc_sign_date',
		                        'model'=>$modelContract2,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract2->pc_sign_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
		      	<div class="span3">
      					<?php echo $form->labelEx($modelContract2,'pc_end_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>    					
    					<?php       			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[1]pc_end_date',
		                        'attribute'=>'[1]pc_end_date',
		                        'model'=>$modelContract2,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract2->pc_end_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
	  		</div>
	  		<div class="row-fluid">
	  			<div class="span6">
	  			 <?php echo $form->textAreaRow($modelContract2,'[1]pc_details',array('rows'=>2, 'cols'=>50, 'class'=>'span12')); ?>
	  			</div>
	  			<div class="span4">
	                  <?php echo $form->textFieldRow($modelContract2,'[1]pc_guarantee',array('class'=>'span12','maxlength'=>100)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract2,'[1]pc_T_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract2,'[1]pc_A_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  		</div>		
        </fieldset>


   		<?php 
           if($numContracts>2)
 		       echo '<fieldset id="contract3" class="well the-fieldset">';
            else
               echo '<fieldset id="contract3" class="hide well the-fieldset">';
        ?>   
           <legend class="the-legend">สัญญาที่ 3</legend>
           <div style="text-align:left"><?php echo $form->errorSummary(array($modelContract3));?></div>
           <div class="row-fluid">
	  			<div class="span3">
	  			    <?php echo $form->textFieldRow($modelContract3,'[2]pc_code',array('class'=>'span12')); ?>

	  			</div>
	  			<div class="span3">
					<?php echo $form->textFieldRow($modelContract3,'[2]pc_cost',array('class'=>'span12')); ?>
	  			</div>
	  			<div class="span3">
      					<?php echo $form->labelEx($modelContract3,'pc_sign_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
    					<?php 

      			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[2]pc_sign_date',
		                        'attribute'=>'[2]pc_sign_date',
		                        'model'=>$modelContract3,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract3->pc_sign_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
		      	<div class="span3">
      					<?php echo $form->labelEx($modelContract3,'pc_end_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>    					
    					<?php       			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[2]pc_end_date',
		                        'attribute'=>'[2]pc_end_date',
		                        'model'=>$modelContract3,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract3->pc_end_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
	  		</div>
	  		<div class="row-fluid">
	  			<div class="span6">
	  			 <?php echo $form->textAreaRow($modelContract3,'[2]pc_details',array('rows'=>2, 'cols'=>50, 'class'=>'span12')); ?>
	  			</div>
	  			<div class="span4">
	                  <?php echo $form->textFieldRow($modelContract3,'[2]pc_guarantee',array('class'=>'span12','maxlength'=>100)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract3,'[2]pc_T_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract3,'[2]pc_A_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  		</div>		
        </fieldset>

        <?php 
           if($numContracts>3)
 		       echo '<fieldset id="contract4" class="well the-fieldset">';
            else
               echo '<fieldset id="contract4" class="hide well the-fieldset">';
        ?>   
           <legend class="the-legend">สัญญาที่ 4</legend>
           <div style="text-align:left"><?php echo $form->errorSummary(array($modelContract4));?></div>
           <div class="row-fluid">
	  			<div class="span3">
	  			    <?php echo $form->textFieldRow($modelContract4,'[3]pc_code',array('class'=>'span12')); ?>

	  			</div>
	  			<div class="span3">
					<?php echo $form->textFieldRow($modelContract4,'[3]pc_cost',array('class'=>'span12')); ?>
	  			</div>
	  			<div class="span3">
      					<?php echo $form->labelEx($modelContract4,'pc_sign_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
    					<?php 

      			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[3]pc_sign_date',
		                        'attribute'=>'[3]pc_sign_date',
		                        'model'=>$modelContract4,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract4->pc_sign_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
		      	<div class="span3">
      					<?php echo $form->labelEx($modelContract4,'pc_end_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>    					
    					<?php       			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[3]pc_end_date',
		                        'attribute'=>'[3]pc_end_date',
		                        'model'=>$modelContract4,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract4->pc_end_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
	  		</div>
	  		<div class="row-fluid">
	  			<div class="span6">
	  			 <?php echo $form->textAreaRow($modelContract4,'[3]pc_details',array('rows'=>2, 'cols'=>50, 'class'=>'span12')); ?>
	  			</div>
	  			<div class="span4">
	                  <?php echo $form->textFieldRow($modelContract4,'[3]pc_guarantee',array('class'=>'span12','maxlength'=>100)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract4,'[3]pc_T_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract4,'[3]pc_A_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  		</div>		
        </fieldset>

        <?php 
           if($numContracts>4)
 		       echo '<fieldset id="contract5" class="well the-fieldset">';
            else
               echo '<fieldset id="contract5" class="hide well the-fieldset">';
        ?>   
           <legend class="the-legend">สัญญาที่ 5</legend>
           <div style="text-align:left"><?php echo $form->errorSummary(array($modelContract5));?></div>
           <div class="row-fluid">
	  			<div class="span3">
	  			    <?php echo $form->textFieldRow($modelContract5,'[4]pc_code',array('class'=>'span12')); ?>

	  			</div>
	  			<div class="span3">
					<?php echo $form->textFieldRow($modelContract5,'[4]pc_cost',array('class'=>'span12')); ?>
	  			</div>
	  			<div class="span3">
      					<?php echo $form->labelEx($modelContract5,'pc_sign_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
    					<?php 

      			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[4]pc_sign_date',
		                        'attribute'=>'[4]pc_sign_date',
		                        'model'=>$modelContract5,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract5->pc_sign_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
		      	<div class="span3">
      					<?php echo $form->labelEx($modelContract5,'pc_end_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>    					
    					<?php       			 
		                echo '<div class="input-append" style="margin-top:-10px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'[4]pc_end_date',
		                        'attribute'=>'[4]pc_end_date',
		                        'model'=>$modelContract5,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$modelContract5->pc_end_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		      			 ?>
		      	</div>
	  		</div>
	  		<div class="row-fluid">
	  			<div class="span6">
	  			 <?php echo $form->textAreaRow($modelContract5,'[4]pc_details',array('rows'=>2, 'cols'=>50, 'class'=>'span12')); ?>
	  			</div>
	  			<div class="span4">
	                  <?php echo $form->textFieldRow($modelContract5,'[4]pc_guarantee',array('class'=>'span12','maxlength'=>100)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract5,'[4]pc_T_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  			<div class="span1">
	  			      <?php echo $form->textFieldRow($modelContract5,'[4]pc_A_percent',array('class'=>'span12','maxlength'=>3)); ?>
	  			</div>
	  		</div>		
        </fieldset>
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

<div id="modal-content" class="hide">
    <div id="modal-body">
<!-- put whatever you want to show up on bootbox here -->
    	<?php 
    	//$model = Vendor::model()->findByPk(14);
    	$model2=new Vendor;
    	$this->renderPartial('/vendor/_form2',array('model'=>$model2),false); 

    	?>
    </div>

</div>

