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
    $('#Notify_alarm_detail').val($('#type').val())
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
    'htmlOptions'=>  array('class'=>'well','style'=>'margin:0 auto;padding-top:20px;background-color: #eeeeee'),
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
        <div class="span2"> 
            <?php

                    echo CHtml::label('ประเภทการเตือน','type');
                   
                    echo CHtml::dropDownList('type', '', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'','class'=>'span12'));                              
              ?>
        </div>
        <div class="span2"> 
            <?php

                    echo CHtml::label('วันที่เริ่มต้น', 'date_start');
                    echo '<div style="margin-top:0px;">'; //ใส่ icon ลงไป
                    $this->widget('zii.widgets.jui.CJuiDatePicker',
                            array(
                                'name' => 'date_start',
                                'attribute' => 'date_start',
                                'options' => array(
                                    'mode' => 'focus',
                                    //'language' => 'th',
                                    'format' => 'dd/mm/yyyy', //กำหนด date Format
                                    'showAnim' => 'slideDown',
                                ),
                                'htmlOptions' => array('class' => 'span12','autocomplete'=>'off'), // ใส่ค่าเดิม ในเหตุการ Update
                            )
                    );
                     //echo '<span class="add-on"><i class="icon-calendar"></i></span>';
                    echo '</div>'; 
                                
              ?>
        </div>
        <div class="span2"> 
            <?php

                    echo CHtml::label('วันที่สิ้นสุด', 'date_end');
                    echo '<div style="margin-top:0px;">'; //ใส่ icon ลงไป
                    $this->widget('zii.widgets.jui.CJuiDatePicker',
                            array(
                                'name' => 'date_end',
                                'attribute' => 'date_end',
                                'options' => array(
                                    'mode' => 'focus',
                                    //'language' => 'th',
                                    'format' => 'dd/mm/yyyy', //กำหนด date Format
                                    'showAnim' => 'slideDown',
                                ),
                                'htmlOptions' => array('class' => 'span12','autocomplete'=>'off'), // ใส่ค่าเดิม ในเหตุการ Update
                            )
                    );
                    //echo '<span class="add-on"><i class="icon-calendar"></i></span>';
                    echo '</div>';            
              ?>
        </div>
        <div class="span1"> 
            <?php
                $this->widget('bootstrap.widgets.TbButton', array(
                      'buttonType'=>'submit',
                      
                      'type'=>'info',
                      'label'=>'',
                      'icon'=>'search white',
                      
                      'htmlOptions'=>array(
                        'class'=>'span12',
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
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
		'con'=>array(
			    'name' => 'contract',
			    'header'=>$model->getAttributeLabel('contract'),
			    'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),	
	  	'details'=>array(
			    'name' => 'alarm_detail',
			    'header'=>$model->getAttributeLabel('alarm_detail'),
			    'filter'=>CHtml::activeDropDownList($model, 'alarm_detail', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'')),
				'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),  	            	  	
				'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
	  	),
	  	'end'=>array(
			    'name' => 'date_end',
			    'header'=>$model->getAttributeLabel('date_end'),
			    //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
				//call the method 'gridDataColumn' from the controller
                'value'=>array($this,'gridDateRender'),
				'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),  	            	  	
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


<ul class="nav nav-tabs">
      <li  class="active"><a href="#garanteeTab" data-toggle="tab">ค้ำประกันสัญญา</a></li>
      <li ><a href="#vendorTab" data-toggle="tab">ชำระเงินของ vendor</a></li>
      <li ><a href="#supplierTab" data-toggle="tab">จ่ายเงินให้ supplier</a></li>
      <li ><a href="#manageTab" data-toggle="tab">บันทึกค่ารับรอง</a></li>
      <li ><a href="#closeTab" data-toggle="tab">ปิดงาน</a></li>
        
</ul>
<div class="tab-content">
    <div class="tab-pane active " id="garanteeTab">
        <?php
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-garantee',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(1),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>'padding-top:10px'),
                'enablePagination' => true,
                'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
                'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
                'columns'=>array(
                    
                    'proj'=>array(
                            'name' => 'project',
                            'header'=>$model->getAttributeLabel('project'),
                            'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
                    'details'=>array(
                            'name' => 'alarm_detail',
                            'header'=>$model->getAttributeLabel('alarm_detail'),
                            'filter'=>CHtml::activeDropDownList($model, 'alarm_detail', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'')),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'end'=>array(
                            'name' => 'date_end',
                            'header'=>$model->getAttributeLabel('date_end'),
                            //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
                            //call the method 'gridDataColumn' from the controller
                            'value'=>array($this,'gridDateRender'),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
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
            )); 

        ?>
    </div>  
    <div class="tab-pane " id="vendorTab">
         <?php
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-garantee',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(2),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>'padding-top:10px'),
                'enablePagination' => true,
                'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
                'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
                'columns'=>array(
                    
                    'proj'=>array(
                            'name' => 'project',
                            'header'=>$model->getAttributeLabel('project'),
                            'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
                    'details'=>array(
                            'name' => 'alarm_detail',
                            'header'=>$model->getAttributeLabel('alarm_detail'),
                            'filter'=>CHtml::activeDropDownList($model, 'alarm_detail', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'')),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'end'=>array(
                            'name' => 'date_end',
                            'header'=>$model->getAttributeLabel('date_end'),
                            //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
                            //call the method 'gridDataColumn' from the controller
                            'value'=>array($this,'gridDateRender'),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
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
            )); 

        ?>
    </div> 
    <div class="tab-pane " id="supplierTab">
         <?php
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-supplier',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(3),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>'padding-top:10px'),
                'enablePagination' => true,
                'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
                'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
                'columns'=>array(
                    
                    'proj'=>array(
                            'name' => 'project',
                            'header'=>$model->getAttributeLabel('project'),
                            'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
                    'details'=>array(
                            'name' => 'alarm_detail',
                            'header'=>$model->getAttributeLabel('alarm_detail'),
                            'filter'=>CHtml::activeDropDownList($model, 'alarm_detail', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'')),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'end'=>array(
                            'name' => 'date_end',
                            'header'=>$model->getAttributeLabel('date_end'),
                            //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
                            //call the method 'gridDataColumn' from the controller
                            'value'=>array($this,'gridDateRender'),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
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
            )); 

        ?>
    </div> 
    <div class="tab-pane " id="manageTab">
         <?php
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-manage',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(4),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>'padding-top:10px'),
                'enablePagination' => true,
                'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
                'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
                'columns'=>array(
                    
                    'proj'=>array(
                            'name' => 'project',
                            'header'=>$model->getAttributeLabel('project'),
                            'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
                    'details'=>array(
                            'name' => 'alarm_detail',
                            'header'=>$model->getAttributeLabel('alarm_detail'),
                            'filter'=>CHtml::activeDropDownList($model, 'alarm_detail', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'')),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'end'=>array(
                            'name' => 'date_end',
                            'header'=>$model->getAttributeLabel('date_end'),
                            //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
                            //call the method 'gridDataColumn' from the controller
                            'value'=>array($this,'gridDateRender'),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
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
            )); 

        ?>
    </div> 
    <div class="tab-pane " id="closeTab">
         <?php
            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-close',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(5),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>'padding-top:10px'),
                'enablePagination' => true,
                'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
                'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
                'columns'=>array(
                    
                    'proj'=>array(
                            'name' => 'project',
                            'header'=>$model->getAttributeLabel('project'),
                            'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
                    'details'=>array(
                            'name' => 'alarm_detail',
                            'header'=>$model->getAttributeLabel('alarm_detail'),
                            'filter'=>CHtml::activeDropDownList($model, 'alarm_detail', array('แจ้งเตือนครบกำหนดค้ำประกันสัญญา' => 'แจ้งเตือนครบกำหนดค้ำประกันสัญญา', 'แจ้งเตือนครบกำหนดชำระเงินของ vendor' => 'แจ้งเตือนครบกำหนดชำระเงินของ vendor','แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier'=>'แจ้งเตือนครบกำหนดจ่ายเงินให้ supplier','แจ้งเตือนบันทึกค่ารับรองประจำเดือน'=>'แจ้งเตือนบันทึกค่ารับรองประจำเดือน'),array('empty'=>'')),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'end'=>array(
                            'name' => 'date_end',
                            'header'=>$model->getAttributeLabel('date_end'),
                            //'filter'=>CHtml::activeTextField($model, 'v_name',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("v_name"))),
                            //call the method 'gridDataColumn' from the controller
                            'value'=>array($this,'gridDateRender'),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
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
            )); 

        ?>
    </div>   
</div>