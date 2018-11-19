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

.the-fieldset-yellow {
   background-color: #f8c10621;

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

      
      
        // Check browser support
      if (typeof(Storage) != "undefined") {
          // Store
          //localStorage.setItem("lastname", "Smith");
          // Retrieve
          //document.getElementById("result").innerHTML = localStorage.getItem("lastname");
      } else {
          document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
      }

      function init () {
       
          $("form input").each(function(){
                 id = $(this).attr("id");
                 if ( sessionStorage[id] )
                    $(this).val( sessionStorage.getItem(id));
      
                                            
         });

         

          $("form textarea").each(function(){
                 id = $(this).attr("id");
                 if ( sessionStorage[id] )
                    $(this).val( sessionStorage.getItem(id));
      
                                            
         });

          console.log("init");
      }

      

    
  });

   function addWorkCode(){
  
        if($("#work_code").val()!="")
        { 
         $('#tgrid').find('tbody').append('<tr id='+$("#work_code").val()+'><td width="90%"><input name="wk[]" style="margin-bottom:0px;" class="span12" type="text" value="'+
                 $("#work_code").val()+
                 '"/></td><td style="text-align:center;width:10%;"><a href="#" onclick=deleteRow("'+$("#work_code").val()+'")><i class="icon-red icon-remove"></i></a></td></tr>');
        
         $("#work_code").val("");
        } 
    }
    function deleteRow(id){
     
         $("#tgrid tr[id='"+id+"']").remove();
        
    }  
	$('#tabs a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });
    
    $('a[data-toggle="tab"]').on('shown', function (e) {
    	e.target // activated tab
    	e.relatedTarget // previous tab
    });
   
   
</script>


<script type="text/javascript">
  


  
</script>

<div class="well">
	<ul class="nav nav-tabs">
      <?php  
        if($tab==1)
        {
        	echo '<li  class="active"><a href="#projTab" data-toggle="tab">โครงการ</a></li>
                 <li ><a href="#outTab" data-toggle="tab">สัญญาจ้างช่วง/ซื้อ</a></li>
                ';	
        }
        else{
         echo '<li  ><a href="#projTab" data-toggle="tab">โครงการ</a></li>
                 <li class="active"><a href="#outTab" data-toggle="tab">สัญญาจ้างช่วง/ซื้อ</a></li>
                '; 
        }
       
      ?>
        
    </ul>
        
    <div class="tab-content">
        
      <?php 

        if($tab==1)
          echo '<div class="tab-pane  active" id="projTab">';
        else
          echo '<div class="tab-pane " id="projTab">';
        	
        	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
      			'id'=>'project-form',
      			'enableAjaxValidation'=>false,
      			'type'=>'vertical',
        			'htmlOptions'=>  array('class'=>'','style'=>''),
      		)); 

      ?>
     <h4>รายละเอียดโครงการ</h4>
     <hr>
    <div style="text-align:left">กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน</div>
    <div style="text-align:left"><?php echo $form->errorSummary(array($model));?></div>
		
		<div class="row-fluid">
			<div class="well-blue span8">
      			
      				<!-- <span style='display: block;margin-bottom: 5px;'>คู่สัญญา</span>  -->
      				
				<div class="row-fluid">
					  <div class="span4">
                <?php echo $form->textFieldRow($model,'pj_fiscalyear',array('class'=>'span12','maxlength'=>4)); ?>
            </div>
            <div class="span8">
                <?php echo $form->labelEx($model,'pj_date_approved',array('class'=>'span12','style'=>'text-align:left;padding-right:10px;'));?>
              
                 <?php 
                    //if($model->pj_date_approved == "00/00/0000")
                    //   $model->pj_date_approved = '';
             
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
		    <div class="row-fluid">
            <div class="span9">  		
		    		<?php 
      				
              $workcat = Yii::app()->db->createCommand()
                    ->select('wc_id,wc_name as name')
                    ->from('work_category')
                    ->queryAll();
     
                $typelist = CHtml::listData($workcat,'wc_id','name');
                echo $form->dropDownListRow($model, 'pj_work_cat', $typelist,array('class'=>'span12'), array('options' => array('pj_work_cat'=>array('selected'=>true)))); 
             
            

      				?>
           </div>
           <div class="span3">
           <?php
             
            if($model->pj_status=="อยู่ระหว่างดำเนินการ")
              $model->pj_status = 1;
            else
              $model->pj_status = 0;
            
             echo "สถานะโครงการ";
            
             echo $form->checkBoxRow($model,'pj_status',  array('value'=>0, 'uncheckValue'=>1));
           
           ?>
           </div>
        </div>   
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
                          url: "../../vendor/CreateVendor/",
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
                                    url: "../vendor/createVendor/1",
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
               $mc = Yii::app()->db->createCommand()
                      ->select('mc_cost')
                      ->from('management_cost')
                      ->where('mc_proj_id=:id AND mc_in_project=1 AND mc_type=0', array(':id'=>$model->pj_id))
                      ->queryAll();

               $value = '';
               if(!empty($mc))
                 $value = number_format($mc[0]["mc_cost"],2);   

       
               echo CHtml::label('เงินประมาณการค่าใช้จ่ายในการบริหารโครงการ (บาท)','expect_cost1');        
               echo "<input type='text' id='expect_cost1' name='expect_cost1' class='span6' style='text-align:right' value='$value' >"; 
            ?>
            </div>
          </div>
          <div class="row-fluid">   
            <div class="span12">
             <?php 
               $mc = Yii::app()->db->createCommand()
                      ->select('mc_cost')
                      ->from('management_cost')
                      ->where('mc_proj_id=:id AND mc_in_project=2 AND mc_type=0', array(':id'=>$model->pj_id))
                      ->queryAll();

                $value = '';
               if(!empty($mc))
                 $value = number_format($mc[0]["mc_cost"],2);       
        
               echo CHtml::label('เงินประมาณการค่าใช้จ่ายด้านบุคลากร (บาท)','expect_cost2');        
               echo "<input type='text' id='expect_cost2' name='expect_cost2' class='span6' style='text-align:right' value='$value'>";

            ?>
            </div>
          </div>
           <div class="row-fluid">   
            <div class="span12">
             <?php 
               $mc = Yii::app()->db->createCommand()
                      ->select('mc_cost')
                      ->from('management_cost')
                      ->where('mc_proj_id=:id AND mc_in_project=3 AND mc_type=0', array(':id'=>$model->pj_id))
                      ->queryAll();

                $value = '';
               if(!empty($mc))
                 $value = number_format($mc[0]["mc_cost"],2);       
        
               echo CHtml::label('เงินประมาณการค่ารับรอง (บาท)','expect_cost3');        
               echo "<input type='text' id='expect_cost3' name='expect_cost3' class='span6' style='text-align:right' value='$value'>";

            ?>
            </div>
          </div>
        </div>  
      <div class="well-blue span4">
      			<?php 
      			
           
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
      			<table class="table table-bordered " style="background-color: #eeeeee" name="tgrid" id="tgrid" width="100%" cellpadding="0" cellspacing="0">                    
	                <tbody>
                            <?php

                                   
                                    $workCode = Yii::app()->db->createCommand()
                                                ->select('code,id')
                                                ->from('work_code')
                                                ->where('pj_id=:id', array(':id'=>$model->pj_id))
                                                ->queryAll();
                                    $workcodes = '';
                                    if(!empty($workCode))
                                    {    
                                       foreach ($workCode as $key => $value) {
                                         //print_r($value["code"]);
                                         echo "<tr id='".$value["id"]."'><td><input name='wk[]' style='margin-bottom:0px;padding:0 2%;' class='span12' type='text' value='".$value["code"]."'/></td><td style='text-align:center;width:10%;'><a  onclick=deleteRow('".$value["id"]."')><i class='icon-red icon-remove'></i></a></td></tr>";
                                         $workcodes .= $value["code"].",";
                                       }
                                    }

                               
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
                'id'=>'loadContractByAjaxTemp'
              ),
          ));

         ?>
         </div>

         <div id="pj_contract">
      <?php 
      


            // $project_contract = Yii::app()->db->createCommand()
            //             ->select('*')
            //             ->from('project_contract')
            //             ->where('pc_proj_id=:id', array(':id'=>$model->pj_id))
            //             ->queryAll();

            // if(!empty($project_contract))
            // {    
            //     $index = 1; 
            //     foreach ($project_contract as $key => $value) {

            //         $modelPC =new ProjectContract;
            //         $modelPC->attributes = $value;
            //         $str_date = explode("-", $value["pc_sign_date"]);
            //         if(count($str_date)>1)
            //           $modelPC->pc_sign_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            //         $str_date = explode("-", $value["pc_end_date"]);
            //         if(count($str_date)>1)
            //           $modelPC->pc_end_date = $str_date[2]."/".$str_date[1]."/".($str_date[0]);
            //         $modelPC->pc_details = $value["pc_details"];

            //         $modelPC->pc_cost = number_format($modelPC->pc_cost,2);

            //         $this->renderPartial('//ProjectContract/_form', array(
            //             'model' => $modelPC,
            //             'index' => $index,
            //             'display' => 'block'
            //         ));
            //         $index++;

                    

            //     }
            // } 

          $project_contract = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('project_contract')
                        ->where('pc_proj_id=:id', array(':id'=>$model->pj_id))
                        ->queryAll();
          //echo count($project_contract); 

            
            $index = 1; 
            foreach ($contracts as $id => $con):
              if($index > count($project_contract))
              {
                 
                  // $this->renderPartial('//ProjectContract/_formUpdateTemp2', array(
                  //     'model' => $con,
                  //     'index' => $index,
                  //     'display' => 'block',
                  // ));
                  Yii::app()->clientScript->registerScript('loadcontract2', '
                       
   
                           var _url = "' . Yii::app()->controller->createUrl("loadContractByAjaxTemp", array("load_for" => $this->action->id)) . '&index='.$index.'";
                          $.ajax({
                              url: _url,
                              success:function(response){
                                  $("#pj_contract").append(response);
                                  $("#pj_contract .crow").last().animate({
                                      opacity : 1,
                                      left: "+0",
                                      height: "toggle"
                                  });

                                  $(".sessionStore").keyup(function () {
                                     
                                      sessionStorage[$(this).attr("id")] = $(this).val();
                                  });      


                                   $("form input").each(function(){
                                           id = $(this).attr("id");
                                           if ( sessionStorage[id] )
                                              $(this).val( sessionStorage.getItem(id));
                                
                                                                      
                                   });

                                    $("form textarea").each(function(){
                                           id = $(this).attr("id");
                                           if ( sessionStorage[id] )
                                              $(this).val( sessionStorage.getItem(id));
                                
                                                                      
                                   });
                              }

                          });

  
                      ', CClientScript::POS_END);
                      
              } 
              else
              {
                  $this->renderPartial('//ProjectContract/_formUpdate', array(
                      'model' => $con,
                      'index' => $index,
                      'display' => 'block'
                  ));

              } 
                
              $index++;
          endforeach;    
          $index1 = $index - 1;         
            echo "<input type='hidden' name='num1' id='num1' value='$index1'>";
            //echo "index:".$index;
        ?>   
           
     
        </div>
        <div class="form-actions">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
          'buttonType'=>'submit',
          'type'=>'primary',
          'htmlOptions'=>array('class'=>'','style'=>'margin:0px 10px 0px 10px;'),    
          'label'=>'บันทึกแก้ไข สัญญาหลัก',
        )); 

        $this->widget('bootstrap.widgets.TbButton', array(
           'buttonType'=>'link',
           'type'=>'danger',
           'label'=>'ยกเลิก',
           //'htmlOptions'=>array('class'=>'pull-right'),               
            'url'=>array("admin"), 
        )); 

        ?>
        </div>
      <?php $this->endWidget();//end form widget ?>   
						
		</div>

       
        <!-- tab@2  Outsource Contracts -->
		<?php 
			
      if($tab==1)
				echo '<div class="tab-pane" id="outTab">';		    
		  else
        echo '<div class="tab-pane active" id="outTab">';

      $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'outsource-form',
            'enableAjaxValidation'=>false,
            'type'=>'vertical',
              'htmlOptions'=>  array('class'=>'','style'=>''),
          )); 


        echo '<div class="row-fluid">';
         $this->widget('bootstrap.widgets.TbButton', array(
              'buttonType'=>'link',
              
              'type'=>'success',
              'label'=>'เพิ่มสัญญา',
              'icon'=>'plus-sign',
              
              'htmlOptions'=>array(
                'class'=>'pull-right',
                'style'=>'margin:0px 10px 0px 10px;',
                'id'=>'loadOutsourceByAjax'
              ),
          )); 

        echo '</div>';    
    ?>  

	    <div id="outsource">
          
          <div style="text-align:left">กรุณากรอกข้อมูลในช่องที่มีเครื่องหมาย (*) ให้ครบถ้วน</div>
          <div style="text-align:left"><?php echo $form->errorSummary(array($modelOC));?></div>
    
	        <?php



	        
          echo  '<input type="hidden" id="clearSessionStorage" name="clearSessionStorage" value="'.$clearSession.'">';
	        $index2 = 1;

	        // $index++;

          $outsource_contract = Yii::app()->db->createCommand()
                        ->select('*')
                        ->from('outsource_contract')
                        ->where('oc_proj_id=:id', array(':id'=>$model->pj_id))
                        ->queryAll();
          echo  '<input type="hidden" id="num" name="num" value="'.count($outsource).'">';              
          //echo count($outsource);              

	        foreach ($outsource as $id => $child):
              if($index2 > count($outsource_contract) )
              {
                 
              
                  Yii::app()->clientScript->registerScript('loadOutsourcecontract2', '
                       
   
                          var _url = "' . Yii::app()->controller->createUrl("loadOutsourceByAjaxTemp", array("load_for" => $this->action->id)) . '&index='.$index2.'";
                          $.ajax({
                              url: _url,
                              success:function(response){
                                  $("#outsource").append(response);
                                  $("#outsource .crow").last().animate({
                                      opacity : 1,
                                      left: "+0",
                                      height: "toggle"
                                  });

                                  $(".sessionStore").keyup(function () {
                                     
                                      sessionStorage[$(this).attr("id")] = $(this).val();
                                  });

                                  if($("#clearSessionStorage").val()==1)
                                      sessionStorage.clear();

                                  
                                  
                                   $("form input").each(function(){
                                           id = $(this).attr("id");
                                           if ( sessionStorage[id] )
                                              $(this).val( sessionStorage.getItem(id));
                                
                                                                      
                                   });

                                   

                                    $("form textarea").each(function(){
                                           id = $(this).attr("id");
                                           if ( sessionStorage[id] )
                                              $(this).val( sessionStorage.getItem(id));
                                
                                                                      
                                   });
                              }

                          });

  
                      ', CClientScript::POS_END);
                      
              } 
              else
              {
  	           
                $this->renderPartial('//outsourceContract/_formUpdate', array(
  	                'model' => $child,
  	                'index' => $index2,
  	                'display' => 'block'
  	            ));
              }
	            $index2++;
	        endforeach;
	        
         
          ?>


	    </div>
	    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
          'buttonType'=>'submit',
          'type'=>'warning',
          'htmlOptions'=>array('class'=>'','style'=>'margin:0px 10px 0px 10px;'),  
          'label'=>'บันทึกแก้ไข สัญญาจ้างช่วง',
        )); 



        $this->widget('bootstrap.widgets.TbButton', array(
           'buttonType'=>'link',
           'type'=>'danger',
           'label'=>'ยกเลิก',
           //'htmlOptions'=>array('class'=>'pull-right'),               
            'url'=>array("admin"), 
        )); 

        ?>
      </div>
      <?php $this->endWidget();//end form widget ?>
		</div><!--  endtab2 -->

     

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
      //$model3=new ContractApproveHistoryTemp;
      
      //$this->renderPartial('/contractApproveHistory/_form2',array('model'=>$model3,'index'=>$index),false); 


      ?>
    <!-- Date here: <input type="text" id="datePicker2" > -->
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalCancel2">ยกเลิก</a>
   <?php echo '<a href="#" class="btn btn-primary" id="modalSubmit2">บันทึก</a>'; ?>
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

