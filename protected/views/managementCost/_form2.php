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

</script>  

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'management-cost-form',
	'enableAjaxValidation'=>false,
)); ?>
<div class="well span9">
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row-fluid">       
       <div class="span8"> 
     	<?php 
          echo CHtml::label('โครงการ','rm_cost');        
          
     			  $vendor = Yii::app()->db->createCommand()
                         ->select('pj_name,pj_fiscalyear,wc_name')
                        ->from('project')
                        ->join('work_category', 'wc_id = pj_work_cat')
                        ->where('pj_id=:id', array(':id'=>$model->mc_proj_id))
                        ->queryAll();

          $pj_name = $vendor[0]["pj_name"];
          //echo $pj_name;              
          echo "<input type='text' class='span12' style='' disabled value='$pj_name'>";
                      

   	
     	?>
       </div>
       <div class="span4">
        <?php 

            $sql = "SELECT SUM(mc_cost) as sum FROM management_cost WHERE mc_proj_id='$model->mc_proj_id' AND mc_type=0";
              $command = Yii::app()->db->createCommand($sql);
              $result = $command->queryAll();

              $cost_total = 0;
              if(count($result))
                    $cost_total = $result[0]["sum"]; 

                $result = Yii::app()->db->createCommand()
                        ->select('SUM(mc_cost) as sum')
                        ->from('management_cost')
                        ->where('mc_proj_id=:id AND mc_type!=0', array(':id'=>$model->mc_proj_id))
                        ->queryAll();
                $pay_total = 0;
              if(count($result))
                    $pay_total = $result[0]["sum"];         

                $remain = number_format($cost_total - $pay_total,2);

              //  echo "ccc".$sql;


		        echo CHtml::label('คงเหลือค่าบริหารโครงการ','rm_cost');        
		        echo "<input type='text' id='rm_cost' class='span12' style='text-align:right' disabled value='$remain'>"?>
          
       </div>
    </div>  
    <div class="row-fluid">       
       <div class="span2"> 
       <?php 
        switch ($model->mc_type) {
              case "ประมาณการ":
                $model->mc_type = 0;
                break;
              case "ค่ารับรอง":
                $model->mc_type = 1;
                break;
              case "ค่าใช้จ่ายบริหารโครงการ":
                $model->mc_type = 2;
                break;  
              case "ค่าใช้จ่ายด้านบุคลากร":
                $model->mc_type = 3;
                break;    
              default:
                # code...
              
                break;
            }
       echo $form->dropDownListRow($model,'mc_type',array(1=>'ค่ารับรอง',2=>'ค่าใช้จ่ายบริหารโครงการ',3=>'ค่าใช้จ่ายด้านบุคลากร'),array('class'=>'span12','options' => array($model->mc_type=>array('selected'=>true)))); 

       ?>
       
       </div>
       <div class="span6"> 
       	<?php echo $form->textFieldRow($model,'mc_detail',array('class'=>'span12','maxlength'=>400)); ?>
       </div>
       <div class="span4"> 
       	<?php echo $form->textFieldRow($model,'mc_cost',array('class'=>'span12','style'=>'text-align:right')); ?>
       </div>
    </div>    	
	

	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>'บันทึก',
		)); ?>
	</div>
</div>
<?php $this->endWidget(); ?>
