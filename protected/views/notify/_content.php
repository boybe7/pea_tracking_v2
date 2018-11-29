<style type="text/css">
	hr {

		margin: 0px 0px; 
	}

	.header {
		font-weight: bold;
		font-size: 20px;
	}

    .modal-header {
        background-color: #f89406;
    }
</style>

<?php


$current_date = (date("Y")+543).date("-m-d");

$user_dept = Yii::app()->user->userdept;
         
$process = Yii::app()->createController('Notify'); //create instance of controller
$records = $process[0]->gnotify(); //call function 

// $old_proj = "";
// foreach ($records as $key => $value) {
     
//      $workcat  = WorkCategory::model()->findbyPk(Project::model()->findbyPk($value['pj_id'])->pj_work_cat)->wc_name; 
//      if($old_proj!=$value['pj_id']) 
//         echo "<div class='header'> ".$workcat.":".$value['project'] ."</div><hr>";

//      if($value["contract"]!="")
//         echo "สัญญา ".$value["contract"]." : <font color='red'>".$value["alarm_detail"]."</font><br>";
//      else
//         echo "<font color='red'>".$value["alarm_detail"]."</font><br>";

//     if($old_proj=="")
//           $old_proj = $value['pj_id'];

//     echo "<br>";  

// }   

$tpye_name = array('1' => 'เตือนครบกำหนดค้ำประกันสัญญา','2' => 'เตือนครบกำหนดชำระเงินของ vendor','3' => 'เตือนครบกำหนดจ่ายเงินให้ supplier','4' => 'เตือนบันทึกค่าบริหารงานโครงการ','5' => 'เตือนของบ .1000','6' => 'เตือนปิดโครงการ' );
foreach ($records as $key => $value) {
    if(($value['type']==5  && Yii::app()->user->username=='tsd02') )
    {

      echo "<div class='header'><font color=green>!!! ".$tpye_name[$value['type']]."</font> จำนวน <font color=red>".$value['amount'] ."</font> รายการ</div><br>";
    }
    else{
        echo "<div class='header'> ".$tpye_name[$value['type']]." จำนวน <font color=red>".$value['amount'] ."</font> รายการ</div><br>";
    }
}


  ?>
