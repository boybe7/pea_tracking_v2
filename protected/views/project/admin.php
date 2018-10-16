<?php
$this->breadcrumbs=array(
	'Projects'=>array('index')
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('project-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>ข้อมูลโครงการ</h1>

<?php

// $this->widget('bootstrap.widgets.TbButton', array(
//     'buttonType'=>'link',
    
//     'type'=>'info',
//     'label'=>'บันทึกสัญญาจ้างช่วง/ซื้อ',
//     'icon'=>'plus-sign',
//     //'url'=>array('delAll'),
//     //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
//     'htmlOptions'=>array(
//         //'data-toggle'=>'modal',
//         //'data-target'=>'#myModal',
//         'onclick'=>'      
//                        console.log($.fn.yiiGridView.getSelection("vendor-grid")[0]);
//                        if($.fn.yiiGridView.getSelection("vendor-grid").length==0 )
//                        		js:bootbox.alert("กรุณาเลือกโครงการ?","ตกลง");
//                        else  
//                        	   window.location.href = "../project/createOutsource/"+$.fn.yiiGridView.getSelection("vendor-grid")[0];
//                           ',
//         'class'=>'pull-right'
//     ),
// )); 
if(!Yii::app()->user->isExecutive())
{
$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'success',
    'label'=>'เพิ่ม โครงการ',
    'icon'=>'plus-sign',
    'url'=>array('create'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;'),
)); 


$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'warning',
    'label'=>'ปิดโครงการ',
    'icon'=>'bookmark',
    //'url'=>array('close'),
    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:0px 10px 0px 10px;',


				'onclick'=>'      
                       if($.fn.yiiGridView.getSelection("vendor-grid").length==0)
                       	  js:bootbox.alert("กรุณาเลือกโครงการที่ต้องการปิด?","ตกลง");	
                       else 
                       {  
                               	 $.ajax({
										type: "POST",
										url: "closeSelected",
										data: { selectedID: $.fn.yiiGridView.getSelection("vendor-grid")}
										})
										.done(function( msg ) {
											$("#vendor-grid").yiiGridView("update",{});
										});
			            }',


    	),
)); 


$this->widget('bootstrap.widgets.TbButton', array(
    'buttonType'=>'link',
    
    'type'=>'danger',
    'label'=>'ลบ โครงการ',
    'icon'=>'minus-sign',
    //'url'=>array('delAll'),
    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
    'htmlOptions'=>array(
        //'data-toggle'=>'modal',
        //'data-target'=>'#myModal',
        'onclick'=>'      
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
		'pj_name'=>array(
			    'name' => 'pj_name',
			    'filter'=>CHtml::activeTextField($model, 'pj_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_name"))),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		//'v_address',
		'pj_work_cat'=>array(
			    'name' => 'pj_work_cat',
			    'value'=> 'WorkCategory::model()->FindByPk($data->pj_work_cat)->wc_name',
			    //'filter'=>CHtml::activeTextField($model, 'pj_work_cat',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_work_cat"))),
				'filter'=>CHtml::listData(WorkCategory::model()->findAll(), 'wc_id', 'wc_name'),
				//'filter'=>CHtml::dropDownList('pj_work_cat','wc_id',CHtml::listData(WorkCategory::model()->findAll(), 'wc_id', 'wc_name')),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'pj_fiscalyear'=>array(
			    'name' => 'pj_fiscalyear',
			    'filter'=>CHtml::activeTextField($model, 'pj_fiscalyear',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'pj_cost'=>array(
			    'header' => '<a class="sort-link">วงเงินรวม</a>',
			    //'name'=>'cost',
			    'headerHtmlOptions'=>array(),
			    'value' => 'number_format($data->sumcost,2)',
			    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'pj_status'=>array(
			    'header' => '<a class="sort-link">สถานะโครงการ</a>',
			    'name'=>'pj_status',
			    'headerHtmlOptions'=>array(),
			    //'value' => '$data->pj_staus',
			    'filter'=>CHtml::activeDropDownList($model, 'pj_status', array('1' => 'อยู่ระหว่างดำเนินการ', '0' => 'แล้วเสร็จ'),array('empty'=>'')),//CHtml::dropDownList('Project[pj_status]',$model,array('0' => 'ปกติ', '1' => 'ปิดโครงการ')),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),

		// 'v_contractor'=>array(
		// 	    'name' => 'v_contractor',
		// 	    'filter'=>CHtml::activeTextField($model, 'v_contractor',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_contractor"))),
		// 		'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
		// 		'htmlOptions'=>array('style'=>'text-align:center')
	 //  	),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
			'template' => '{view}  {update}'
		),
	),
));
}
else
{

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
		'pj_name'=>array(
			    'name' => 'pj_name',
			    'filter'=>CHtml::activeTextField($model, 'pj_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_name"))),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		//'v_address',
		'pj_work_cat'=>array(
			    'name' => 'pj_work_cat',
			    'value'=> 'WorkCategory::model()->FindByPk($data->pj_work_cat)->wc_name',
			    //'filter'=>CHtml::activeTextField($model, 'pj_work_cat',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_work_cat"))),
				'filter'=>CHtml::listData(WorkCategory::model()->findAll(), 'wc_id', 'wc_name'),
				//'filter'=>CHtml::dropDownList('pj_work_cat','wc_id',CHtml::listData(WorkCategory::model()->findAll(), 'wc_id', 'wc_name')),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'pj_fiscalyear'=>array(
			    'name' => 'pj_fiscalyear',
			    'filter'=>CHtml::activeTextField($model, 'pj_fiscalyear',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
	  	'pj_cost'=>array(
			    'header' => '<a class="sort-link">วงเงินรวม</a>',
			    //'name'=>'cost',
			    'headerHtmlOptions'=>array(),
			    'value' => 'number_format($data->sumcost,2)',
			    //'filter'=>CHtml::activeTextField($model, 'sumcost',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),
		'pj_status'=>array(
			    'header' => '<a class="sort-link">สถานะโครงการ</a>',
			    'name'=>'pj_status',
			    'headerHtmlOptions'=>array(),
			    //'value' => '$data->pj_staus',
			    'filter'=>CHtml::activeDropDownList($model, 'pj_status', array('1' => 'อยู่ระหว่างดำเนินการ', '0' => 'แล้วเสร็จ'),array('empty'=>'')),//CHtml::dropDownList('Project[pj_status]',$model,array('0' => 'ปกติ', '1' => 'ปิดโครงการ')),
				'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center')
	  	),

		// 'v_contractor'=>array(
		// 	    'name' => 'v_contractor',
		// 	    'filter'=>CHtml::activeTextField($model, 'v_contractor',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_contractor"))),
		// 		'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
		// 		'htmlOptions'=>array('style'=>'text-align:center')
	 //  	),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
			'template' => '{view}'
		),
	),
));


}
 /*$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'project-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'pj_id',
		'pj_name',
		'pj_vendor_id',
		'pj_work_cat',
		'pj_fiscalyear',
		
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
));*/
 ?>
