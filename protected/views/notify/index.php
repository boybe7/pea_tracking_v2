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
 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'=>'search-form',
    'enableAjaxValidation'=>false,
    'type'=>'vertical',
    'htmlOptions'=>  array('class'=>'well','style'=>'margin:0 auto;padding-top:20px;background-color: #eeeeee'),
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); 



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


/*
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
)); 
*/

?>

<br>
<ul class="nav nav-tabs">
      
      <?php
            $sql = "SELECT count(id) as amount,type  FROM notify  GROUP BY type ORDER BY type ASC";                  
            $notifyData = Yii::app()->db->createCommand($sql)->queryAll();
            $amount[1] = $amount[2] = $amount[3] = $amount[4] = $amount[5] = $amount[6] = '';
            foreach ($notifyData as $key => $value) {
                $amount[$value['type']] = $value['amount'];
            }

            $badge= '';
            if($amount[1]>0) 
              $badge=$this->widget('bootstrap.widgets.TbBadge', array(
                'type'=>'warning',
                'label'=>$amount[1],
            ), true);

            if(!isset($_GET['tab']) || (isset($_GET['tab']) && $_GET['tab']==1) )
              echo '<li  class="active"><a href="#garanteeTab" data-toggle="tab">ค้ำประกันสัญญา '.$badge.'</a></li>';
            else
              echo '<li ><a href="#garanteeTab" data-toggle="tab">ค้ำประกันสัญญา '.$badge.'</a></li>';

           $badge= '';
            if($amount[2]>0) 
              $badge=$this->widget('bootstrap.widgets.TbBadge', array(
                'type'=>'warning',
                'label'=>$amount[2],
            ), true);
            if(isset($_GET['tab']) && $_GET['tab']==2 )      
              echo '<li class="active"><a href="#vendorTab" data-toggle="tab">ชำระเงินของลูกค้า '.$badge.'</a></li>';
            else
              echo '<li ><a href="#vendorTab" data-toggle="tab">ชำระเงินของลูกค้า '.$badge.'</a></li>';
           

            $badge= '';
            if($amount[3]>0) 
              $badge=$this->widget('bootstrap.widgets.TbBadge', array(
                'type'=>'warning',
                'label'=>$amount[3],
            ), true); 
            if(isset($_GET['tab']) && $_GET['tab']==3 )     
              echo '<li class="active" ><a href="#supplierTab" data-toggle="tab">จ่ายเงินให้ผู้รับจ้าง/ผู้ขาย '.$badge.'</a></li>';
            else
              echo '<li ><a href="#supplierTab" data-toggle="tab">จ่ายเงินให้ผู้รับจ้าง/ผู้ขาย '.$badge.'</a></li>';
            
            $badge= '';
            if($amount[4]>0) 
              $badge=$this->widget('bootstrap.widgets.TbBadge', array(
                'type'=>'warning',
                'label'=>$amount[4],
            ), true);    
            if(isset($_GET['tab']) && $_GET['tab']==4 ) 
              echo '<li class="active"><a href="#manageTab" data-toggle="tab">บันทึกค่ารับรอง '.$badge.'</a></li>';
            else
                 echo '<li ><a href="#manageTab" data-toggle="tab">บันทึกค่ารับรอง '.$badge.'</a></li>';                

            $badge= '';
            if($amount[5]>0) 
              $badge=$this->widget('bootstrap.widgets.TbBadge', array(
                'type'=>'warning',
                'label'=>$amount[5],
            ), true); 
            if(isset($_GET['tab']) && $_GET['tab']==5 ) 
              echo '<li class="active"><a href="#closeTab" data-toggle="tab">ปิดงาน '.$badge.'</a></li>';
            else
              echo '<li ><a href="#closeTab" data-toggle="tab">ปิดงาน '.$badge.'</a></li>';  


          if(Yii::app()->user->username=='tsd' || Yii::app()->user->username=='tsd01' || Yii::app()->user->username=='tsd02' || Yii::app()->user->username=='tsd03')  
          {
            $badge= '';
            if($amount[6]>0) 
              $badge=$this->widget('bootstrap.widgets.TbBadge', array(
                'type'=>'warning',
                'label'=>$amount[6],
            ), true);
            if(isset($_GET['tab']) && $_GET['tab']==6 )
                echo  '<li class="active"><a href="#1000Tab" data-toggle="tab">ของบ .1000 '.$badge.'</a></li>';
            else
                echo  '<li ><a href="#1000Tab" data-toggle="tab">ของบ .1000 '.$badge.'</a></li>';
          }

       ?>     
        
