<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl.'/assets/7d883f12/bootstrap-datepicker/css/datepicker.css'); 
?>

<style type="text/css">
  .error {
    font-size: 14px;
  }
  .table-bordered th {
  	text-align: center;
  	vertical-align: middle;
  }
  .tr_white {
  	background-color: white;
  }

</style>

<fieldset class="well-yellow">
        <legend class="the-legend contract_no">สัญญาที่ <?php echo ($index);?></legend>
        <?php echo CHtml::activeHiddenField($model, '[' . $index . ']pc_id'); ?>
        <div class="row-fluid">
        	<div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_code'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_code', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_code',array('class'=>'help-block error')); ?>
            </div>  
            <div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_cost'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_cost', array('size' => 20, 'maxlength' => 255,'class'=>'span12','style'=>'text-align:right')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_cost',array('class'=>'help-block error')); ?>
            </div>  
            <div class="span2">

               <?php 
                   
                    echo CHtml::activeLabelEx($model, '[' . $index . ']pc_sign_date'); 
                    echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'ProjectContract[' . $index . '][pc_sign_date]',
                            'id'=>$index.'pc_sign_date',
                            'model'=>$model,
                            'value'=>$model->pc_sign_date,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span8'),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

               ?> 
            </div>
            <div class="span2">

               <?php 
                   
                    echo CHtml::activeLabelEx($model, '[' . $index . ']pc_end_date'); 
                    echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'ProjectContract[' . $index . '][pc_end_date]',
                            'id'=>$index.'pc_end_date',
                            'model'=>$model,
                            'value'=>$model->pc_end_date,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span8'),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

               ?> 
            </div>
            <div class="span2">
            <?php
            		$this->widget('bootstrap.widgets.TbButton', array(
		              'buttonType'=>'link',
		              
		              'type'=>'danger',
		              'label'=>'ลบสัญญา',
		              'icon'=>'minus-sign',
		              
		              'htmlOptions'=>array(
		                'class'=>'pull-right',
		                'style'=>'margin:0px 10px 0px 10px;',
		                'onclick' => 'deleteContract(this, ' . $index . ')'
		              ),
		          ));

            ?>  
            </div>
        </div>
        <div class="row-fluid">
        	<div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_PO'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_PO', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_PO',array('class'=>'help-block error')); ?>
            </div>
        	<div class="span9">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_details'); ?>
              <?php echo CHtml::activeTextArea($model, '[' . $index . ']pc_details', array('rows'=>2, 'cols'=>50,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_details',array('class'=>'help-block error')); ?>
            </div>
        </div> 
        <div class="row-fluid">
        	<div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_guarantee'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_guarantee', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_guarantee',array('class'=>'help-block error')); ?>
            </div>
            <div class="span3">		  
        	  <?php  
        	        echo CHtml::activeLabelEx($model, '[' . $index . ']pc_garantee_date'); 
                    echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'ProjectContract[' . $index . '][pc_garantee_date]',
                            'id'=>$index.'pc_garantee_date',
                            'model'=>$model,
                            'value'=>$model->pc_garantee_date,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span12'),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
             ?>
            </div>  
            <div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_T_percent'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_T_percent', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_T_percent',array('class'=>'help-block error')); ?>
            </div>
	  		<div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_A_percent'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_A_percent', array('size' => 20, 'maxlength' => 255,'class'=>'span12','disabled'=>true)); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_A_percent',array('class'=>'help-block error')); ?>
            </div>
	  		
	  	</div>
	  	<div class="row-fluid">
	  		<div class="span6">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_garantee_end'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_garantee_end', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_garantee_end',array('class'=>'help-block error')); ?>
            </div>

             <div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_num_payment'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_num_payment', array('size' => 5, 'maxlength' => 5,'class'=>'span12','style'=>'text-align:right')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_num_payment',array('class'=>'help-block error')); ?>
            </div>

            <div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, '[' . $index . ']pc_name_request'); ?>
              <?php echo CHtml::activeTextField($model, '[' . $index . ']pc_name_request', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, '[' . $index . ']pc_name_request',array('class'=>'help-block error')); ?>
            </div>
	  	</div>
	  	<fieldset class="well the-fieldset">
        	<legend class="the-legend">รายละเอียดการเพิ่ม-ลดวงเงิน</legend>
        	<div class="row-fluid"> 
	        <?php	
	  		$this->widget('bootstrap.widgets.TbButton', array(
	              'buttonType'=>'link',
	              
	              'type'=>'',
	              'label'=>'เพิ่มการรายการ',
	              'icon'=>'plus-sign green',
	              
	              'htmlOptions'=>array(
	                'class'=>'pull-right',
	                'style'=>'margin:-25px 10px 10px 10px;',
	                //'onclick'=>'createApprove(' . $index . ')'
	             
				     'onclick'=>'
				           
									js:bootbox.confirm($("#modal-body4").html(),"ยกเลิก","ตกลง",
			                   			function(confirmed){
			                   	 	     
                                			if(confirmed)
			                   	 		    {

			                   	 		    	$.ajax({
													type: "POST",
													url: "../../contractChangeHistory/createTemp/' . $index . '",
													dataType:"json",
													data: $(".modal-body #contract-change-history-form").serialize()
													})									
													.done(function( msg ) {
														
														jQuery.fn.yiiGridView.update("change-grid'.$index.'");
														$("form input").each(function(){
																		             id = $(this).attr("id");
																		             //console.log(id)
																		             sessionStorage.setItem(id,$("#"+id).val());
																		            
																		        });
																				$("form textarea").each(function(){
																		             id = $(this).attr("id");
																		             //console.log("area:"+id)
																		             sessionStorage.setItem(id,$("#"+id).val());
																		            
																		        });
																				window.location.reload()
													
														
														if(msg.status=="failure")
														{
															$("#modal-body4").html(msg.div);
															js:bootbox.confirm($("#modal-body4").html(),"ยกเลิก","ตกลง",
								                   			function(confirmed){
								                   	 	        
								                   	 			
					                                			if(confirmed)
								                   	 		    {
								                   	 		    	
								                   	 		    	$.ajax({
																		type: "POST",
																		url: "../../contractChangeHistory/createTemp/' . $index . '",
																		dataType:"json",
																		//contentType:"application/json; charset=utf-8",
																		data: $(".modal-body #contract-change-history-form").serialize()
																		})
																		.done(function( msg ) {
																			if(msg.status=="failure")
																			{
																				js:bootbox.alert("<font color=red>!!!!บันทึกไม่สำเร็จ</font>","ตกลง");
																			}
																			else{
																				
																				jQuery.fn.yiiGridView.update("change-grid'.$index.'");
																				$("form input").each(function(){
																		             id = $(this).attr("id");
																		             //console.log(id)
																		             sessionStorage.setItem(id,$("#"+id).val());
																		            
																		        });
																				$("form textarea").each(function(){
																		             id = $(this).attr("id");
																		             //console.log("area:"+id)
																		             sessionStorage.setItem(id,$("#"+id).val());
																		            
																		        });
																				window.location.reload()	
																			}
																		});
								                   	 		    }
															})
														}
														else{
															//js:bootbox.alert("บันทึกสำเร็จ","ตกลง");

														}
													});
											
			                   	 		    }
										})
											
										',
			                
	              ),
	          ));

                  
				$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'change-grid'.$index,
					
				    'type'=>'bordered condensed',
					'dataProvider'=>ContractChangeHistoryTemp::model()->searchByUser($index,1,Yii::app()->user->ID),
					//'filter'=>$model,
					'selectableRows' => 2,
					'enableSorting' => false,
					'rowCssClassExpression'=>'"tr_white"',

				    // 'template'=>"{summary}{items}{pager}",
				    'htmlOptions'=>array('style'=>'padding-top:10px;'),
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
					  	    ),
					  	   
					  	    array(
								'class'=>'bootstrap.widgets.TbButtonColumn',
								'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #eeeeee'),
								'template' => '{update}   {delete}',
								// 'deleteConfirmation'=>'js:bootbox.confirm("Are you sure to want to delete")',
								'buttons'=>array(
										'delete'=>array(
											'url'=>'Yii::app()->createUrl("ContractChangeHistory/deleteTemp", array("id"=>$data->id))',	

										),
										'update'=>array(

											'url'=>'Yii::app()->createUrl("ContractChangeHistory/updateTemp", array("id"=>$data->id))',
											'options'=>array(
						                        'class'=>'updatechange',
						                    ),	
						                    'click'=>'function(){

						                    	
															link = $(this).attr("href");
															//console.log("changeTemp")

															$.ajax({
											                 type:"GET",
											                 cache: false,
											                 url:$(this).attr("href"),
											                 success:function(data){
											                 	   
											                 			 $("#bodyChange").html(data);
											                 		
											                 			 $("#modalChange").modal("show");

																	
											                 },

											                });


															$("#modalChangeSubmit").click(function(e){
     															e.preventDefault();
														       $.ajax( {
														      		type: "POST",
														      		url: link,
														      		cache: false,
														      		dataType:"json",
														      		data: $("#contract-change-history-form").serialize(),
														      		success: function( msg ) {
														        		
														        		if(msg.status=="failure")									
														        		{
																	
																			$("#contract-change-history-form").html(msg.div);
																		}
																		else{
																			$("#modalChange").modal("hide");
																		    $("#bodyChange").html();
																		}


																		//console.log($("#change-grid'.$index.'"))
																		 ajaxRequest = $(this).serialize();
																		$.fn.yiiGridView.update("change-grid'.$index.'",{data: ajaxRequest})

																		//$("#change-grid'.$index.'").yiiGridView("update");
														               
														               localStorage.setItem("lastname", "boybe"); 
														               localStorage.setItem("pc_details", $("#ProjectContract_2_pc_details").val());
																		window.location.reload(false)														        
																		//console.log($("#change-grid'.$index.'"))
																		
																		
																		$.fn.yiiGridView.update("change-grid'.$index.'");

														                
																		$("form input").each(function(){
																             id = $(this).attr("id");
																             //console.log(id)
																             sessionStorage.setItem(id,$("#"+id).val());
																            
																        });
																		$("form textarea").each(function(){
																             id = $(this).attr("id");
																             //console.log("area:"+id)
																             sessionStorage.setItem(id,$("#"+id).val());
																            
																        });
																		window.location.reload()														        
																		
														      		}
														    	} 
														    	);
																	
														    });

															$("#modalChangeCancel").click(function(e){
														    	
														    	
																$("#modalChange").modal("hide");
																$("#bodyChange").html();
																		
														    });
														

											         	return false;

						                    }',	
											
										)

									)

								
							),
						)

					));

	         ?>
	        </div>
        
		</fieldset>


	  	<fieldset class="well the-fieldset">
        	<legend class="the-legend">รายละเอียดการอนุมัติ</legend>
        	<div class="row-fluid"> 
	        <?php	

	       
	  		$this->widget('bootstrap.widgets.TbButton', array(
	              'buttonType'=>'link',
	              
	              'type'=>'',
	              'label'=>'เพิ่มการอนุมัติ',
	              'icon'=>'plus-sign green',
	              
	              'htmlOptions'=>array(
	                'class'=>'pull-right',
	                'style'=>'margin:-25px 10px 10px 10px;',
	                //'onclick'=>'createApprove(' . $index . ')'
	             
				     'onclick'=>'
				                  
							       
									js:bootbox.confirm($("#modal-body5").html(),"ยกเลิก","ตกลง",
			                   			function(confirmed){
			                   	 	        //console.log("con:"+confirmed)
			                   	 						
                                			if(confirmed)
			                   	 		    {

			                   	 		    	$.ajax({
													type: "POST",
													url: "../../contractapprovehistory/createTemp/' . $index . '",
													dataType:"json",
													data: $(".modal-body #contract-approve-history-form").serialize()
													})									
													.done(function( msg ) {
														//console.log($("#approve-grid2"));
														//console.log($("#approve-grid1"));
														jQuery.fn.yiiGridView.update("approve-grid'.$index.'");
														//($("#approve-grid' . $index . '").yiiGridView("update",{}));
														
														if(msg.status=="failure")
														{
															$("#modal-body5").html(msg.div);
															js:bootbox.confirm($("#modal-body5").html(),"ยกเลิก","ตกลง",
								                   			function(confirmed){
								                   	 	        
								                   	 			
					                                			if(confirmed)
								                   	 		    {
								                   	 		    	$.ajax({
																		type: "POST",
																		url: "../../contractapprovehistory/createTemp/' . $index . '",
																		dataType:"json",
																		data: $(".modal-body #contract-approve-history-form").serialize()
																		})
																		.done(function( msg ) {
																			if(msg.status=="failure")
																			{
																				js:bootbox.alert("<font color=red>!!!!บันทึกไม่สำเร็จ</font>","ตกลง");
																			}
																			else{
																				//js:bootbox.alert("บันทึกสำเร็จ","ตกลง");
																				jQuery.fn.yiiGridView.update("approve-grid'.$index.'");
																			}
																		});
								                   	 		    }
															})
														}
														else{
															//js:bootbox.alert("บันทึกสำเร็จ","ตกลง");

														}
													});
												//$("#approve-grid").yiiGridView("update",{});
											
			                   	 		    }
										})
											
										',
			                
	              ),
	          ));

                  
				$this->widget('bootstrap.widgets.TbGridView',array(
					'id'=>'approve-grid'.$index,
					
				    'type'=>'bordered condensed',
					'dataProvider'=>ContractApproveHistoryTemp::model()->searchByUser($index,1,Yii::app()->user->ID),
					//'filter'=>$model,
					'selectableRows' => 2,
					'enableSorting' => false,
					'rowCssClassExpression'=>'"tr_white"',

				    // 'template'=>"{summary}{items}{pager}",
				    'htmlOptions'=>array('style'=>'padding-top:10px;'),
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

								'headerHtmlOptions' => array('style' => 'width:35%;text-align:center;background-color: #eeeeee'),  	            	  		
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
					  	    ),	
					  	    array(
								'class'=>'bootstrap.widgets.TbButtonColumn',
								'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #eeeeee'),
								'template' => '{update}   {delete}',
								// 'deleteConfirmation'=>'js:bootbox.confirm("Are you sure to want to delete")',
								'buttons'=>array(
										'delete'=>array(
											'url'=>'Yii::app()->createUrl("ContractApproveHistory/deleteTemp", array("id"=>$data->id))',	

										),
										'update'=>array(

											'url'=>'Yii::app()->createUrl("ContractApproveHistory/updateTemp", array("id"=>$data->id))',
											'options'=>array(
						                        'class'=>'updateapprove',
						                    ),	
											'click'=>'function(){

															link = $(this).attr("href");

															$.ajax({
											                 type:"GET",
											                 cache: false,
											                 url:$(this).attr("href"),
											                 success:function(data){
											                 	   //console.log(link)
											                 		$("#bodyApprove").html(data);
											                 		$("#dateApprove").datepicker();
																	$("#dateApprove").datepicker("option", {dateFormat: "dd/mm/yyyy"});
											                 		$("#modalApprove").modal("show");

																	
											                 },

											                });


															$("#modalSubmit").click(function(e){
     
														       $.ajax( {
														      		type: "POST",
														      		url: link,
														      		dataType:"json",
														      		data: $("#contract-approve-history-form").serialize(),
														      		success: function( msg ) {
														        	
														        		if(msg.status=="failure")									
														        		{
																	
																			$("#contract-approve-history-form").html(msg.div);
																		}
																		else{
																			$("#modalApprove").modal("hide");
																		    $("#bodyApprove").html();
																		}
														                jQuery.fn.yiiGridView.update("approve-grid'.$index.'");
																		
														      		}
														    	} 
														    	);

														    });

															$("#modalCancel").click(function(e){
														    	
														    	
																$("#modalApprove").modal("hide");
																$("#bodyApprove").html();
																		
														    });
											         	return false;

						                    }',	
											
										)

									)

								
							),
						)

					));

	         ?>
	        </div>
        	<!-- <table class="table table-bordered">
        		<thead>
        			<th width="5%">ลำดับ </th>
        			<th width="35%">รายละเอียด</th>
        			<th width="15%">อนุมัติโดย/<br>วันที่อนุมัติ</th>        			
        			<th width="15%">วงเงิน/<br>เป็นเงินเพิ่ม</th>
        			<th width="25%">ระยะเวลาแล้วเสร็จ/<br>ระยะเลาขอขยาย</th>
        			<th width="5%">ลบ</th>
        		</thead>
        	</table> -->
		</fieldset>
        
       <?php   
          
          if(!$model->isNewRecord) 
          {
            $user = User::model()->findByPk($model->pc_user_update);  
            echo '<div class="pull-right"><b>แก้ไขล่าสุดโดย : '.$user->title.$user->firstname.'  '.$user->lastname.'</b>';
            echo '<br><b>วันที่ : '.$model->pc_last_update.'</b></div>';
          }

       ?>  


