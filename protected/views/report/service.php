<?php
$this->breadcrumbs=array(
	'Service Report ',
	
);

$theme = Yii::app()->theme;
$cs = Yii::app()->clientScript;
$cs->registerScriptFile( $theme->getBaseUrl() . '/js/jquery.json-2.3.min.js' );
//$cs->registerScriptFile( $theme->getBaseUrl() . '/js/drilldown.js' );

?>

<script type="text/javascript">
$(document).ready(function(){
 
  
  $('#chart').change(function() {

       if($(this).val()==4||$(this).val()==2)
       {
          $('#department').removeAttr('disabled');
          $('#workcat').attr('disabled', 'disabled');
       }
       else if($(this).val()==3)
       {
          $('#workcat').attr('disabled', 'disabled');
          $('#department').attr('disabled', 'disabled');
       }
       else
       {
          $('#workcat').removeAttr('disabled');
          $('#department').removeAttr('disabled');
       }
   });
});    
</script>
<style>

.reportTable thead th {
	text-align: center;
	font-weight: bold;
	background-color: #eeeeee;
	vertical-align: middle;
	}

.reportTable td {
	
}
@media print
{
body * { visibility: hidden;}
#reportContent * { visibility: visible; }
#reportContent { position: absolute; top: 40px; left: 30px; }

/*#print * { visibility: visible;height:100%;}
#print { position: absolute; top: 40px; left: 30px; }*/
}

</style>