<div id="modalApprove"  class="modal hide fade">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>แก้ไขข้อมูลอนุมัติ</h3>
    </div>
    <div class="modal-body" id="bodyApprove">
     
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalCancel">ยกเลิก</a>
    <a href="#" class="btn btn-primary" id="modalSubmit">บันทึก</a>
    </div>
</div>


<div id="modalChangeOc"  class="modal hide fade">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>แก้ไขข้อมูลรายการเพิ่ม-ลดวงเงิน</h3>
    </div>
    <div class="modal-body" id="bodyChangeOc">
     
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalChangeOcCancel">ยกเลิก</a>
    <a href="#" class="btn btn-primary" id="modalChangeOcSubmit">บันทึก</a>
    </div>
</div>

<div id="modalPO"  class="modal hide fade">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>แก้ไขข้อมูลรายการ PO</h3>
    </div>
    <div class="modal-body" id="bodyPO">
     
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalPOCancel">ยกเลิก</a>
    <a href="#" class="btn btn-primary" id="modalPOSubmit">บันทึก</a>
    </div>
</div>


<div id="modalApproveOc"  class="modal hide fade">
    <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>แก้ไขข้อมูลอนุมัติ</h3>
    </div>
    <div class="modal-body" id="bodyApproveOc">
     
    </div>
    <div class="modal-footer">
    <a href="#" class="btn btn-danger" id="modalCancelOc">ยกเลิก</a>
    <a href="#" class="btn btn-primary" id="modalSubmitOc">บันทึก</a>
    </div>