</fieldset>

<?php 

		$this->widget('application.extensions.moneymask.MMask',array(
                    'element'=>'#OutsourceContract_' . $index . '_oc_cost',
                    'currency'=>'บาท',
                    'config'=>array(
                        'symbolStay'=>true,
                        'thousands'=>',',
                        'decimal'=>'.',
                        'precision'=>2,
                    )
                ));
?> 




<?php
// $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
//       'id'=>'mydialog',
//       'options'=>array(
//           'title'=>'Update Medico',
//           'autoOpen'=>false,
//       ),
//   ));  
// $this->endWidget('zii.widgets.jui.CJuiDialog');



Yii::app()->clientScript->registerCoreScript('jquery');

Yii::app()->clientScript->registerScript('createApprove', '
var myBackup;
function createApprove(index2)
{
	
		
	if(index2!=0)
	{	
		//console.log(myBackup);
		if(myBackup!="")
		 $("body").append(myBackup);

		$("#dateApprove2").datepicker();
		$("#dateApprove2").datepicker("option", {dateFormat: "dd/mm/yyyy"});

		
		$("#modalApproveCreate").modal("show");

	
		$("#modalCancel2").click(function(e){
	    	myBackup = $("#modalApproveCreate").clone();
						$("#modalApproveCreate").modal("hide");
						$("#modalApproveCreate").removeData("modal");
						$("#modalApproveCreate").remove();
						console.log("clear modal");
	    });

	    $("#modalSubmit2").click(function(e){
	    	//e.preventDefault();
	    	//console.log($("#modalApproveCreate").html());   
      		//console.log(index2);
      		
	       		$.ajax( {
	      		type: "POST",
	      		url: "../contractapprovehistory/createTemp/"+index2,
				dataType:"json",
				//data: $(".approveCreate #contract-approve-history-form").serialize(),
	      		data: $("#contract-approve-history-form-create").serialize(),
	      		success: function( msg ) {
	        		
	        		

	        		if(msg.status=="failure")									
	        		{
						js:bootbox.alert("<font color=red>!!!!บันทึกไม่สำเร็จ</font>","ตกลง");
						$("#contract-approve-history-form").html(msg.div);
					}
					else{
						
						myBackup = $("#modalApproveCreate").clone();
						$("#modalApproveCreate").modal("hide");
						$("#modalApproveCreate").removeData("modal");
						$("#modalApproveCreate").remove();
						//console.log("clear modal");
						
						//$("#approve-grid"+index2).yiiGridView("update",{});
					}

					//console.log($("#approve-grid"))					
					$.fn.yiiGridView.update("approve-grid"+index2);
					//$.fn.yiiGridView.update("approve-grid1");
	      		}
	    		});//end ajax
			
    	});

    }

   
}

 $("input[name*=pc_cost]").maskMoney({"symbolStay":true,"thousands":",","decimal":".","precision":2,"symbol":null}) 


', CClientScript::POS_END);


///Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('delOutsource', "
function deleteContract(elm, index)
{
	js:bootbox.confirm('คุณต้องการจะลบข้อมูล?','ยกเลิก','ตกลง',
		function(confirmed){
           	if(confirmed)
           	{	
					element=$(elm).parent().parent().parent();
				    /* animate div */
				    $(element).animate(
				    {
				        opacity: 0.25,
				        left: '+=50',
				        height: 'toggle'
				    }, 0,
				    function() {
				        /* remove div */
				        $(element).remove();
				    });
				    num = $('#num').val();
				    num--;
				    //$('#num').val(num);
				    
				    //console.log('del num:'+$('#num').val());
				    //rearrange no.
		              var collection = $('.contract_no');
		              //console.log(collection);
		              for(var k=0; k<collection.length; k++){
		                  var element = collection.eq(k);
		                  element.html('สัญญาที่ '+(k+1));
		                  //console.log(element.html());
		              }
				    		                   	      
            }
            		
    });

    
}", CClientScript::POS_END);
?>

<!-- <script type="text/javascript" src="/pea_track/assets/7d883f12/bootstrap-datepicker/js/bootstrap-datepicker.js"></script> -->
