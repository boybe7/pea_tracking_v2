<?php
$this->breadcrumbs=array(
	'รายการรับเงินงวดของโครงการ'=>array('index'),
	
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('payment-project-contract-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

Yii::app()->clientScript->registerScript('search', "
$('#search-form form').submit(function(){
    //console.log($('#patient-grid input[name=firstname]','#patient-grid select[name=firstname]').val('x'));
    
    $.fn.yiiGridView.update('payment-project-contract-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

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


<h1>รายการรับเงินงวดของสัญญาหลัก</h1>

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>false,
    'type'=>'vertical',
    'htmlOptions'=>  array('class'=>'well','style'=>'margin:0 auto;padding-top:20px;'),
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row-fluid">
        
       <div class="span4"> 
        <?php 
        	
        			$pname = '';
        			if(isset($_GET["pname"]))
        				$pname = $_GET["pname"];
        			echo "<input type='hidden' id='pname' name='pname' value='$pname'>";

        			
        			$cost = isset($_GET["cost"])?$_GET["cost"]:'';
        			echo "<input type='hidden' id='cost' name='cost' value='$cost'>";
	
        			echo CHtml::activeHiddenField($model, 'proj_id'); 
        			echo CHtml::activeLabelEx($model, 'proj_id'); 

        			$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'pj_vendor_id',
                            'id'=>'pj_vendor_id',
                            'value'=>$pname,
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
                                        
                                           $("#pname").val(ui.item.label);
                                           $("#pid").val(ui.item.id);
                                           $("#pj_cost").val(ui.item.cost);
                                           $("#cost").val(ui.item.cost);
                                           $("#PaymentProjectContract_proj_id").val(ui.item.id);
                                           $("#search-form").submit();

                                            
                                     }',
                                     //'close'=>'js:function(){$(this).val("");}',
                                     
                            ),
                           'htmlOptions'=>array(
                                'class'=>'span12',
                                'placeholder'=>"ค้นหาตาม ปี สัญญา ชื่อโครงการ เช่น 2558 มท เอบีบี"
                            ),
                                  
                        ));
						

         ?>
       </div>
        <div class="span3"> 
        <?php 
        echo CHtml::label('วงเงินตามสัญญา','pj_cost');
        $cost = isset($_GET["cost"])?$_GET["cost"]:'';       

        echo "<input type='text' class='span12' id='pj_cost' style='text-align:right' name='pj_cost' value='$cost' disabled>"?>
       </div>
        <div class="span3"> 
        <?php 
        echo CHtml::label('คงเหลือจ่ายเงิน','rm_cost');

        $rm_cost = "";
        $pid = isset($_GET["pid"])?$_GET["pid"]:'';
         echo "<input type='hidden' id='pid' name='pid' value='$pid'>";

        if($pid !="")
        {
        	$pc = Yii::app()->db->createCommand()
                        ->select('SUM(money) as sum')
                        ->from('payment_project_contract')
                        //->join('vendor vd', 'pj.pc_vendor_id = vd.v_id')
                        ->where('proj_id=:id AND (bill_date!="" AND bill_date!="0000-00-00")', array(':id'=>$pid))
                        ->queryAll();
            //echo ($pc[0]["sum"]);

            $cost = str_replace(",", "", $cost);
            $diff = $cost - $pc[0]["sum"]; 
            $rm_cost = number_format($diff,2);
                       
        }    

        echo "<input type='text' class='span12' id='rm_cost' style='text-align:right' name='rm_cost' value='$rm_cost' disabled>";?>
       </div>
        <div class="span1"> 
        <?php
        echo CHtml::label('T%','pj_T');
        $pid = isset($_GET["pid"])?$_GET["pid"]:'';
		$pc_T = '';
		$pc_A = ''; 

		if(isset($_GET["pid"]))
		{       
	        $modelPC = ProjectContract::model()->FindByPk($pid);

	        $pc_T = $modelPC->pc_T_percent;
	        $pc_A = $modelPC->pc_A_percent;
        

	        	$data = Yii::app()->db->createCommand()
										->select('sum(money) as sum')
										->from('payment_project_contract')
										->where('proj_id=:id AND (bill_date!="" AND bill_date!="0000-00-00")', array(':id'=>$pid))
										->queryAll();
											                        
					$sum_income = $data[0]["sum"];

					 $data = Yii::app()->db->createCommand()
										->select('sum(cost) as sum')
										->from('contract_change_history')
										->where('contract_id=:id  AND type=1', array(':id'=>$pid))
										->queryAll();
											                        
					$change = $data[0]["sum"];      

					// $data = Yii::app()->db->createCommand()
					// 					->select('sum(money) as sum')
					// 					->from('payment_outsource_contract')
					// 					->where('contract_id=:id AND (approve_date!="" AND approve_date!="0000-00-00")', array(':id'=>$modelPC->pc_id))
					// 					->queryAll();
											                        
					// $sum_payment = $data[0]["sum"];  
					$cost = $modelPC->pc_cost + $change;
					$pc_A =number_format((1 - ($cost - $sum_income)/$cost)*100,2);//number_format(($cost - $sum_income)*100/$cost,2);

        }


        echo "<input type='text' class='span12'  style='text-align:center' value='$pc_T' disabled>";
        echo "</div>";
        echo "<div class='span1'>";
        echo CHtml::label('A%','pj_T');



        echo "<input type='text' class='span12'  style='text-align:center' value='$pc_A' disabled>";
        
        // $this->widget('bootstrap.widgets.TbButton', array(
        //     'buttonType'=>'submit',
        //     'type'=>'inverse',
        //     'label'=>'ค้นหา',
        //     'icon'=>'search white',
        // // 'url'=>array('update'),
        //     'htmlOptions'=>array('class'=>'search-button','style'=>'margin:24px 10px 0px 0px;'),
        // ));
         
 
        ?>
       </div>
    </div>
    
<?php $this->endWidget(); ?>



<?php 

if(Yii::app()->user->getAccess(Yii::app()->request->url))
{

			$this->widget('bootstrap.widgets.TbButton', array(
			    'buttonType'=>'link',
			    
			    'type'=>'success',
			    'label'=>'เพิ่มรายการ',
			    'icon'=>'plus-sign',
			    'url'=>array('create'),
			    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:24px 10px 20px 10px;'),
			)); 

			// $this->widget('bootstrap.widgets.TbButton', array(
			//     'buttonType'=>'link',
			    
			//     'type'=>'danger',
			//     'label'=>'ลบรายการ',
			//     'icon'=>'minus-sign',
			//     //'url'=>array('delAll'),
			//     //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
			//     'htmlOptions'=>array(
			//         //'data-toggle'=>'modal',
			//         //'data-target'=>'#myModal',
			//         'onclick'=>'      
			//                        if($.fn.yiiGridView.getSelection("payment-project-contract-grid").length==0)
			//                        		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
			//                        else  
			//                           js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
			// 			                   function(confirmed){
						                   	 
			//                                 if(confirmed)
			// 			                   	 $.ajax({
			// 										type: "POST",
			// 										url: "deleteSelected",
			// 										data: { selectedID: $.fn.yiiGridView.getSelection("payment-project-contract-grid")}
			// 										})
			// 										.done(function( msg ) {
			// 											$("#payment-project-contract-grid").yiiGridView("update",{});
			// 										});
			// 			                  })',
			//         'class'=>'pull-right',
			//         'style'=>'margin:24px 10px 20px 10px',
			//     ),
			// ));

			$this->widget('bootstrap.widgets.TbButton', array(
			    'buttonType'=>'link',
			    
			    'type'=>'primary',
			    'label'=>'Export ใบแจ้งหนี้',
			    'icon'=>'excel',
			    //'url'=>array('delAll'),
			    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
			    'htmlOptions'=>array(
			        //'data-toggle'=>'modal',
			        //'data-target'=>'#myModal',
			        'onclick'=>'      
			                       if($.fn.yiiGridView.getSelection("payment-project-contract-grid").length==0)
			                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการ?","ตกลง");
			                       else  
			                       {
			                       	  id = $.fn.yiiGridView.getSelection("payment-project-contract-grid")
						               window.location.href = "export/"+id;
						            }      ',
			        'class'=>'pull-right',
			        'style'=>'margin:24px 0px 20px 10px',
			    ),
			)); 


			$this->widget('bootstrap.widgets.TbButton', array(
			    'buttonType'=>'link',
			    
			    'type'=>'info',
			    'label'=>'พิมพ์ใบแจ้งหนี้',
			    'icon'=>'print',
			    //'url'=>array('delAll'),
			    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
			    'htmlOptions'=>array(
			        //'data-toggle'=>'modal',
			        //'data-target'=>'#myModal',
			        'onclick'=>'      
			                       if($.fn.yiiGridView.getSelection("payment-project-contract-grid").length==0)
			                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการ?","ตกลง");
			                       else  
			                       {
			                       	  id = $.fn.yiiGridView.getSelection("payment-project-contract-grid")
						                   	 $.ajax({
													type: "POST",
													url: "print/"+id,
													data: {}
													})
													.done(function( msg ) {
														window.open("'.Yii::app()->baseUrl.'/report/temp/invoice_"+id+".pdf'.'", "_blank", "fullscreen=yes");
													});
						            }      ',
			        'class'=>'pull-right',
			        'style'=>'margin:24px 0px 20px 10px',
			    ),
			)); 

			 $this->widget('bootstrap.widgets.TbGridView',array(
				'id'=>'payment-project-contract-grid',
				'type'=>'bordered condensed',
				'dataProvider'=>$model->search(),
				'filter'=>$model,
				'selectableRows' =>1,
				'htmlOptions'=>array('style'=>'padding-top:40px;width:100%'),
			    'enablePagination' => true,
			    'enableSorting'=>true,
			    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
			    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
				'columns'=>array(
					'checkbox'=> array(
			        	    'id'=>'selectedID',
			            	'class'=>'CCheckBoxColumn',
			            	//'selectableRows' => 2, 
			        		 'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
				  	         'htmlOptions'=>array(
				  	            	  			'style'=>'text-align:center'

				  	            	  		)   	  		
			        ),
					'proj_id'=>array(
						    'header' => '<a class="sort-link">รายละเอียดโครงการ</a>',
						    //'name' =>'proj_id',
						    'value' => 'ProjectContract::model()->FindByPk($data->proj_id)->pc_details',
						    'filter'=>CHtml::activeTextField($model, 'proj_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("proj_id"))),
							'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
							'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
				  	),
					//'v_address',
					'detail'=>array(
						    'name' => 'detail',
						    'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
							'htmlOptions'=>array('style'=>'text-align:left')
				  	),
					'money'=>array(
						    'name' => 'money',
						    //'filter'=>CHtml::activeTextField($model, 'pj_fiscalyear',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
							'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
							'htmlOptions'=>array('style'=>'text-align:right')
				  	),
				  	'invoice_no/date'=>array(
						    //'header' => '<a class="sort-link">เลขที่ใบแจ้งหนี้/วันที่ได้รับ</a>',
						    'header'=>$model->getAttributeLabel('invoice_no/date'),
						    'name'=>'invoice_date',
						    'headerHtmlOptions'=>array(),
						    'type'=> 'raw',
						    'value' => '$data->invoice_no."<br>".$data->invoice_date',
						    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
							'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
							'htmlOptions'=>array('style'=>'text-align:center')
				  	),
				  	'bill_no/date'=>array(
						    //'header' => '<a class="sort-link">เลขที่ใบเสร็จรับเงิน/วันที่ได้รับ</a>',
						    'header'=>$model->getAttributeLabel('bill_no/date'),
						    'name'=>'bill_date',
						    'headerHtmlOptions'=>array(),
						    'type'=> 'raw',
						    'value' => '$data->bill_no."<br>".$data->bill_date',
						    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
							'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
							'htmlOptions'=>array('style'=>'text-align:center')
				  	),
				  	// 'T%'=>array(
						 //    //'header' => '<a class="sort-link"  href="/pea_track/paymentProjectContract/index?ajax=payment-project-contract-grid&sort=T">T%</a>',
						 //    'header'=>$model->getAttributeLabel('T%'),
						 //    'name'=>'T',
						 //    'headerHtmlOptions'=>array(),
						 //    //'type'=> 'raw',
						 //    'value' => '$data->T',//'ProjectContract::model()->FindByPk($data->proj_id)->pc_T_percent',
						 //    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
							// 'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),  	            	  	
							// 'htmlOptions'=>array('style'=>'text-align:center')
				  	// ),
				  	// 'A%'=>array(
						 //    //'header' => '<a class="sort-link">A%</a>',
						 //    'name'=>'A',
						 //     'header'=>$model->getAttributeLabel('A%'),
						 //    'headerHtmlOptions'=>array(),
						 //    //'type'=> 'raw',
						 //    'value' => '$data->A',//'ProjectContract::model()->FindByPk($data->proj_id)->pc_A_percent',
						 //    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
							// 'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),  	            	  	
							// 'htmlOptions'=>array('style'=>'text-align:center')
				  	// ),
					'flag_del'=>array(
						    'name' => 'flag_delete',
						    'filter'=>CHtml::activeDropDownList($model, 'flag_delete', array('1' => 'ยกเลิก'),array('empty'=>'')),
						    'type'=>'raw',
							'value'=>function($data){
									$str = $data->flag_delete==1 ? "<i class='icon-ok icon-red'></i>" : "";
									return $str;	
							},
							'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),  	            	  	
							'htmlOptions'=>array('style'=>'text-align:center')
				  	),
					array(
						'header' => '<a class="sort-link">ดู/แก้ไข</a>',
						'class'=>'bootstrap.widgets.TbButtonColumn',
						'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
						'template' => '{update} {cancel}',
						'buttons'=>array
					    (
					       
					        'cancel' => array
					        (
					            'label'=>'ยกเลิก',
					            'icon' => 'icon-remove',
					            'options'=>array('class'=>'cancel'),
					            //'visible'=>'$data->user_id =='.Yii::app()->user->id,
					            'url'=>function($data){

										            return Yii::app()->createUrl('/paymentProjectContract/cancel/',

										                    array('id'=>$data->id) /* <- customise that */

										            );

										        }, 
					        ),
					    ),
					),
				),
			));
}
else
{
			 $this->widget('bootstrap.widgets.TbGridView',array(
			'id'=>'payment-project-contract-grid',
			'type'=>'bordered condensed',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'selectableRows' =>2,
			'htmlOptions'=>array('style'=>'padding-top:40px;width:100%'),
		    'enablePagination' => true,
		    'enableSorting'=>true,
		    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
		    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
			'columns'=>array(
				'checkbox'=> array(
		        	    'id'=>'selectedID',
		            	'class'=>'CCheckBoxColumn',
		            	//'selectableRows' => 2, 
		        		 'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
			  	         'htmlOptions'=>array(
			  	            	  			'style'=>'text-align:center'

			  	            	  		)   	  		
		        ),
				'vc_id'=>array(
					    'header' => '<a class="sort-link">รายละเอียดโครงการ</a>',
					    'name' =>'vc_id',
					    //'value' => 'ProjectContract::model()->FindByPk($data->proj_id)->pc_details',
					    'filter'=>CHtml::activeTextField($model, 'proj_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("proj_id"))),
						'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
			  	),
				//'v_address',
				'detail'=>array(
					    'name' => 'detail',
					    'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:left')
			  	),
				'money'=>array(
					    'name' => 'money',
					    //'filter'=>CHtml::activeTextField($model, 'pj_fiscalyear',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
						'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:right')
			  	),
			  	'invoice_no/date'=>array(
					    //'header' => '<a class="sort-link">เลขที่ใบแจ้งหนี้/วันที่ได้รับ</a>',
					    'header'=>$model->getAttributeLabel('invoice_no/date'),
					    'name'=>'invoice_date',
					    'headerHtmlOptions'=>array(),
					    'type'=> 'raw',
					    'value' => '$data->invoice_no."<br>".$data->invoice_date',
					    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
						'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center')
			  	),
			  	'bill_no/date'=>array(
					    //'header' => '<a class="sort-link">เลขที่ใบเสร็จรับเงิน/วันที่ได้รับ</a>',
					    'header'=>$model->getAttributeLabel('bill_no/date'),
					    'name'=>'bill_date',
					    'headerHtmlOptions'=>array(),
					    'type'=> 'raw',
					    'value' => '$data->bill_no."<br>".$data->bill_date',
					    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
						'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
						'htmlOptions'=>array('style'=>'text-align:center')
			  	),
			  	
			),
		));

}


 ?>
<?php

Yii::app()->clientScript->registerScript('cancel', '
$(".cancel").click(function(e){
    e.preventDefault();
    url = $(this).attr("href"),
    str = url.split("/")
    id = str[4]
    bootbox.prompt("หมายเหตุการยกเลิก : ", function(result) {                
	  		$.ajax({
		        url: url,
		        data: {note: result},
		        success:function(response){
		        		location.reload();
		        }
		    });
	});
    

   
});
', CClientScript::POS_END);
?>