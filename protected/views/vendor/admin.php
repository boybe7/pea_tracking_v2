<style type="text/css">
	
.pagination {
   margin: 0px 0;
}
.summary {
	 color: #08C;
}
</style>


<?php
$this->breadcrumbs=array(
	'Vendors'=>array('index'),
	//'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('vendor-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>ข้อมูลคู่สัญญา</h1>


<?php

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่ม คู่สัญญา',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;'),
)); 

$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'danger',
    'label'=>'ลบ คู่สัญญา',
    'icon'=>'minus-sign',
    //'url'=>array('delAll'),
    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
    'htmlOptions'=>array(
        //'data-toggle'=>'modal',
        //'data-target'=>'#myModal',
        'onclick'=>'      
                       //console.log($.fn.yiiGridView.getSelection("vendor-grid").length);
                       if($.fn.yiiGridView.getSelection("vendor-grid").length==0)
                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
                       else  
                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
			                   function(confirmed){
			                   	 	
			                   	 //console.log("Confirmed: "+confirmed);
			                   	 //console.log($.fn.yiiGridView.getSelection("user-grid"));
                                if(confirmed)
			                   	 $.ajax({
										type: "POST",
										url: "deleteSelected",
										data: { selectedID: $.fn.yiiGridView.getSelection("vendor-grid")}
										})
										.done(function( msg ) {
											$("#vendor-grid").yiiGridView("update",{});
										});
			                  })',
        'class'=>'pull-right'
    ),
)); 

 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'vendor-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:40px'),
    'enablePagination' => true,
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
		'v_name'=>array(
			    'name' => 'v_name',
			    'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),

		//'v_address',
		'v_tax_id'=>array(
			    'name' => 'v_tax_id',
			    'filter'=>CHtml::activeTextField($model, 'v_tax_id',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_tax_id"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'v_tel'=>array(
			    'name' => 'v_tel',
			    'filter'=>CHtml::activeTextField($model, 'v_tel',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_tel"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'v_contractor'=>array(
			    'name' => 'v_contractor',
			    'filter'=>CHtml::activeTextField($model, 'v_contractor',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_contractor"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'type'=>array(
			    'name' => 'type',
			    'filter'=>CHtml::activeTextField($model, 'type',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("type"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
			'template' => '{view}  {update}',
			// 'buttons' => array(
			// 	'deleteC' => array
			// 	(
			// 		'label' => 'Delete',
		 //     		'icon' => 'icon-trash',
		 //     		'options'=>array(
			// 			'onclick'=>'      
                       
   //                        js:bootbox.confirm("คุณต้องการจะลบข้อมูล?"'.$model->v_id.',"ยกเลิก","ตกลง",
			//                    function(confirmed){
			                   	
   //                              if(confirmed)
			//                    	 $.ajax({
			// 							type: "POST",
			// 							url: "delete/"'.$model->v_id.'
			// 							})
			// 							.done(function( msg ) {
			// 								$("#vendor-grid").yiiGridView("update",{});
			// 							});
			//                   })',
   //      			)
			// 	),
			//  )
		),
	),
)); ?>
