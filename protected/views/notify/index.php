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
	'แจ้งเตือน'=>array('index'),
	//'Manage',
);


Yii::app()->clientScript->registerScript('submitForm', "

$('#search-form').submit(function(){

    $('#Notify_project').val($('#project').val())
    $('#Notify_contract').val($('#contract').val())
    $.fn.yiiGridView.update('notify-grid', {
        data: $(this).serialize()
    });
    return false;
	
});
");



?>

<h1>ข้อมูลแจ้งเตือน</h1>


<?php

/*
        $sort = new CSort;
        //$sort->defaultOrder = 'project DESC';
        $sort->defaultOrder = 'date_end ASC';
        $sort->attributes = array('project,contract,date_end,alarm_detail');
        $provAll = new CArrayDataProvider($records,
            array(
            	'keyField'=>false,  //don't have 'id' column
            	'sort'=>$sort,
                // 'sort' => array( //optional and sortring
                //     'attributes' => array(
                //         'project', 
                //         'contract',
                //         'date_end',
                //         'alarm_detail',
                //     ),
                // ),
                'pagination' => array('pageSize' => 10) //optional add a pagination
            )
        );
*/

 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>false,
    'type'=>'vertical',
    'htmlOptions'=>  array('class'=>'well','style'=>'margin:0 auto;padding-top:20px;'),
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); 

?>

    <div class="row-fluid">
        
       <div class="span3"> 
              <?php

                    echo CHtml::label('โครงการ','project');
                   
                    echo "<input type='text' class='span12' id='project' name='project' value='' >";
                                
              ?>
       </div>
        <div class="span2"> 
            <?php

                    echo CHtml::label('สัญญา','contract');
                   
                    echo "<input type='text' class='span12' id='contract' name='contract' value='' >";
                                
              ?>
        </div>
        <div class="span3"> 
            <?php

                    echo CHtml::label('ประเภทการเตือน','type');
                   
                    echo CHtml::dropDownList('type', '', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>''));                              
              ?>
        </div>
        <div class="span3"> 
            <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                      'buttonType'=>'submit',
                      
                      'type'=>'info',
                      'label'=>'search',
                      'icon'=>'search white',
                      
                      'htmlOptions'=>array(
                        'class'=>'span6',
                        'style'=>'margin:25px 10px 0px 0px;',
                        'id'=>'searchNotify'
                      ),
                  ));
              ?>
        </div>
        
    </div>
    
<?php $this->endWidget(); 

 $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'notify-grid',
	//'dataProvider'=>$provAll,
	'type'=>'bordered condensed',
	
	'dataProvider'=>$model->search(),
    'filter'=>$model,
	'selectableRows' =>2,
	'htmlOptions'=>array('style'=>'padding-top:40px'),
    'enablePagination' => true,
    'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
    'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
	'columns'=>array(
		
		'proj'=>array(
			    'name' => 'project',
			    'header'=>$model->getAttributeLabel('project'),
			    'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		'con'=>array(
			    'name' => 'contract',
			    'header'=>$model->getAttributeLabel('contract'),
			    'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),	
	  	'details'=>array(
			    'name' => 'alarm_detail',
			    'header'=>$model->getAttributeLabel('alarm_detail'),
			    'filter'=>CHtml::activeDropDownList($model, 'alarm_detail', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'')),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
	  	'end'=>array(
			    'name' => 'date_end',
			    'header'=>$model->getAttributeLabel('date_end'),
			    //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
				//call the method 'gridDataColumn' from the controller
                'value'=>array($this,'gridDateRender'),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #f5f5f5'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:center;')
	  	), 
	     array(
								'class'=>'bootstrap.widgets.TbButtonColumn',
								'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #eeeeee'),
								'template' => '{update}',
								'buttons'=>array(
										'update' => array
					                    (
					                        
					                        'icon'=>'icon-pencil',
					                        'url'=>'Yii::app()->createUrl($data["url"])',
					                        'options'=>array(
					                            //'id'=>'$data["id"]',
					                            //'new_attribute'=> '$data["your_key"]',
					                        ),
					                    ),
								)
		)	
	),
)); ?>
