<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'vendor-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>  array('class'=>'well span8 text-center')
)); ?>

	<!-- <p class="help-block">Fields with <span class="required">*</span> are required.</p> -->

	<div style="text-align:left"><?php echo $form->errorSummary($model); ?></div>
	<div class="row-fluid">
    	
    	<div class="span6">
      		<?php

      		 
      		 $typelist = array("Owner" => "Owner", "Supplier" => "Supplier");
             echo $form->dropDownListRow($model, 'type', $typelist,array('class'=>'span12'), array('options' => array('pj_work_cat'=>array('selected'=>true)))); 


      		 ?>
    	</div>
  	</div>
	<div class="row-fluid">
    	<div class="span12">
      		<?php 

      		echo $form->textFieldRow($model,'v_name',array('class'=>'span12','maxlength'=>200));

      		 ?>
    	</div>
    	
  	</div>
  	<div class="row-fluid">
    	<div class="span12">
      		<?php echo $form->textFieldRow($model,'v_BP',array('class'=>'span12','maxlength'=>200)); ?>
    	</div>
    	
  	</div>
  	<div class="row-fluid">
    	
    	<div class="span12">
      		<?php echo $form->textFieldRow($model,'v_tax_id',array('class'=>'span12','maxlength'=>13)); ?>
    	</div>
  	</div>
	<div class="row-fluid">
    	<div class="span12">	
			<?php echo $form->textAreaRow($model,'v_address',array('rows'=>3, 'cols'=>50, 'class'=>'span12')); ?>
		</div>
	</div>	
	<div class="row-fluid">
    	<div class="span12">	
			<?php echo $form->textFieldRow($model,'v_tel',array('class'=>'span12','maxlength'=>25)); ?>
		</div>
	</div>	
	<div class="row-fluid">
    	<div class="span12">	
			<?php echo $form->textFieldRow($model,'v_contractor',array('class'=>'span12','maxlength'=>100)); ?>
		</div>
	</div>
	

	
  <div class="row-fluid">
	<div class="span12 form-actions ">
		<?php 
                
      
      		$this->widget('bootstrap.widgets.TbButton', array(
			   'buttonType'=>'link',
			   'type'=>'danger',
			   'label'=>'ยกเลิก',
         		'htmlOptions'=>array('class'=>'pull-right'),               
          		'url'=>array("admin"), 
		  	)); 
     		
     		$this->widget('bootstrap.widgets.TbButton', array(
		         'buttonType'=>'submit',
		         'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;'),
		         'type'=>'primary',
		         'label'=>'บันทึก',
		                    
		    )); 
         
    ?>
	</div>
  </div>
 
<?php $this->endWidget(); ?>
 
<script type="text/javascript">
$(function() {
		//console.log( "ready!" );
		
		$( "#Vendor_type" ).change(function() {
		   if($( "#Vendor_type" ).val()=="Owner")	
			 $("label[for='Vendor_v_BP']").text("หมายเลข BP")
		   else
		   	 $("label[for='Vendor_v_BP']").text("หมายเลข Vendor")
		});
});	

</script>