<h4>รายงานสรุปรายได้ ค่าใช้จ่ายงานบริการวิศวกรรม</h4>
<div class="row-fluid">
  <div class="well span4">
    
      <div class="row-fluid">
    	<div class="span3">
    		<?php

                $projects =Project::model()->findAll(array(
        				'select'=>'pj_fiscalyear',
                'order'=>'pj_fiscalyear ASC',
        				//'group'=>'t.Category',
        				'distinct'=>true,
    				));   

    			//print_r($projects);	     
         
                $list = CHtml::listData($projects,'pj_fiscalyear','pj_fiscalyear');
                
                $list = array();
                $current_y =  date("Y")+543;
                for($i=$current_y;$i>=$current_y-10;$i--)
                    $list[$i] = $i;  
                
                //print_r($list);
                echo CHtml::label('ปี','fiscalyear');  
                echo CHtml::dropDownList('fiscalyear', '', 
                                $list,array('class'=>'span12'
                                	
                                ));
                 	
    		?>

    	</div>

    	<div class="span9">

    	<!-- </div> -->
    	<!-- <div class="span1"> -->
    	  <?php
    		
          ?>
    	</div>
    
    </div>


    <div class="row-fluid">
      <div class="span12">
          <?php

               
              
                echo CHtml::label('กราฟ','chart');  
                echo CHtml::dropDownList('chart', '', 
                                array("1"=>"รายได้การให้บริการงานวิศวกรรม","2"=>"ค่าใช้จ่ายจ้างเหมาและค่าดำเนินงาน",
                                      "3"=>"ค่าใช้จ่ายจ้างเหมาและค่าดำเนินงานแยกตามประเภทงาน",
                                      "4"=>"เปรียบเทียบรายได้กับค่าใช้จ่าย"
                                      ),array('class'=>'span12'
                              
                                  ));
                  
        ?>

      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
        <?php
     
                $workcat = Yii::app()->db->createCommand()
                    ->select('id,name')
                    ->from('department')
                    ->queryAll();

                 //print_r($projects);   
     
                $typelist = CHtml::listData($workcat,'id','name');
                 echo CHtml::label('กอง','department');
                echo CHtml::dropDownList('department', '', $typelist,array('empty'=>'ทุกกอง','class'=>'span12'
                              
                                  ));
        ?>
      </div>
    </div>
    <div class="row-fluid">
      <div class="span12">
          <?php

               
              
                echo CHtml::label('ประเภทงาน','workcat');  
                $workcat = Yii::app()->db->createCommand()
                    ->select('wc_id,wc_name as name')
                    ->from('work_category')
                    ->queryAll();
     
                $typelist = CHtml::listData($workcat,'wc_id','name');
                echo CHtml::dropDownList('workcat', '',$typelist,array('empty'=>'ทุกประเภท','class'=>'span12'
                              
                                  ));
                  
        ?>

      </div>
    </div>


      <?php
        $this->widget('bootstrap.widgets.TbButton', array(
                  'buttonType'=>'link',
                  
                  'type'=>'inverse',
                  'label'=>'view',
                  'icon'=>'list-alt white',
                  
                  'htmlOptions'=>array(
                    'class'=>'span4',
                    'style'=>'margin:25px 10px 0px 0px;',
                    'id'=>'gentReport'
                  ),
              ));

        $this->widget('bootstrap.widgets.TbButton', array(
                  'buttonType'=>'link',
                  
                  'type'=>'info',
                  'label'=>'Word',
                  'icon'=>'word',
                  
                  'htmlOptions'=>array(
                    'class'=>'span4',
                    'style'=>'margin:25px 10px 0px 0px;padding-left:0px;padding-right:0px',
                    'id'=>'exportWord'
                  ),
              ));

          // $this->widget('bootstrap.widgets.TbButton', array(
          //         'buttonType'=>'link',
                  
          //         'type'=>'success',
          //         'label'=>'',
          //         'icon'=>'print white',
                  
          //         'htmlOptions'=>array(
          //           'class'=>'span2',
          //           'style'=>'margin:25px 0px 0px 0px;',
          //           'id'=>'printReport'
          //         ),
          //     ));
      ?>
  </div><!-- end span4--> 
  <div class="span8 well"> 
    <div id="reportContent" style="width: auto; height: 400px; margin: 0 auto;">
       <?php $this->widget('ext.highcharts.HighchartsWidget', array('id' => 'divChart',
                       'htmlOptions'=>array(),  
                       'scripts' => array(
                          'modules/drilldown', // in fact, this is mandatory :)
                          'modules/exporting',
                          ),

                       'options'=>array(
                           'gradient' => array('enabled'=> true),
                           'chart' => array('type' => 'pie',
                                             //'marginTop' => 60,
                                             //'marginButtom' => 40,
                                              'spacingTop'=> 10,
                                              'spacingBottom'=> 10,
                                              'spacingLeft'=> 0,
                                              'spacingRight'=> 0,
                                             //'marginLeft' => 10,
                                                      'options3d'=>array(
                                                            'enabled'=> true,
                                                            'alpha'=> 45,
                                                            'beta'=> 0
                                             )  
                            ), 
                            'colors'=>array(
                              '#BA514B','#5280BE','#8165A2','#9DBB5B','#50A9C7','#F29B4B','#A8BED5'
                              ),
                            'credits'=> array(
                                  'enabled'=> false
                              ),
                           'title' => array('text' => '','style' => array(
                                          'fontWeight' => 'bold',
                                          'fontSize'=>'25px',
                                          'fontFamily' => 'TH SarabunPSK'
                                          ) ), 
                           'tooltip'=>array(
                                'pointFormat'=>'<b>{point.percentage:.2f}% <br> {point.y} บาท</b>'
                            ),
                           'legend' => array(
                                    'enabled'=> true,
                                    //'layout'=> "horizontal",
                                    'align'=>"center",
                                    'width'=> 520,
                                    //'verticalAlign'=>"middle",
                                    'borderWidth'=> 0,
                                    'itemStyle'=> array(
                                        'fontWeight'=> "bold",
                                        'fontSize'=>'18px',
                                        'fontFamily' => 'TH SarabunPSK'
                                     ),
                                    'title'=> array(
                                      'text'=> "",
                                      'style'=> array(
                                        'fontWeight'=> "bold",
                                        'fontSize'=>'18px',
                                        'fontFamily' => 'TH SarabunPSK'
                                     )
                                    )
                                   
                               ),
                           'plotOptions'=>array (
                             
                              'pie' => array(
                                  'size'=>'100%',
                                  'allowPointSelect'=> true,
                                  'borderWidth'=> 3,
                                  //'animation'=> true,
                                  'depth'=> 35,
                                  'cursor'=> "pointer",
                                  'dataLabels' => array(
                                      'enabled' => true,
                                      //'distance' => -30,
                                      'style' => array(
                                          //'fontWeight' => 'bold',
                                          
                                          'fontSize'=>'13px',
                                          //'fontFamily' => 'TH SarabunPSK',
                                          'color' => 'black',
                                          //'textShadow' => '0px 1px 2px black',
                                      ),
                                       'formatter'=> 'js:function() {
                                            
                                          return "<b>"+this.point.y.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+" บาท ("+Math.round(this.point.percentage)+"%)</b>"
                                        }',
                                  ),
                                 
                              ),
                              'column'=> array(
                                  'pointPadding'=> 0.2,
                                  'borderWidth'=> 0
                              )

                            ),
                            'exporting'=> array(
                              'type'=> 'image/jpeg',
                              'url'=>''
                            ),
                            'drilldown'=> array(
                               'id'=>'xx',
                            
                               'data'=> array(10.85, 7.35, 33.06, 2.81)
                            )   

                        )

                    )); ?>
    </div>



    <div id="reportContent2" style="width: auto; height: 400px; margin: 0 auto; display:none">
       <?php $this->widget('ext.highcharts.HighchartsWidget', array('id' => 'divChart2',
                       'htmlOptions'=>array(),  
                       'scripts' => array(
                          'modules/drilldown', // in fact, this is mandatory :)
                          'modules/exporting',
                          ),

                       'options'=>array(
                           'gradient' => array('enabled'=> true),
                           'chart' => array('type' => 'pie',
                                            // 'marginTop' => 60,
                                             //'marginButtom' => 40,
                                              'spacingTop'=> 10,
                                              'spacingBottom'=> 10,
                                              'spacingLeft'=> 0,
                                              'spacingRight'=> 0,
                                                
                                                      'options3d'=>array(
                                                            'enabled'=> true,
                                                            'alpha'=> 45,
                                                            'beta'=> 0
                                             )  
                            ), 
                            'colors'=>array(
                              '#BA514B','#5280BE','#8165A2','#9DBB5B','#50A9C7','#F29B4B','#A8BED5'
                              ),
                            'credits'=> array(
                                  'enabled'=> false
                              ),
                           'title' => array('text' => '','style' => array(
                                          'fontWeight' => 'bold',
                                          'fontSize'=>'25px',
                                          'fontFamily' => 'TH SarabunPSK'
                                          ) ), 
                           'tooltip'=>array(
                                'pointFormat'=>'<b>{point.percentage:.2f}% <br> {point.y} บาท</b>'
                            ),
                           'legend' => array(
                                    'enabled'=> true,
                                    //'layout'=> "vertical",
                                    'align'=>"center",
                                    'width'=> 420,
                                    //'verticalAlign'=>"middle",
                                    'borderWidth'=> 0,
                                    'itemStyle'=> array(
                                        'fontWeight'=> "bold",
                                        'fontSize'=>'18px',
                                        'fontFamily' => 'TH SarabunPSK'
                                     ),
                                    'title'=> array(
                                      'text'=> "",
                                      'style'=> array(
                                        'fontWeight'=> "bold",
                                        'fontSize'=>'18px',
                                        'fontFamily' => 'TH SarabunPSK'
                                     )
                                    )
                                   
                               ),
                           'plotOptions'=>array (
                             
                              'pie' => array(
                                  'allowPointSelect'=> true,
                                  'borderWidth'=> 3,
                                  //'animation'=> true,
                                  'depth'=> 35,
                                  'cursor'=> "pointer",
                                  'dataLabels' => array(
                                      'enabled' => true,
                                      //'distance' => -30,
                                      'style' => array(
                                          //'fontWeight' => 'bold',
                                          
                                          'fontSize'=>'13px',
                                          //'fontFamily' => 'TH SarabunPSK',
                                          'color' => 'black',
                                          //'textShadow' => '0px 1px 2px black',
                                      ),
                                       'formatter'=> 'js:function() {
                                            
                                          return "<b>"+this.point.y.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")+" บาท ("+Math.round(this.point.percentage)+"%)</b>"
                                        }',
                                  ),
                                 
                              ),

                            ),
                            'exporting'=> array(
                              'type'=> 'image/jpeg',
                              'url'=>''
                            ),
                            'drilldown'=> array(
                               'id'=>'xx',
                            
                               'data'=> array(10.85, 7.35, 33.06, 2.81)
                            )   

                        )

                    )); ?>
    </div>
  </div>
