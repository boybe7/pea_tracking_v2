<?php
$this->breadcrumbs=array(
	'Work Categories'=>array('index'),
	'Manage',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('work-category-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>ประเภทงาน</h1>

<div class="row-fluid">
 
	<div class="span8">
		<?php echo CHtml::textField('newCategory', '',array('class'=>'span12','placeholder'=>'กรอกประเภทงานใหม่')); ?>
	</div>
	<div class="span2">
		<?php
		$this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'ajaxLink',
		    
		    'type'=>'success',
		    'label'=>'เพิ่ม ประเภทงาน',
		    'icon'=>'plus-sign',
		    'url'=>array('create'),
		    'htmlOptions'=>array('class'=>'span12','style'=>''),
		    'ajaxOptions'=>array(
		    	    //'url'=>$this->createUrl('create'),
		     	    'type' => 'POST',
                	'data' => array('name' => 'js:$("#newCategory").val()'),
                	'success' => 'function(html){ $("#newCategory").val(""); $.fn.yiiGridView.update("work-category-grid"); }'
                ) 
		)); 
		?>
	</div>	
	<div class="span2">	
		<?php
		   $this->widget('bootstrap.widgets.TbButton', array(
		    'buttonType'=>'link',
		    
		    'type'=>'danger',
		    'label'=>'ลบ ประเภทงาน',
		    'icon'=>'minus-sign',
		    'htmlOptions'=>array(
		        
		        'onclick'=>'      
		                       //console.log($.fn.yiiGridView.getSelection("vendor-grid").length);
		                       if($.fn.yiiGridView.getSelection("work-category-grid").length==0)
		                       		js:bootbox.alert("กรุณาเลือกแถวข้อมูลที่ต้องการลบ?","ตกลง");
		                       else  
		                          js:bootbox.confirm("คุณต้องการจะลบข้อมูล?","ยกเลิก","ตกลง",
					                   function(confirmed){
					                   	 	
		                                if(confirmed)
					                   	 $.ajax({
												type: "POST",
												url: "deleteSelected",
												data: { selectedID: $.fn.yiiGridView.getSelection("work-category-grid")}
												})
												.done(function( msg ) {
													$("#work-category-grid").yiiGridView("update",{});
												});
					                  })',
		        'class'=>'span12'
		    ),
		)); 
		?>
	</div>	
</div>
<?php

 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'work-category-grid',
	'dataProvider'=>$model->search(),
	'type'=>'bordered condensed',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:0px'),
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
		'wc_name'=>array(
			    'name' => 'wc_name',
			    'class' => 'editable.EditableColumn',
			    //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;'),
				'editable' => array( //editable section
					//'apply' => '$data->user_status != 4', //can't edit deleted users
					//'text'=>'Click',
					//'tooltip'=>'Click',
					'title'=>'แก้ไขประเภทงาน',
					'url' => $this->createUrl('update'),
					'success' => 'js: function(response, newValue) {
										if(!response.success) return response.msg;

										$("#work-category-grid").yiiGridView("update",{});
									}',
					'options' => array(
						'ajaxOptions' => array('dataType' => 'json'),

					), 
					'placement' => 'right',
					'display' => 'js: function() {
					    
					    //$(this).attr( "rel", "tooltip");
					    //$(this).attr( "data-original-title", "คลิกเพื่อแก้ไข");
					    
					}'
				)
	  	)
		
	)
)); ?>
