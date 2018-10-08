<style type="text/css">
	
	.the-legend {
    
    font: 16px/1.6em 'Boon700',sans-serif;
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
 
hr {
  border-bottom: 1px solid #E3E3E3;
  margin: -5px 0 18px 0;
}
.head_contract {
    
    font: 14px/1.4em 'Boon700',sans-serif;
    font-weight: bold;
    
}

.ui-autocomplete { max-height: 180px; overflow-y: auto; overflow-x: hidden;}


ol.progtrckr {
    margin: 0;
    padding: 0;
    list-style-type none;
}
ol.progtrckr li {
    display: inline-block;
    text-align: center;
    line-height: 3em;
}
ol.progtrckr li.progtrckr-done {
    color: black;
    border-bottom: 4px solid yellowgreen;
}
ol.progtrckr li.progtrckr-todo {
    color: silver; 
    border-bottom: 4px solid silver;
}
ol.progtrckr li:after {
    content: "\00a0\00a0";
}
ol.progtrckr li:before {
    position: relative;
    bottom: -2.5em;
    float: left;
    left: 50%;
    line-height: 1em;
}
ol.progtrckr li.progtrckr-done:before {
    content: "\2713";
    color: white;
    background-color: yellowgreen;
    height: 1.2em;
    width: 1.2em;
    line-height: 1.2em;
    border: none;
    border-radius: 1.2em;
}
ol.progtrckr li.progtrckr-todo:before {
    content: "\039F";
    color: silver;
    background-color: #f5f5f5;
    font-size: 1.5em;
    bottom: -1.6em;
}
ol.progtrckr[data-progtrckr-steps="2"] li { width: 49%; }
ol.progtrckr[data-progtrckr-steps="3"] li { width: 33%; }
ol.progtrckr[data-progtrckr-steps="4"] li { width: 24%; }
ol.progtrckr[data-progtrckr-steps="5"] li { width: 19%; }
ol.progtrckr[data-progtrckr-steps="6"] li { width: 16%; }
ol.progtrckr[data-progtrckr-steps="7"] li { width: 14%; }
ol.progtrckr[data-progtrckr-steps="8"] li { width: 12%; }
ol.progtrckr[data-progtrckr-steps="9"] li { width: 11%; }
</style>
	<!-- <p class="help-block">Fields with <span class="required">*</span> are required.</p> -->
<script type="text/javascript">
  
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
</script>

<div class="well">
  <?php
        echo "<h4>".$model->pj_name."</h4><hr>";

        $Criteria = new CDbCriteria();
        $Criteria->condition = "pc_proj_id='$model->pj_id'";
        $projectCons = ProjectContract::model()->findAll($Criteria);//$command->queryAll();

        $id = 0;
        echo "<div class='row-fluid'>";
          echo "<div class='span6'>";
          echo'<fieldset class="well the-fieldset">';
          echo'  <legend class="the-legend contract_no">สัญญาหลัก</legend>';
        foreach ($projectCons as $key => $projectCon):
           echo "<div><span class='head_contract'>".$projectCon->pc_code."</span> : ".$projectCon->pc_details."</div>";
          //echo '<div id="tracker'.$id.' style="width: 700px"></div>';
           //$id++;
          //get num payment
          $Criteria = new CDbCriteria();
          $Criteria->condition = "proj_id='$projectCon->pc_id'";
          $payments = PaymentProjectContract::model()->findAll($Criteria);

          $num_pay_real = count($payments);
          //echo $num_pay_real;

          $num_payment = $num_pay_real > $projectCon->pc_num_payment ? $num_pay_real : $projectCon->pc_num_payment ;


          echo '<ol class="progtrckr" data-progtrckr-steps="'.$num_payment.'">';

          for ($i=1; $i < $num_payment+1; $i++) { 
              if($i<=$num_pay_real && $num_pay_real!=0)
               echo '<li class="progtrckr-done">งวดที่ '.($i).'</li>';
              else 
                echo '<li class="progtrckr-todo">งวดที่ '.($i).'</li>';
          }
          echo '</ol>';
        
          echo "<br><br>";

          

          echo "<div class='row-fluid'>";
          echo "<div class='span3'>";
          
            echo '<u>สถานะการเบิกจ่าย :</u>  ';
          echo "</div>";
          echo "<div class='span9'>";
          
            $sql = "SELECT GREATEST(MAX(invoice_date), MAX(bill_date)) as last_date FROM Payment_Project_Contract WHERE proj_id='$projectCon->pc_id'";
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $last_date = $result[0]["last_date"];

            //print_r($last_date);
            $Criteria = new CDbCriteria();
            $Criteria->condition = "proj_id='$projectCon->pc_id' AND bill_date='$last_date'";
            $result = PaymentProjectContract::model()->findAll($Criteria);
            if(count($result))
            {
                echo $result[0]->detail." ได้เงินจำนวน ".$result[0]->money."บาท ใบเสร็จรับเงินเลขที่ ".$result[0]->bill_no."  วันที่ ".$result[0]->bill_date;
            }
            else{
              $Criteria = new CDbCriteria();
              $Criteria->condition = "proj_id='$projectCon->pc_id' AND invoice_date='$last_date'";
              $result = PaymentProjectContract::model()->findAll($Criteria);
            
              if(count($result))    
                  echo $result[0]->detail." ได้รับใบแจ้งหนี้เลขที่ ".$result[0]->invoice_no."  วันที่ ".$result[0]->invoice_date;

            }
          echo "</div>";  

            echo '<div><u>สถานะงาน :</u>  '.$projectCon->pc_T_percent." %</div>";

          
          
          $sql = "SELECT SUM(money) as sum FROM Payment_Project_Contract WHERE proj_id='$projectCon->pc_id'";
          $command = Yii::app()->db->createCommand($sql);
          $result = $command->queryAll();

          $pay_total = 0;
          //echo count($result);
          if(count($result)>0)
           $pay_total = ($result[0]["sum"]);

          $cost_total = ($projectCon->pc_cost);

          

          $sql = "SELECT SUM(cost) as sum FROM contract_change_history WHERE contract_id='$projectCon->pc_id' AND type=1";
          $command = Yii::app()->db->createCommand($sql);
          $result = $command->queryAll();

          $change_cost = 0;
          if(count($result))
             $change_cost = $result[0]["sum"];

          $cost_total +=  $change_cost;

          $remain = $cost_total  - $pay_total;

          if($pay_total=='')
              $pay_total = 0;

          //echo "total:".$cost_total; 
          //echo "pay:".$pay_total;
          //echo "remain:".$remain; 


          //chart



          echo '<div id="container_pc'.$root.'_'.$index.'_'.$id.'" style="width: auto; height: 150px; margin: 0 auto"></div>';  
          
          //sleep(5);
          Yii::app()->clientScript->registerScript('piechart'.$root."_".$index."_".$id, "
            
                  var total = 0;

                
                $('#container_pc".$root."_".$index."_".$id."').highcharts({
                    chart:{type:'pie',
                                style: {
                                    fontFamily: 'Boon400'
                                },
                                events: {
                                  load: function(event) {
                                     
                                  }
                                }
                                
                                },
                    credits:{enabled: false},
                          colors:[
                              '#5485BC', '#EDD447', '#5C9384', '#981A37', '#FCB319',     '#86A033', '#614931', '#00526F', '#594266', '#cb6828', '#aaaaab', '#a89375'
                              ],
                          title:{text: null},
                    tooltip:{
                      enabled: true,
                      animation: true
                    },
                    plotOptions: {
                              pie: {
                                  allowPointSelect: true,
                                  animation: true,
                                  cursor: 'pointer',
                                  showInLegend: true,
                                  dataLabels: {
                                      enabled: false,                        
                                      formatter: function() {
                                          return this.percentage.toFixed(2) + '';
                                      }
                                  }                   
                              }
                          },
                          legend: {
                              enabled: true,
                              layout: 'vertical',
                              align: 'left',
                              width: 220,
                              verticalAlign: 'middle',
                              borderWidth: 0,
                              useHTML: true,
                              labelFormatter: function() {
                                  total += this.y;
                                  return '<div><span>' + this.name + '</span><span>  ' + format(this.y) + '  บาท</span></div>';
                              },
                          title: {
                            text: 'วงเงินตามสัญญา ".number_format($cost_total)." บาท',
                            style: {
                              fontWeight: 'bold'
                            }
                          }
                          },
                    series: [{
                      type: 'pie',
                      dataLabels:{
                      
                      },
                      data: [
                        ['เบิกจ่าย', ".$pay_total."],
                        ['คงเหลือ', ".$remain."],
                      
                      ]
                    }]
                  });
          
          
            ", CClientScript::POS_END);



          echo "<br><br><hr>";
        $id++;
          
        endforeach;  
          echo "</fieldset>";
          echo "</div>";
          
        
        //outsource contract
        $Criteria = new CDbCriteria();
        $Criteria->condition = "oc_proj_id='$model->pj_id'";
        $OutsourceCons = OutsourceContract::model()->findAll($Criteria);//$command->queryAll();

        $id = 0;


         echo "<div class='span6'>";
          echo'<fieldset class="well the-fieldset">';
          echo'  <legend class="the-legend contract_no">สัญญาจ้างช่วง/ซื้อ</legend>';
        foreach ($OutsourceCons as $key => $outsourceCon):
           echo "<div><span class='head_contract'>".$outsourceCon->oc_code."</span> : ".$outsourceCon->oc_detail."</div>";
          //echo '<div id="tracker'.$id.' style="width: 700px"></div>';
           //$id++;
          //get num payment
          $Criteria = new CDbCriteria();
          $Criteria->condition = "contract_id='$outsourceCon->oc_id'";
          $payments = PaymentOutsourceContract::model()->findAll($Criteria);

          $num_pay_real = count($payments);
          //echo "cc:".$num_pay_real;

          $num_payment = $num_pay_real > $outsourceCon->oc_num_payment ? $num_pay_real : $outsourceCon->oc_num_payment ;


          echo '<ol class="progtrckr" data-progtrckr-steps="'.$num_payment.'">';

          for ($i=1; $i < $num_payment+1; $i++) { 
              if($i<=$num_pay_real && $num_pay_real!=0)
               echo '<li class="progtrckr-done">งวดที่ '.($i).'</li>';
              else 
                echo '<li class="progtrckr-todo">งวดที่ '.($i).'</li>';
          }
          echo '</ol>';
        
          echo "<br><br>";

          

          echo "<div class='row-fluid'>";
          echo "<div class='span3'>";
          
            echo '<u>สถานะการเบิกจ่าย :</u>  ';
          echo "</div>";
          echo "<div class='span9'>";
          
            $sql = "SELECT GREATEST(MAX(invoice_receive_date), MAX(approve_date)) as last_date FROM Payment_Outsource_Contract WHERE contract_id='$outsourceCon->oc_id'";
            $command = Yii::app()->db->createCommand($sql);
            $result = $command->queryAll();
            $last_date = $result[0]["last_date"];

            //print_r($last_date);
            $Criteria = new CDbCriteria();
            $Criteria->condition = "contract_id='$outsourceCon->oc_id' AND approve_date='$last_date'";
            $result = PaymentOutsourceContract::model()->findAll($Criteria);
            if(count($result))
            {
                echo $result[0]->detail." อนุมัติจ่ายเงินจำนวน ".$result[0]->money."บาท วันที่ ".$result[0]->approve_date;
            }
            else{
              $Criteria = new CDbCriteria();
              $Criteria->condition = "contract_id='$outsourceCon->oc_id' AND invoice_receive_date='$last_date'";
              $result = PaymentOutsourceContract::model()->findAll($Criteria);
            
              if(count($result))    
                  echo $result[0]->detail." ได้รับใบแจ้งหนี้เลขที่ ".$result[0]->invoice_no."  วันที่ ".$result[0]->invoice_receive_date;

            }
          echo "</div>";  

            echo '<div><u>สถานะงาน :</u>  '.$outsourceCon->oc_T_percent." %</div>";

          
          
          $sql = "SELECT SUM(money) as sum FROM Payment_Outsource_Contract WHERE contract_id='$outsourceCon->oc_id'";
          $command = Yii::app()->db->createCommand($sql);
          $result = $command->queryAll();

          $pay_total = 0;
          //echo count($result);
          if(count($result)>0)
           $pay_total = ($result[0]["sum"]);

          $cost_total = str_replace(",", "", $outsourceCon->oc_cost);

          $sql = "SELECT SUM(cost) as sum FROM contract_change_history WHERE contract_id='$outsourceCon->oc_id' AND type=2";
          $command = Yii::app()->db->createCommand($sql);
          $result = $command->queryAll();

          $change_cost = 0;
          if(count($result))
             $change_cost = $result[0]["sum"];
           $cost_total +=  $change_cost;
          $remain = $cost_total  - $pay_total;
          //echo $outsourceCon->oc_cost;
          $cost_total = number_format($cost_total);

          if($pay_total=='')
              $pay_total = 0;

          //echo "total:".$cost_total; 
          //echo "pay:".$pay_total;
          //echo "remain:".$remain; 


          //chart



          echo '<div id="container_oc'.$root.'_'.$index.'_'.$id.'" style="width: auto; height: 150px; margin: 0 auto"></div>';  
          
          //sleep(5);
          Yii::app()->clientScript->registerScript('piechart_oc'.$root."_".$index."_".$id, "
            
                  var total = 0;

                
                $('#container_oc".$root."_".$index."_".$id."').highcharts({
                    chart:{type:'pie',
                                style: {
                                    fontFamily: 'Boon400',
                                    fontWeight: 'bold'
                                },
                                events: {
                                  load: function(event) {
                                     
                                  }
                                }
                                
                                },
                    credits:{enabled: false},
                          colors:[
                              '#5485BC', '#EDD447', '#5C9384', '#981A37', '#FCB319',     '#86A033', '#614931', '#00526F', '#594266', '#cb6828', '#aaaaab', '#a89375'
                              ],
                          title:{text: null},
                    tooltip:{
                      enabled: true,
                      animation: true
                    },
                    plotOptions: {
                              pie: {
                                  allowPointSelect: true,
                                  animation: true,
                                  cursor: 'pointer',
                                  showInLegend: true,
                                  dataLabels: {
                                      enabled: false,                        
                                      formatter: function() {
                                          return this.percentage.toFixed(2) + '';
                                      }
                                  }                   
                              }
                          },
                          legend: {
                              enabled: true,
                              layout: 'vertical',
                              align: 'left',
                              width: 220,
                              verticalAlign: 'middle',
                              borderWidth: 0,
                              useHTML: true,
                              labelFormatter: function() {
                                  total += this.y;
                                  return '<div><span>' + this.name + '</span><span>  ' + format(this.y) + '  บาท</span></div>';
                              },
                          title: {
                            text: 'วงเงินตามสัญญา ".$cost_total." บาท',
                            style: {
                              fontWeight: 'bold'
                            }
                          }
                          },
                    series: [{
                      type: 'pie',
                      dataLabels:{
                      
                      },
                      data: [
                        ['เบิกจ่าย', ".$pay_total."],
                        ['คงเหลือ', ".$remain."],
                      
                      ]
                    }]
                  });
          
          
            ", CClientScript::POS_END);



          echo "<br><br><hr>";
        $id++;
          
        endforeach;  
          echo "</fieldset>";
          echo "</div>";



        echo "</div>";


  ?>
</div>