<?php
$this->breadcrumbs=array(
	'Management Cost Saps'=>array('index')
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('management-cost-sap-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h3>ค่าบริหารโครงการ (SAP)</h3>

<?php 

if(Yii::app()->user->getAccess(Yii::app()->request->url))
{
			$this->widget('bootstrap.widgets.TbButton', array(
			    'buttonType'=>'link',
			    
			    'type'=>'success',
			    'label'=>'เพิ่มรายการ',
			    'icon'=>'plus-sign',
			    'url'=>array('create'),
			    'htmlOptions'=>array('class'=>'pull-right','style'=>'margin:24px 10px 0px 10px;'),
			)); 

			$this->widget('bootstrap.widgets.TbButton', array(
			    'buttonType'=>'link',
			    
			    'type'=>'danger',
			    'label'=>'ลบรายการ',
			    'icon'=>'minus-sign',
			    //'url'=>array('delAll'),
			    //'htmlOptions'=>array('id'=>"buttonDel2",'class'=>'pull-right'),
			    'htmlOptions'=>array(
			        //'data-toggle'=>'modal',
			        //'data-target'=>'#myModal',
			        'onclick'=>'      
			                       if($.fn.yiiGridView.getSelection("management-cost-grid").length==0)
			                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
			                       else  
			                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
						                   function(confirmed){
						                   	 
			                                if(confirmed)
						                   	 $.ajax({
													type: "POST",
													url: "deleteSelected",
													data: { selectedID: $.fn.yiiGridView.getSelection("management-cost-grid")}
													})
													.done(function( msg ) {
														$("#management-cost-grid").yiiGridView("update",{});
													});
						                  })',
			        'class'=>'pull-right',
			        'style'=>'margin:24px 10px 20px 10px',
			    ),
			)); 

	 $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'management-cost-grid',
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
		
			'department'=>array(
				    'name' => 'department_id',
				    'value'=> 'Department::model()->FindByPk($data->department_id)->name',
				    //'filter'=>CHtml::activeTextField($model, 'pj_work_cat',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_work_cat"))),
					'filter'=>CHtml::listData(Department::model()->findAll(), 'id', 'name'),
				    'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
					'htmlOptions'=>array('style'=>'text-align:left')
		  	),
			'cost'=>array(
				    'name' => 'cost',
	          		'value'=>'number_format($data->cost,2)',
				    //'filter'=>CHtml::activeTextField($model, 'pj_fiscalyear',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
					'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
					'htmlOptions'=>array('style'=>'text-align:right')
		  	),
			'year'=>array(
				    'name' => 'year',
				    'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
					'htmlOptions'=>array('style'=>'text-align:right')
		  	),
		  	// 'date'=>array(
				    
				 //    'name'=>'mc_date',
				 //    'headerHtmlOptions'=>array(),
				 //   'headerHtmlOptions' => array('style' => 'width:15%;text-align:center;background-color: #f5f5f5'),  	            	  	
					// 'htmlOptions'=>array('style'=>'text-align:center')
		  	// ),
			array(
				'header' => '<a class="sort-link">ดู/แก้ไข</a>',
				'class'=>'bootstrap.widgets.TbButtonColumn',
				'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #f5f5f5'),
				'template' => '{update}'
			),
		),
	));


}
else
{
		$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'management-cost-grid',
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
	
		'department'=>array(
			    'name' => 'department_id',
			    'value'=> 'Department::model()->FindByPk($data->department_id)->name',
			    //'filter'=>CHtml::activeTextField($model, 'pj_work_cat',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_work_cat"))),
				'filter'=>CHtml::listData(Department::model()->findAll(), 'id', 'name'),
			    'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left')
	  	),
		'cost'=>array(
			    'name' => 'cost',
          		'value'=>'number_format($data->cost,2)',
			    //'filter'=>CHtml::activeTextField($model, 'pj_fiscalyear',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("pj_fiscalyear"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:right')
	  	),
		'year'=>array(
			    'name' => 'year',
			    'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:right')
	  	),
	  	
	),
));


 
}


?>