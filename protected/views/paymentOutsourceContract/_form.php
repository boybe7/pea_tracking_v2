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
           c = $("#PaymentOutsourceContract_money").val().replace(/\,/g,"");
           if($.isNumeric(c))
           {
                v = c;//.format(2);
                v = parseFloat(v);
                v = v.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                $("#PaymentOutsourceContract_money").val(v);  
           } 

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
	'id'=>'payment-outsource-contract-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="well">
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	 <div class="row-fluid">       
       <div class="span7"> 
       		<?php 
        	    echo CHtml::activeHiddenField($model, 'contract_id'); 
        			echo CHtml::activeLabelEx($model, 'contract_id'); 

              $vendor = Yii::app()->db->createCommand()
                        ->select('oc_code,v_name')
                        ->from('outsource_contract pj')
                        ->join('vendor vd', 'pj.oc_vendor_id = vd.v_id')
                        ->where('pj.oc_id=:id', array(':id'=>$model->contract_id))
                        ->queryAll();
              //print_r($model) ;
        			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'pj_vendor_id',
                            'id'=>'pj_vendor_id',
                            'value'=>empty($vendor[0])? '' : $vendor[0]['oc_code']." ".$vendor[0]['v_name'],
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('OutsourceContract/GetContract').'",
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
                                           $("#PaymentOutsourceContract_contract_id").val(ui.item.id);
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
        <div class="span5"> 
	        <?php 
          $pc = OutsourceContract::model()->findByPk($model->contract_id);
          $cost = "";
          //echo $pc->oc_cost;
          if(!empty($pc)) 
           $cost = $pc->oc_cost;
	        echo CHtml::label('วงเงินตามสัญญา','pj_cost');        
	        echo "<input type='text' id='pj_cost' class='span10' style='text-align:right' disabled value='$cost'>"?>
          
       </div>
    </div>   

	<div class="row-fluid">       
       <div class="span7">
          <?php echo $form->textAreaRow($model,'detail',array('rows'=>5, 'cols'=>50, 'class'=>'span12')); ?> 
       </div>
       <div class="span5"> 
        <?php 
          echo $form->textFieldRow($model,'money',array('class'=>'span10','style'=>'text-align:right','onChange'=>'javascript:getAlert()'));

           ?>
        <div class="row-fluid">    
         
           <div class="span5"> 
           <?php 

           echo $form->labelEx($model,'approve_date',array('class'=>'span12','style'=>'text-align:left;'));
          
                    echo '<div class="input-append span12" style="margin-top:-10px;margin-left:0px;">'; //ใส่ icon ลงไป
                        $form->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'approve_date',
                            'attribute'=>'approve_date',
                            'model'=>$model,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span10', 'value'=>$model->approve_date),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

         
          ?>
          </div>
           <div class="span6"> 
           <?php 

           echo $form->textFieldRow($model,'approve_by',array('class'=>'span10','maxlength'=>200));
          
                  
         
          ?>
          </div>

          </div>
       </div>
    </div>   
	
    <div class="row-fluid">       
       <div class="span7">
          <?php echo $form->textFieldRow($model,'invoice_no',array('class'=>'span12','maxlength'=>200)); ?>
       </div>
        <div class="span5">
          <?php
            echo $form->textFieldRow($model,'fine_amount',array('class'=>'span10','style'=>'text-align:right'));
          
        ?> 
       </div>
      
       
    </div>   
	
	<div class="row-fluid">       
       <div class="span3">
          <?php echo $form->labelEx($model,'invoice_send_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
              
          <?php 

             
                    echo '<div class="input-append span11" style="margin-top:-10px;margin-left:0px;">'; //ใส่ icon ลงไป
                        $form->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'invoice_send_date',
                            'attribute'=>'invoice_send_date',
                            'model'=>$model,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span12', 'value'=>$model->invoice_send_date),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

         ?>
       </div>
       <div class="span3  offset1"> 
          <?php 
           echo $form->labelEx($model,'invoice_receive_date',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));
             
                    echo '<div class="input-append span11" style="margin-top:-10px;margin-left:0px;">'; //ใส่ icon ลงไป
                        $form->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'invoice_receive_date',
                            'attribute'=>'invoice_receive_date',
                            'model'=>$model,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span12', 'value'=>$model->invoice_receive_date),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

         
          ?>
        
       
       </div>

       <div class="span3">
           <?php
             echo $form->textFieldRow($model,'T',array('class'=>'span9','maxlength'=>3));
            //echo CHtml::label('%ความก้าวหน้าด้านเทคนิค','t_percent');        
            //echo "<input type='text' id='t_percent' name='t_percent' value='$T_percent' class='span12' >";
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