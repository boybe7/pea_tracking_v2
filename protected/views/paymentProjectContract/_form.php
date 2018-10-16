<script type="text/javascript">
  
  $(function(){
      

      $( "input[name*='pj_vendor_id']" ).autocomplete({
       
                minLength: 0
      }).bind('focus', function () {
             //console.log("focus");
                $(this).val('');
                $(this).autocomplete("search");
                //
      });

   
  });

    

     function getAlert(){
           // v = '';
           // c = $("#PaymentProjectContract_money").val().replace(/\,/g,"");
           // if($.isNumeric(c))
           // {
           //      v = c;//.format(2);
           //      v = parseFloat(v);
           //      v = v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
           //      $("#PaymentProjectContract_money").val(v);  
           // } 

           // if($("#pj_cost").val()!='' && v != '' )
           // {

           //     cost1 = $("#pj_cost").val().replace(/\,/g,"");
           //     cost2 = $("#PaymentProjectContract_money").val().replace(/\,/g,"");
           //     //console.log(cost)
           //     dif = cost1 - cost2;
           //     $("#remain_cost").val(dif.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));   
           // }
           // else
           //     $("#remain_cost").val(""); 
          
      };
</script> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'payment-project-contract-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="well">
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	 <div class="row-fluid">       
       <div class="span8"> 
       		<?php 
        	    echo CHtml::activeHiddenField($model, 'proj_id'); 
        			echo CHtml::activeLabelEx($model, 'proj_id'); 

              $vendor = Yii::app()->db->createCommand()
                        ->select('pc_code,v_name')
                        ->from('project_contract pj')
                        ->join('vendor vd', 'pj.pc_vendor_id = vd.v_id')
                        ->where('pj.pc_id=:id', array(':id'=>$model->proj_id))
                        ->queryAll();
              //print_r($model) ;
        			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'pj_vendor_id',
                            'id'=>'pj_vendor_id',
                            'value'=>empty($vendor[0])? '' : $vendor[0]['pc_code']." ".$vendor[0]['v_name'],
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('ProjectContract/GetProjectContract').'",
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
                                           $("#PaymentProjectContract_proj_id").val(ui.item.id);
                                           $("#pj_cost").val(ui.item.cost);
                                            
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span12'
                            ),
                                  
                        ));
						

         ?>
       </div>
        <div class="span4"> 
	        <?php 
          $pc = ProjectContract::model()->findByPk($model->proj_id);
          $cost = "";
          if(!empty($pc)) 
           $cost = number_format($pc->pc_cost,2);
	        echo CHtml::label('วงเงินตามสัญญา','pj_cost');        
	        echo "<input type='text' id='pj_cost' class='span10' style='text-align:right' disabled value='$cost'>"?>
          
       </div>
    </div>   

	<div class="row-fluid">       
       <div class="span8">
          <?php echo $form->textAreaRow($model,'detail',array('rows'=>2, 'cols'=>50, 'class'=>'span12')); ?> 
       </div>
       <div class="span4"> 
          <?php echo $form->textFieldRow($model,'money',array('class'=>'span10','style'=>'text-align:right','onChange'=>'javascript:getAlert()'));

                
                $this->widget('application.extensions.moneymask.MMask',array(
                    'element'=>'#PaymentProjectContract_money',
                    'currency'=>'บาท',
                    'config'=>array(
                        'symbolStay'=>true,
                        'thousands'=>',',
                        'decimal'=>'.',
                        'precision'=>2,
                    ),

                ));
           ?>
       </div>
    </div>   
	
    <div class="row-fluid">       
       <div class="span4">
          <?php echo $form->textFieldRow($model,'invoice_no',array('class'=>'span12','maxlength'=>200)); ?>
       </div>
       <div class="span4"> 
          <?php echo $form->labelEx($model,'invoice_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
    					
          <?php 

      			 
		                echo '<div class="input-append span11" style="margin-top:-10px;margin-left:0px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'invoice_date',
		                        'attribute'=>'invoice_date',
		                        'model'=>$model,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$model->invoice_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		     ?>
       </div>
       <div class="span3">
          <?php
            echo $form->textFieldRow($model,'T',array('class'=>'span5','maxlength'=>3));
            

            //echo CHtml::label('%ความก้าวหน้าด้านเทคนิค','t_percent');        
            //echo "<input type='text' id='t_percent' name='t_percent' value='$T_percent' class='span12' >";
        ?> 
       </div>
       <!--  <div class="span4"> 
          <?php 


          // echo CHtml::label('คงเหลือจ่ายเงิน','remain_cost');        
          // echo "<input type='text' id='remain_cost' class='span10' style='text-align:right' disabled>"?>
          
       </div> -->
    </div>   
	<div class="row-fluid">       
       <div class="span4">
       <?php echo $form->textFieldRow($model,'invoice_alarm',array('class'=>'span12','maxlength'=>3)); ?>
       </div>
       <div class="span4">
       <?php echo $form->textFieldRow($model,'invoice_alarm2',array('class'=>'span12','maxlength'=>3)); ?>
       </div>
  </div>
	<div class="row-fluid">       
       <div class="span4">
          <?php echo $form->textFieldRow($model,'bill_no',array('class'=>'span12','maxlength'=>200)); ?>
       </div>
       <div class="span4"> 
          <?php echo $form->labelEx($model,'bill_date',array('class'=>'span12','style'=>'text-align:left;padding-right:0px;'));?>
    					
          <?php 

      			 
		                echo '<div class="input-append span11" style="margin-top:-10px;margin-left:0px;">'; //ใส่ icon ลงไป
		                    $form->widget('zii.widgets.jui.CJuiDatePicker',

		                    array(
		                        'name'=>'bill_date',
		                        'attribute'=>'bill_date',
		                        'model'=>$model,
		                        'options' => array(
		                                          'mode'=>'focus',
		                                          //'language' => 'th',
		                                          'format'=>'dd/mm/yyyy', //กำหนด date Format
		                                          'showAnim' => 'slideDown',
		                                          ),
		                        'htmlOptions'=>array('class'=>'span12', 'value'=>$model->bill_date),  // ใส่ค่าเดิม ในเหตุการ Update 
		                     )
		                );
		                echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

		     ?>
       </div>

       <div class="span3"> 
          <?php
            //echo $form->textFieldRow($model,'A',array('class'=>'span5','maxlength'=>3));
            

            //echo CHtml::label('%ความก้าวหน้าการเรียกเก็บเงิน','a_percent');        
	          //echo "<input type='text' id='a_percent' name='a_percent' value='$A_percent' class='span12' >";
	      ?> 
       </div>
    </div>   
	


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'บันทึก' : 'บันทึก',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
</div>