</div

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
  
    <div id="modal-body2">
<!-- put whatever you want to show up on bootbox here -->
    
      <?php 
      //$model = Vendor::model()->findByPk(14);
      $model3=new ContractApproveHistory;
      
      $this->renderPartial('/contractApproveHistory/_form',array('model'=>$model3),false); 


      ?>

      
    </div>
    <div id="modal-body5">
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
       $model4=new ContractChangeHistory;
      
      $this->renderPartial('/contractChangeHistory/_form',array('model'=>$model4),false); 

      ?>
    </div>

    <div id="modal-body-po">
<!-- put whatever you want to show up on bootbox here -->
      <?php 
       $model4=new WorkcodeOutsource;
      
      $this->renderPartial('/workCodeOutsource/_form',array('model'=>$model4),false); 

      ?>
    </div>
    <div id="modal-body4">
<!-- put whatever you want to show up on bootbox here -->
      <?php 
       $model4=new ContractChangeHistoryTemp;
      
      $this->renderPartial('/contractChangeHistory/_form',array('model'=>$model4),false); 

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
Yii::app()->clientScript->registerScript('loadcontract', '
var _index = ' . $index . ';
//var _index = $("#num").val();
$("#loadContractByAjaxTemp").click(function(e){
     var _index = $("#num1").val();
     _index++;
     console.log(_index);
    e.preventDefault();
    var _url = "' . Yii::app()->controller->createUrl("loadContractByAjaxTemp", array("load_for" => $this->action->id)) . '&index="+_index;
    $.ajax({
        url: _url,
        success:function(response){
            $("#pj_contract").append(response);
            $("#pj_contract .crow").last().animate({
                opacity : 1,
                left: "+0",
                height: "toggle"
            });

                                  $(".sessionStore").keyup(function () {
                                     
                                      sessionStorage[$(this).attr("id")] = $(this).val();
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
<?php

//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('loadoutsource', '
var _index = ' . $index2 . ';
$("#loadOutsourceByAjax").click(function(e){
     var _index = $("#num").val();
     _index++;
     console.log(_index);
    e.preventDefault();
    var _url = "' . Yii::app()->controller->createUrl("loadOutsourceByAjaxTemp", array("load_for" => $this->action->id)) . '&index="+_index;
    $.ajax({
                              url: _url,
                              success:function(response){
                                  $("#outsource").append(response);
                                  $("#outsource .crow").last().animate({
                                      opacity : 1,
                                      left: "+0",
                                      height: "toggle"
                                  });

                                  $(".sessionStore").keyup(function () {
                                     
                                      sessionStorage[$(this).attr("id")] = $(this).val();
                                  });

                                  if($("#clearSessionStorage").val()==1)
                                      sessionStorage.clear();

                                  
                                  
                                   $("form input").each(function(){
                                           id = $(this).attr("id");
                                           if ( sessionStorage[id] )
                                              $(this).val( sessionStorage.getItem(id));
                                
                                                                      
                                   });

                                   

                                    $("form textarea").each(function(){
                                           id = $(this).attr("id");
                                           if ( sessionStorage[id] )
                                              $(this).val( sessionStorage.getItem(id));
                                
                                                                      
                                   });

                                    //rearrange no.
                                    var collection = $(".contract_no_oc");
                                    for(var i=0; i<collection.length; i++){
                                        var element = collection.eq(i);
                                        element.html("สัญญาที่ "+(i+1));
                                        //console.log(element.html());
                                    }         
                              }//success
       
    });

});
', CClientScript::POS_END);

?>