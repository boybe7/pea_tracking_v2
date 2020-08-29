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

      $("input[data-type='currency']").on({
              keyup: function() {
               
                formatCurrency($(this));
              },
              blur: function() { 
                formatCurrency($(this), "blur");
              }
          });


   
  });

     function calCostSummary() {
          var cost_summary = 0;
          $('.payment_type').each(function () {
              cost_summary = cost_summary + parseFloat($(this).val().replace(',',''));

          })

          $("#PaymentProjectContract_money").val(cost_summary.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
     }

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




          function formatNumber(n) {
            // format number 1000000 to 1,234,567
     
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")

          }


          function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.
            
            // get input value
            var input_val = input.val();
            
            // don't validate empty input
            if (input_val === "") { return; }
            
            // original length
            var original_len = input_val.length;

            // initial caret position 
            var caret_pos = input.prop("selectionStart");
              
            // check for decimal
            if (input_val.indexOf(".") >= 0) {

              // get position of first decimal
              // this prevents multiple decimals from
              // being entered
              var decimal_pos = input_val.indexOf(".");

              // split number by decimal point
              var left_side = input_val.substring(0, decimal_pos);
              var right_side = input_val.substring(decimal_pos);

              // add commas to left side of number
              left_side = formatNumber(left_side);

              // validate right side
              right_side = formatNumber(right_side);
              
              // On blur make sure 2 numbers after decimal
              if (blur === "blur") {
                right_side += "00";
              }
              
              // Limit decimal to only 2 digits
              right_side = right_side.substring(0, 2);

              // join number by .
              input_val = "" + left_side + "." + right_side;

            } else {
              // no decimal entered
              // add commas to number
              // remove all non-digits
              input_val = formatNumber(input_val);
              input_val = "" + input_val;
              
              // final formatting
              if (blur === "blur") {
                input_val += ".00";
              }
            }
            
            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
          }
</script> 

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'payment-project-contract-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="well">
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

  <div class="row-fluid">       
       <div class="span9">
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
           <?php echo $form->textAreaRow($model,'detail',array('rows'=>2, 'cols'=>50, 'class'=>'span12')); ?> 

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

             
            </div>   


       </div>
       <div class="span3"> 
           <?php 
              $pc = ProjectContract::model()->findByPk($model->proj_id);
              $cost = "";
              if(!empty($pc)) 
               $cost = number_format($pc->pc_cost,2);
              echo CHtml::label('วงเงินตามสัญญา','pj_cost');        
              echo "<input type='text' id='pj_cost' class='span12' style='text-align:right' disabled value='$cost'>";
           ?>
            <div class="well-blue span12">
                <div><b><u>รายการรายได้ : </u></b></div><br>
           <?php
              $type = PaymentType::model()->findAll();
              $cost_summary = 0;
              foreach ($type as $key => $value) {
                  $id = 'payment_type_'.$value->id;
                  $name = 'PaymentType['.$value->id.']';
                  $payment = PaymentDetail::model()->findAll('payment_id =:id AND payment_type_id=:type', array(':id' =>$model->id,':type'=>$value->id));
                  $cost = empty($payment) ? 0 : $payment[0]->cost;
                  $cost_summary += $cost;    
                  echo CHtml::label($value->detail, $id);    
                 
                  echo CHtml::textField($name, $cost,array('id'=>$id,'data-type'=>"currency",'class'=>'span12 payment_type','style'=>'text-align:right','onChange'=>'javascript:calCostSummary()'));    

                  //echo "<input type='text' id='$id' class='span12' style='text-align:right' value='$cost' >";
              }

           ?>
              

              <?php 
                  $cost_summary = number_format($cost_summary,2);
                  echo CHtml::label('รายได้รวม (ไม่รวมภาษีมูลค่าเพิ่ม)','PaymentProjectContract_money',array('style'=>'font-weight:bold'));
                  echo "<input type='text' id='PaymentProjectContract_money' name='PaymentProjectContract[money]' class='span12' style='text-align:right' readonly value='$cost_summary'>";


             ?>
           </div>

            <?php
                echo $form->textFieldRow($model,'fine_amount',array('class'=>'span12','style'=>'text-align:right'));
          
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