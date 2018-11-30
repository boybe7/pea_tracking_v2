
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'subcontract-temp-form',
	'type'=>'inline',
	'enableAjaxValidation'=>false,
	

)); ?>
   <h3>เพิ่มข้อมูลสัญญาจ้างต่อย่อย</h3>

	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row-fluid">
            <div class="row-fluid">
        	  <div class="span3">		  
        	  <?php echo CHtml::activeLabelEx($model, 'oc_code'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_code', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_code',array('class'=>'help-block error')); ?>
            </div>  
            <div class="span5">
        		  <?php
                    echo CHtml::activeHiddenField($model, 'oc_vendor_id'); 
                    echo CHtml::activeLabelEx($model, 'oc_vendor_id'); 


                    $vendor = Yii::app()->db->createCommand()
                        ->select('v_name')
                        ->from('vendor')
                        ->where('v_id=:id', array(':id'=>$model->oc_vendor_id))
                        ->queryAll();
                    
                    $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'oc_vendor_id_temp',
                            'id'=>'oc_vendor_id_temp',
                            'value'=> empty($vendor[0])? '' : $vendor[0]['v_name'],
                           // 'source'=>$this->createUrl('Ajax/GetDrug'),
                           'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.$this->createUrl('Vendor/GetSupplier').'",
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
                                           $("#OutsourceContract_oc_vendor_id_temp").val(ui.item.id);
                                     }'
                                    
                                     
                            ),
                           'htmlOptions'=>array(

                                'class'=>$model->hasErrors('oc_vendor_id')?'span12 error':'span12'
                            ),
                                  
                        ));