</ul>
<div class="tab-content">
    <?php
        if(!isset($_GET['tab']) || (isset($_GET['tab']) && $_GET['tab']==1) )  
          echo '<div class="tab-pane active " id="garanteeTab">';
        else
          echo '<div class="tab-pane " id="garanteeTab">';   
    ?>     
         <center><h4>แจ้งเตือนครบกำหนดค้ำประกันสัญญา</h4></center>
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
                            'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
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
    
    <?php
       if(isset($_GET['tab']) && $_GET['tab']==2 ) 
            echo '<div class="tab-pane active" id="vendorTab">';
       else 
            echo '<div class="tab-pane " id="vendorTab">';
    ?>   
         <center><h4>แจ้งเตือนครบกำหนดชำระเงินของลูกค้า</h4></center>
         <?php

            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-vendor',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(2),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>'padding-top:10px'),
                'enablePagination' => true,
                'summaryText'=>'แสดงผล {start} ถึง {end} จากทั้งหมด {count} ข้อมูล',
                'template'=>"{items}<div class='row-fluid'><div class='span6'>{pager}</div><div class='span6'>{summary}</div></div>",
                'columns'=>array(
                    'detail'=>array(
                            'name' => 'alarm_detail',
                            'header'=>$model->getAttributeLabel('alarm_detail'),
                            'filter'=>CHtml::activeTextField($model, 'alarm_detail',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("alarm_detail"))),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
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
                            'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #eeeeee'),                       
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
    

    <?php
       if(isset($_GET['tab']) && $_GET['tab']==3 ) 
            echo '<div class="tab-pane active" id="supplierTab">';
       else 
            echo '<div class="tab-pane " id="supplierTab">';
    ?>       
         <center><h4>แจ้งเตือนครบกำหนดจ่ายเงินให้ผู้รับ้จาง/ผู้ขาย</h4></center>
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
                            'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
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
 

     <?php
       if(isset($_GET['tab']) && $_GET['tab']==4 ) 
            echo '<div class="tab-pane active" id="manageTab">';
       else 
            echo '<div class="tab-pane " id="manageTab">';
    ?>        

        <center><h4>แจ้งเตือนบันทึกค่ารับรองประจำเดือน</h4></center>
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
                            'value'=>array($this,'gridProjectRender'),
                            'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
/*'workcat'=>array(
                            'name' => 'workcat',
                            'header'=>'ประเภทงาน',
                    
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
                   
                    'year'=>array(
                            'name' => 'year',
                            'header'=>'ปีงบประมาณ',
                            //'value'=>array($this,'gridDateRender'),
                            'headerHtmlOptions' => array('style' => 'width:10%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:center;')
                    ), */
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
   
      <?php
       if(isset($_GET['tab']) && $_GET['tab']==5 ) 
            echo '<div class="tab-pane active" id="closeTab">';
       else 
            echo '<div class="tab-pane " id="closeTab">';
    ?>           
        <center><h4>แจ้งเตือนปิดโครงการ</h4></center>
         <?php
                        

            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-close',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(5),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>''),
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
                    'proj'=>array(
                            'name' => 'project',
                            'header'=>$model->getAttributeLabel('project'),
                            'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
                            'headerHtmlOptions' => array('style' => 'width:37%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
                            'headerHtmlOptions' => array('style' => 'width:20%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  

                    'T'=>array(
                            'name' => 'pc_T_percent',
                            'header' => '<a class="sort-link">ความก้าวหน้าด้านเทคนิค (%T)</a>',
                            'filter'=>false,
                            'type'=>'raw', 
                            'value' => function($model){
                                 return $model->getPercentT($model);
                             },
                            'headerHtmlOptions' => array('style' => 'width:13%;text-align:center;background-color: #eeeeee'),                       
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
                                        'url'=>'Yii::app()->createUrl($data["url"])'
                                    ),
                            )
                    )   
                ),
            )); 

        ?>
    </div> 

    <?php
    if(Yii::app()->user->username=='tsd' || Yii::app()->user->username=='tsd01' || Yii::app()->user->username=='tsd02' || Yii::app()->user->username=='tsd03') 
    { 

       if(isset($_GET['tab']) && $_GET['tab']==6 ) 
            echo '<div class="tab-pane active" id="1000Tab">';
       else 
            echo '<div class="tab-pane " id="1000Tab">';
    ?>      
   
        <center><h4>แจ้งเตือนของบประมาณ .1000</h4></center>
         <?php
           
           

            $this->widget('bootstrap.widgets.TbGridView',array(
                'id'=>'notify-grid-1000',
                'type'=>'bordered condensed',            
                'dataProvider'=>$model->searchByType(6),
                'filter'=>$model,
                'selectableRows' =>2,
                'htmlOptions'=>array('style'=>''),
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
                    'proj'=>array(
                            'name' => 'project',
                            'header'=>$model->getAttributeLabel('project'),
                            'filter'=>CHtml::activeTextField($model, 'project',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("project"))),
                            'headerHtmlOptions' => array('style' => 'width:40%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),
                    'con'=>array(
                            'name' => 'contract',
                            'header'=>$model->getAttributeLabel('contract'),
                            'filter'=>CHtml::activeTextField($model, 'contract',array("placeholder"=>"ค้นหาตาม".$model->getAttributeLabel("contract"))),
                            'headerHtmlOptions' => array('style' => 'width:30%;text-align:center;background-color: #eeeeee'),                       
                            'htmlOptions'=>array('style'=>'text-align:left;padding-left:10px;')
                    ),  
                   
                    array(
                            'class'=>'bootstrap.widgets.TbButtonColumn',
                            'headerHtmlOptions' => array('style' => 'width:5%;text-align:center;background-color: #eeeeee'),
                            'template' => '{update}',
                            'buttons'=>array(
                                'update' => array
                                    (
                                                        
                                        'icon'=>'icon-pencil',
                                        'url'=>'Yii::app()->createUrl($data["url"])'
                                    ),
                            )
                    ) 
                    
                ),
            ));  

        ?>
    </div>  
    <?php }?>   
</div>