</div>    
<?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
<script type="text/javascript">
  var chart;
  function format(num, fix) {
    var p = num.toFixed(fix).split(".");
    return p[0].split("").reduceRight(function(acc, num, i, orig) {
        if ("-" === num && 0 === i) {
            return num + acc;
        }
        var pos = orig.length - i - 1
        return  num + (pos && !(pos % 3) ? "," : "") + acc;
    }, "") + (p[1] ? "." + p[1] : "");
}

function download(url, data, method){
  //url and data options required
  if( url && data ){ 
    //data can be string of parameters or array/object
    data = typeof data == 'string' ? data : jQuery.param(data);
    //split params into form inputs
    var inputs = '';
    jQuery.each(data.split('&'), function(){ 
      var pair = this.split('=');
      inputs+='<input type="hidden" name="'+ pair[0] +'" value="'+ pair[1] +'" />'; 
    });
    //send request
    jQuery('<form action="'+ url +'" method="'+ (method||'post') +'">'+inputs+'</form>')
    .appendTo('body').submit().remove();
  };
};

</script>

<?php
//Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerScript('gentReport', '


$("#gentReport").click(function(e){
    e.preventDefault();
    $.ajax({
        url: "genService",
        data: {fiscalyear: $("#fiscalyear").val(),report:$("#chart").val(),workcat:$("#workcat").val(),department:$("#department").val()},
        dataType: "json",
        success:function(response){
           
          var series1 = [];
          var series2 = [];
          var series3 = [];
          var seriesDrill = [];
          var drill = [];
          
          if($("#chart").val()==4 && $("#department").val()=="")
          {
                 
                           $.each(response, function(key, val2) {
                                  
                                  if(val2["name"]=="กบศ.")
                                  {
                                    
                                    $.each(val2["value"], function(key, val) {
                                      
                                      console.log("กบศ.:"+val["name"]+":"+val["value"]);  
                                      val["value"] = val["value"]!=null ? val["value"] : 0;
                                      
                                        series1.push({name:val["name"],y:parseInt(val["value"])});
                                    });  
                                      
                                  }
                                  else if(val2["name"]=="กบจ.")
                                  {

                                    $.each(val2["value"], function(key, val) {
                                      val["value"] = val["value"]!=null ? val["value"] : 0;
                                      series2.push({name:val["name"],y:parseInt(val["value"])});
                                    });
                                  }
                                  else
                                  {
                                    $.each(val2["value"], function(key, val) {
                                      val["value"] = val["value"]!=null ? val["value"] : 0;
                                      series3.push({name:val["name"],y:parseInt(val["value"])});
                                    });
                                  }

                                  
                              
                           });
          } 
          else
          {             
                           var idx = 0;
                           var idy = 0;
                           $.each(response, function(key, val) {
                                val["value"] = val["value"]==null ? 0 : val["value"];
                                //val["value"] = val["value"]==0 ? 10 : val["value"];
                                
                              if(val["value"]!=0)  
                                if(val["drill"].length > 0)
                                {  
                                  
                                  if(idx==0)
                                    series1.push({name:val["name"],y:parseInt(val["value"]),selected: true,sliced: true,drilldown:"drill"+idx});
                                  else
                                    series1.push({name:val["name"],y:parseInt(val["value"]),sliced: true,drilldown:"drill"+idx});
                                  
                                  //console.log("name:"+val["name"]+"y:"+(val["drill"]));  
                                  
                                  //seriesDrill.push({id:"drill"+idx,data:val["drill"],sliced: true,showInLegend : true});
                                  
                                  drill = val["drill"];
                                  idx++;

                                }
                                else
                                {  
                                    series1.push({name:val["name"],y:parseInt(val["value"]),sliced: true});
                                  
                                  //console.log("name:"+val["name"]+"y:"+parseInt(val["value"]))

                                }                                
                           });
          } 
          var chart = $("#divChart").highcharts();
          
             
            // remove old data
            $(chart.series).each(function() {
                this.remove();
            });

            
          if($("#chart").val()==4 && $("#department").val()=="")
          {
            
             chart.options.chart.type = "column";
             chart.options.chart.marginTop = 0;
              chart.options.chart.options3d.enabled = false;
             //console.log(chart)
            
             chart.legend.options.layout = "horizontal";
             
            //  console.log(chart)
            // add new data
            var seriesOpts_01 = {
                
                name: "กบศ.",
                data: series1,
                showInLegend : true,
                dataLabels: {
                    enabled: true,
                    rotation:-90,
                    align: "top",
                    format: "{point.y:,.2f}", // one decimal
                    
                    style: {
                        fontSize: "13px",
                        fontFamily: "Verdana, sans-serif"
                    }
                }
                          
            }
            
            chart.addSeries(seriesOpts_01);

            var seriesOpts_03 = {
                
                name: "กบจ.",
                data: series2,
                showInLegend : true,
                dataLabels: {
                    enabled: true,
                    rotation:-90,
                    align: "top",
                    format: "{point.y:,.2f}", // one decimal
                    
                    style: {
                        fontSize: "13px",
                        fontFamily: "Verdana, sans-serif"
                    }
                }
                          
            }
            chart.addSeries(seriesOpts_03);

            var seriesOpts_04 = {
                
                name: "กรษ.",
                data: series3,
                showInLegend : true,
                dataLabels: {
                    enabled: true,
                    rotation:-90,
                    align: "top",
                    format: "{point.y:,.2f}", // one decimal
                    
                    style: {
                        fontSize: "13px",
                        fontFamily: "Verdana, sans-serif"
                    }
                }
                          
            }
            chart.addSeries(seriesOpts_04);
            //chart.yAxis[0].options.title = "จำนวนเงิน";
            //console.log(chart)
            chart.xAxis[0].setCategories(["รายได้","ค่าใช้จ่ายจ้างเหมา","ค่าใช้จ่ายดำเนินงาน","ค่าใช้จ่ายบริหารงาน"]);


              chart.setTitle({text: $( "#chart option:selected" ).text()+" ปี "+$("#fiscalyear").val()}); 

          } 
          else{
            chart.options.chart.type = "pie";
            chart.options.chart.marginTop = 60;
              chart.options.chart.options3d.enabled = true; 
            
              chart.yAxis[0].options.title.text = "";
            
            // add new data
            var seriesOpts_01 = {
                
                name: "",
                data: series1,
                showInLegend : true
                          
            }
            
            chart.addSeries(seriesOpts_01);
            
            if($("#department").val()!="")
            {  
              
              chart.setTitle({text: $( "#chart option:selected" ).text()+ " ของ "+$( "#department option:selected" ).text()+" ปี "+$("#fiscalyear").val()});  
            
            }else  
              chart.setTitle({text: $( "#chart option:selected" ).text()+" ปี "+$("#fiscalyear").val()}); 

          } 
            var seriesOpts_02 = {
                
                name: "",
                series: seriesDrill,
                showInLegend : true
                            
            }

            //chart.options.drilldown = seriesOpts_02;
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('printReport', '
$("#printReport").click(function(e){
    e.preventDefault();
     $.ajax({
        url: "printProgress",
        data: {project: $("#project").val(),fiscalyear: $("#fiscalyear").val(),workcat: $("#workcat").val()},
        success:function(response){
             window.open("../tempReport.pdf", "_blank", "fullscreen=yes");              
            
        }

    });

});
', CClientScript::POS_END);

Yii::app()->clientScript->registerScript('exportWord', '

var charts = [];

$("#exportWord").click(function(e){
    e.preventDefault();


    //chart 1: income
    nchart = 0;
    $.ajax({
        url: "genService",
        data: {fiscalyear: $("#fiscalyear").val(),report:"all",workcat:"",department:""},
        dataType: "json",
        success:function(response){
           
           $.each(response, function(key, response2) {

                    var series1 = [];
                    var series2 = [];
                    var series3 = [];

                    var seriesDrill = [];
                    var drill = [];

                    if(response2["name"]=="รายได้เปรียบเทียบกับค่าใช้จ่าย")
                    {
                              $.each(response2["data"], function(key, val2) {
                                  
                                 // console.log(val2)
                                  if(val2["name"]=="กบศ.")
                                  {
                                    
                                    $.each(val2["value"], function(key, val) {
                                      val["value"] = val["value"]!=null ? val["value"] : 0;  
                                      series1.push({name:val["name"],y:parseInt(val["value"])});
                                    });  
                                      
                                  }
                                  else if(val2["name"]=="กบจ.")
                                  {

                                    $.each(val2["value"], function(key, val) {
                                      //console.log(val)
									  val["value"] = val["value"]!=null ? val["value"] : 0;
                                      series2.push({name:val["name"],y:parseInt(val["value"])});
                                    });
                                  }
                                  else
                                  {
                                    $.each(val2["value"], function(key, val) {
									  val["value"] = val["value"]!=null ? val["value"] : 0;	
                                      series3.push({name:val["name"],y:parseInt(val["value"])});
                                    });
                                  }

                                  
                              
                           });
                    }
                    else
                    {  
                                  
                                     var idx = 0;
                                     $.each(response2["data"], function(key, val) {
                                          val["value"] = val["value"]==null ? 0 : val["value"];
                                          if(val["value"]!=0)
                                          if(val["drill"].length > 0)
                                          {  
                                            
                                            if(idx==0)
                                              series1.push({name:val["name"],y:parseInt(val["value"]),selected: true,sliced: true,drilldown:"drill"+idx});
                                            else
                                              series1.push({name:val["name"],y:parseInt(val["value"]),sliced: true,drilldown:"drill"+idx});
                                            
                                            seriesDrill.push({id:"drill"+idx,data:val["drill"],sliced: true,showInLegend : true});
                                                                             
                                            drill = val["drill"];
                                            idx++;

                                          }else  
                                            series1.push({name:val["name"],y:parseInt(val["value"]),sliced: true});
                                        
                                     });
                    } 
                    var chart = $("#divChart2").highcharts();

                      // remove old data
                      $(chart.series).each(function() {
                          this.remove();
                      });

                     
                if(response2["name"]=="รายได้เปรียบเทียบกับค่าใช้จ่าย")
                {
                    chart.options.chart.type = "column";
                    chart.options.chart.options3d.enabled = false;
                   //console.log(chart)
                  
                   chart.legend.options.layout = "horizontal";
                   
                  //  console.log(chart)
                  // add new data
                  var seriesOpts_01 = {
                      
                      name: "กบศ.",
                      data: series1,
                      showInLegend : true,
                      dataLabels: {
                          enabled: true,
                          rotation:-90,
                          align: "top",
                          format: "{point.y:,.2f}", // one decimal
                          
                          style: {
                              fontSize: "13px",
                              fontFamily: "Verdana, sans-serif"
                          }
                      }
                                
                  }
                  
                  chart.addSeries(seriesOpts_01);

                  var seriesOpts_03 = {
                      
                      name: "กบจ.",
                      data: series2,
                      showInLegend : true,
                      dataLabels: {
                          enabled: true,
                          rotation:-90,
                          align: "top",
                          format: "{point.y:,.2f}", // one decimal
                          
                          style: {
                              fontSize: "13px",
                              fontFamily: "Verdana, sans-serif"
                          }
                      }
                                
                  }
                  chart.addSeries(seriesOpts_03);

                  var seriesOpts_04 = {
                      
                      name: "กรษ.",
                      data: series3,
                      showInLegend : true,
                      dataLabels: {
                          enabled: true,
                          rotation:-90,
                          align: "top",
                          format: "{point.y:,.2f}", // one decimal
                          
                          style: {
                              fontSize: "13px",
                              fontFamily: "Verdana, sans-serif"
                          }
                      }
                                
                  }
                  chart.addSeries(seriesOpts_04);
                  //chart.yAxis[0].options.title = "จำนวนเงิน";
                  //console.log(chart)
                  chart.xAxis[0].setCategories(["รายได้","ค่าใช้จ่ายจ้างเหมา","ค่าใช้จ่ายดำเนินงาน","ค่าใช้จ่ายบริหารงาน"]);



                }
                else
                {  
                      // add new data
                      var seriesOpts_01 = {
                          
                          name: "",
                          data: series1,
                          showInLegend : true
                                    
                      }
                      chart.addSeries(seriesOpts_01);
                }      
                      var seriesOpts_02 = {
                          
                          name: "",
                          series: seriesDrill,
                          showInLegend : true
                                    
                      }

                      chart.options.drilldown = seriesOpts_02;
                      chart.setTitle({text: response2["name"]+" ปี "+$("#fiscalyear").val()}); 

                      /*ADD CHART DATA TO ARRAY, getSVG for exporting*/

                     charts.push({title:"test",text:"text",svg:chart.getSVG()})
                     nchart++;
                     //console.log(charts); 
            });   

             var json={
              "type":"doc", 
              "title":$("#fiscalyear").val(),
              "header":"header",
              "footer":"footer",
              "data": $.toJSON(charts)
            };


            /*TRICK CLIENT INTO DOWNLOAD FILE WITH jQuery*/
                 download("docgen",json,"POST");
            
        }

    });



          

});
', CClientScript::POS_END);
?>