?>
            </div>
            <div class="span4">     
              <?php echo CHtml::activeLabelEx($model, 'oc_cost'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_cost', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_cost',array('class'=>'help-block error')); ?>          
          </div>  
        </div>

        <div class="row-fluid">
            <div class="span3">     
              <?php echo CHtml::activeLabelEx($model, 'oc_PO'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_PO', array('size' => 200, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_PO',array('class'=>'help-block error')); ?>
            </div>
            <div class="span7">     
              <?php echo CHtml::activeLabelEx($model, 'oc_detail'); ?>
              <?php echo CHtml::activeTextArea($model, 'oc_detail', array('rows' => 2, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_detail',array('class'=>'help-block error')); ?>          
            </div>
            <div class="span2">
               <?php 
                   
                    echo CHtml::activeLabelEx($model, 'oc_sign_date'); 
                    echo '<div class="input-append" style="margin-top:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract_oc_sign_date',
                            'id'=>'oc_sign_date',
                            'model'=>$model,
                            'value'=>$model->oc_sign_date,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span8  d-picker'),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';

               ?> 
            </div>  
        </div>    
        
        <div class="row-fluid">
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_guarantee'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_guarantee', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_guarantee',array('class'=>'help-block error')); ?>          
          </div>  
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_adv_guarantee'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_adv_guarantee', array( 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_adv_guarantee',array('class'=>'help-block error')); ?>          
          </div>
          <div class="span2">

               <?php 
                   
                    echo CHtml::activeLabelEx($model, 'oc_end_date'); 
                    echo '<div class="input-append" style="">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract[oc_end_date]',
                            'id'=>'oc_end_date',
                            'model'=>$model,
                            'value'=>$model->oc_end_date,
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
                    echo CHtml::error($model, 'oc_end_date',array('class'=>'help-block error'));

               ?> 
          </div> 
           
        </div>
        <div class="row-fluid">
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_guarantee_cf'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_guarantee_cf', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_guarantee_cf',array('class'=>'help-block error')); ?>          
          </div>  
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_adv_guarantee_cf'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_adv_guarantee_cf', array( 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_adv_guarantee_cf',array('class'=>'help-block error')); ?>          
          </div> 
          <div class="span2">

               <?php 

                    echo CHtml::activeLabelEx($model, 'oc_approve_date'); 
                    echo '<div class="input-append" style="margin-top:0px;margin-left:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract[oc_approve_date]',
                            'id'=>'oc_approve_date',
                            'model'=>$model,
                            'value'=>$model->oc_approve_date,
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
        </div>
        <div class="row-fluid">
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_insurance'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_insurance', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_insurance',array('class'=>'help-block error')); ?>          
          </div>  
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_letter'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_letter', array( 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_letter',array('class'=>'help-block error')); ?>          
          </div> 
        </div>


        //------//
        <div class="row-fluid">
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_guarantee'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_guarantee', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_guarantee',array('class'=>'help-block error')); ?>          
          </div>  
       
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_adv_guarantee'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_adv_guarantee', array( 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_adv_guarantee',array('class'=>'help-block error')); ?>          
          </div>
          <div class="span2">

               <?php 
                   
                    echo CHtml::activeLabelEx($model, 'oc_end_date'); 
                    echo '<div class="input-append" style="">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract[oc_end_date]',
                            'id'=>'oc_end_date',
                            'model'=>$model,
                            'value'=>$model->oc_end_date,
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
                    echo CHtml::error($model, 'oc_end_date',array('class'=>'help-block error'));

               ?> 
          </div> 
           
        </div>

        <div class="row-fluid">
         
          <div class="span2">     
              <?php 
                   
                    echo CHtml::activeLabelEx($model, 'oc_guarantee_date'); 
                    echo '<div class="input-append" style="">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract[oc_guarantee_date]',
                            'id'=>'oc_guarantee_date',
                            'model'=>$model,
                            'value'=>$model->oc_guarantee_date,
                            'options' => array(
                                              'mode'=>'focus',
                                              //'language' => 'th',
                                              'format'=>'dd/mm/yyyy', //กำหนด date Format
                                              'showAnim' => 'slideDown',
                                              ),
                            'htmlOptions'=>array('class'=>'span9'),  // ใส่ค่าเดิม ในเหตุการ Update 
                         )
                    );
                    echo '<span class="add-on"><i class="icon-calendar"></i></span></div>';
                    echo CHtml::error($model, 'oc_guarantee_date',array('class'=>'help-block error'));

               ?>           
          </div> 
           <div class="span8">     
              <?php echo CHtml::activeLabelEx($model, 'oc_guarantee_end'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_guarantee_end', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_guarantee_end',array('class'=>'help-block error')); ?>          
          </div>  
          <div class="span2">

               <?php 

                    echo CHtml::activeLabelEx($model, 'oc_approve_date'); 
                    echo '<div class="input-append" style="margin-top:0px;margin-left:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract[oc_approve_date]',
                            'id'=>'oc_approve_date',
                            'model'=>$model,
                            'value'=>$model->oc_approve_date,
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
        </div>
        <div class="row-fluid">
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_guarantee_cf'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_guarantee_cf', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_guarantee_cf',array('class'=>'help-block error')); ?>          
          </div>  
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_adv_guarantee_cf'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_adv_guarantee_cf', array( 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_adv_guarantee_cf',array('class'=>'help-block error')); ?>          
          </div> 
          <div class="span2">     
              <?php echo CHtml::activeLabelEx($model, 'oc_num_payment'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_num_payment', array( 'maxlength' => 2,'class'=>'span6')); ?>
              <?php echo CHtml::error($model, 'oc_num_payment',array('class'=>'help-block error')); ?>          
          </div>  
        </div>
        <div class="row-fluid">
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_insurance'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_insurance', array('size' => 20, 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_insurance',array('class'=>'help-block error')); ?>          
          </div>  
          <div class="span5">     
              <?php echo CHtml::activeLabelEx($model, 'oc_letter'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_letter', array( 'maxlength' => 255,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_letter',array('class'=>'help-block error')); ?>          
          </div>
           
        </div>
        <div class="row-fluid">
          <div class="span2">

               <?php 

                    echo CHtml::activeLabelEx($model, 'oc_insurance_start'); 
                    echo '<div class="input-append" style="margin-top:0px;margin-left:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract[oc_insurance_start]',
                            'id'=>'oc_insurance_start',
                            'model'=>$model,
                            'value'=>$model->oc_insurance_start,
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

                    echo CHtml::activeLabelEx($model, 'oc_insurance_end'); 
                    echo '<div class="input-append" style="margin-top:0px;margin-left:0px;">'; //ใส่ icon ลงไป
                        $this->widget('zii.widgets.jui.CJuiDatePicker',

                        array(
                            'name'=>'OutsourceContract[oc_insurance_end]',
                            'id'=>'oc_insurance_end',
                            'model'=>$model,
                            'value'=>$model->oc_insurance_end,
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
          <div class="span2  offset1">     
              <?php echo CHtml::activeLabelEx($model, 'oc_T_percent'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_T_percent', array( 'maxlength' => 3,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_T_percent',array('class'=>'help-block error')); ?>          
          </div> 
          <div class="span2">     
              <?php echo CHtml::activeLabelEx($model, 'oc_A_percent'); ?>
              <?php echo CHtml::activeTextField($model, 'oc_A_percent', array( 'maxlength' => 3,'class'=>'span12')); ?>
              <?php echo CHtml::error($model, 'oc_A_percent',array('class'=>'help-block error')); ?>          
          </div> 
           
           
           
        </div>
<script type="text/javascript">
  
  $(function(){
      

      $( "input[name*='oc_vendor_id_temp']" ).autocomplete({
       
                minLength: 0
      }).bind('focus', function () {
                $(this).autocomplete("search");
      });       
  });
 </script> 

<?php $this->endWidget(); ?>
