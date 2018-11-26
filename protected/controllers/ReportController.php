<?php

//define('BATIK_PATH', Yii::getPathOfAlias('BATIK_PATH'));//'/../extensions/highcharts/exporting-server/batik-rasterizer.jar');
//define('TEMP_PATH', Yii::getPathOfAlias('TEMP_PATH'));//'/../extensions/highcharts/exporting-server/temp/');

define('BATIK_PATH', 'c:/xampp/htdocs/pea_track/protected/extensions/highcharts/exporting-server/batik-rasterizer.jar');
define('TEMP_PATH', 'c:/xampp/htdocs/pea_track/protected/extensions/highcharts/exporting-server/');

define('EXPORT_PATH', 'c:/xampp/htdocs/pea_track/protected/extensions/highcharts/exporting-server/');


class ReportController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
       

	/**
	 * Displays the progress page
	 */
	public function actionSummaryCashflow()
	{
		$this->render('summaryCashflow');
	}

	public function actionProgress()
	{
            		
		// display the progress form
		$this->render('progress');
	}

	public function actionService()
	{
            		
		// display the progress form
		$this->render('service');
	}

	public function actionStatement()
	{
            		
		// display the progress form
		$this->render('statement');
	}


	public function actionCashflow()
	{
            		
		// display the progress form
		$this->render('cashflow');
	}

	public function actionSummary()
	{
    	
		// display the progress form
		$this->render('summary');
	}

	public function actionBSC()
	{
    	
		// display the progress form
		$this->render('bsc');
	}

	 public function actionGenProgress()
    {
        $user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    	}
        $this->renderPartial('_formProgress2', array(
            'model' => $model,
            'display' => 'block',
        ), false, true);

        
    }

     public function actionGenCashflow()
    {
        
    	// $condition = "";
    	// if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"])) 
    	// 	$condition = " pj_fiscalyear=".$_GET["fiscalyear"];
    	// if(isset($_GET["workcat"]) && !empty($_GET["workcat"]))
    	// 	$condition .= " AND pj_work_cat=".$_GET["workcat"];
    	// if(isset($_GET["project"]) && !empty($_GET["project"])) 
    	// 	$condition .= " AND pj_id=".$_GET["project"];


    	// if(isset($_GET["project"]) && !empty($_GET["project"]))    		
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
    	// 	$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	

    	$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    }
    	$monthBegin = 0;//$_GET["monthBegin"];
    	$monthEnd = $_GET["monthEnd"];
    	$yearBegin = 0;//$_GET["yearBegin"];
    	$yearEnd = $_GET["yearEnd"];

    	// header('Content-type: text/plain');
     //       echo($_GET["fiscalyear"]);                    
     //    exit;

        $this->renderPartial('_formCashflow', array(
            'model' => $model,'monthBegin'=>$monthBegin,'monthEnd'=>$monthEnd,'yearBegin'=>$yearBegin,'yearEnd'=>$yearEnd,
            'display' => 'block',
        ), false, true);

        
    }

    public function actionGenServiceWord()
    {
    	   //$model = Project::model()->findByPk($_GET["project"]);
    		$year = $_GET["fiscalyear"];
    		$workcat = $_GET["workcat"];
  
		    Yii::import('ext.phpword.XPHPWord');  

		   $objPHPWord= XPHPWord::createPHPWord();

		   //style
		    $objPHPWord->addFontStyle('rStyle', array('bold'=>true, 'italic'=>true, 'size'=>16));
			$objPHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>100));

		   // New portrait section
			$section = $objPHPWord->createSection();

			// Add text elements
			$section->addText('สรุปรายได้ ค่าใช้จ่ายงานบริการวิศวกรรมแก่ลูกค้าภายนอก', array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>20),array('align'=>'center'));

		   ob_end_clean();
			ob_start();

			header('Content-Type: application/vnd.ms-word');
			header('Content-Disposition: attachment;filename="service_report.docx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = PHPWord_IOFactory::createWriter($objPHPWord, 'Word2007');
			$objWriter->save('php://output');  //
			 Yii::app()->end(); 

			
	}	   

function svgToJpg($item){
  /*CONVERTS SVG TO JPG*/
  
  ///////////////////////////////////////////////////////////////////////////////
  ini_set('magic_quotes_gpc', 'off');
  
  
  $filename =  isset($_POST['filename']) ? $_POST['filename'] : 'chart';
  $width =  isset($_POST['width']) ? $_POST['width'] : 600;
  
  $svg=$item->svg;
  if (get_magic_quotes_gpc()) {
    $svg = stripslashes($svg);  
  }
  
  
  
  $tempName = md5(rand());
  $typeString = '-m image/jpeg';
  $ext = '.jpg';
  $outfile = TEMP_PATH.$tempName.$ext;

      
  if (isset($typeString)) {
    
    // size
   $width = "-w $width";
   
  
    // generate the temporary file
    if (!file_put_contents(TEMP_PATH.$tempName.".svg", $svg)) { 
      die("Couldn't create temporary file. Check that the directory permissions for
        the /temp directory are set to 777.");
    }
    
    // do the conversion
    shell_exec("chmod 777 ".TEMP_PATH.$tempName.".svg");
    $output = shell_exec("java -jar ". BATIK_PATH ." $typeString -d $outfile $width -q 0.95 ".TEMP_PATH.$tempName.".svg");
        //$output = shell_exec("set path=C:\Program Files\Java\jdk1.7.0_79\bin"); 
        //$output =    shell_exec("javac -version 2>&1");                    
        //header('Content-type: text/plain');
		//echo "java:".$output;
		//exit;
    // catch error
    if (!is_file($outfile) || filesize($outfile) < 10) {
      echo "<pre>$output</pre>";
      echo "Error while converting SVG. ";
      
      if (strpos($output, 'SVGConverter.error.while.rasterizing.file') !== false) {
        echo "SVG code for debugging: <hr/>";
        echo htmlentities($svg);
      }
    } 
    
    // stream it
    else {
      unlink(TEMP_PATH.$tempName.".svg");
      $item->filename=$outfile;
      return $item;
    }
    
    // delete it
    
    //unlink($outfile);
  
  // SVG can be streamed directly back
  } else {
    echo "Invalid type";
  }
}




function doDoc($year,$headertext,$footertext,$items){
  // New Word Document
	 Yii::import('ext.phpword.XPHPWord');  

  $PHPWord= XPHPWord::createPHPWord();
  //$PHPWord = new PHPWord();
  // New portrait section
  $section = $PHPWord->createSection();

  $section->addText('สรุปรายได้ ค่าใช้จ่ายงานบริการวิศวกรรมแก่ลูกค้าภายนอก', array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>20),array('align'=>'center','spaceAfter'=>0));
  $section->addText('แนวทางการปรับค่า EP ของฝ่ายบริการวิศวกรรม', array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>20),array('align'=>'center','spaceAfter'=>50));

  
  // Add header
  // $header = $section->createHeader();
  // $table = $header->addTable();
  // $table->addRow();
  // $table->addCell(4500)->addText($headertext);
  
  // Add footer
  // $footer = $section->createFooter();
  // //$footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'center'));
  // $footer->addPreserveText($footertext, array('align'=>'center'));
  
  // Title styles
  //style
		    $PHPWord->addFontStyle('rStyle', array('name'=>'TH SarabunPSK', 'color'=>'black', 'size'=>17));
			$PHPWord->addFontStyle('hStyle', array('name'=>'TH SarabunPSK','bold'=>true, 'color'=>'black', 'size'=>17));
			
			$PHPWord->addParagraphStyle('pStyle', array('align'=>'center', 'spaceAfter'=>0));

$section->addText("",array('name'=>'TH SarabunPSK', 'color'=>'black', 'size'=>17),array('align'=>'left', 'spaceBefore'=>100));
   

  $section->addText("                   ตามที่ กบว. ได้ให้บริการงานวิศวกรมแก่ลูกค้าภายนอกในปี ".$year." นั้น นบท. 9 ขอ
สรุปรายได้และค่าใช้จ่ายในการดำเนินการตามสัญญาของงานตาสัญญาในปี ".$year." โดยมีรายละเอียดดังนี้
",array('name'=>'TH SarabunPSK', 'color'=>'black', 'size'=>17),array('align'=>'left', 'spaceBefore'=>100));
  

$table = $section->addTable(array("cellMargin"=>0));


 $dateBegin = $year."-01-01";
 $dateEnd = $year."-12-31";
//chart 1: income 
	             $workcat = WorkCategory::model()->findAll();
	             $data = array();
	             $sumAll = 0;
	             foreach ($workcat as $key => $wc) {
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sum = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sum += $pj->getIncome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             	}
	             	$sumAll += $sum;
	             	$data[] = array("name"=>$wc->wc_name, "value"=>$sum,"drill"=> 0);
	             	$table->addRow();
					$table->addCell(5350)->addText("รายได้".$wc->wc_name,'rStyle',array('spaceAfter'=>0));
					$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1450)->addText(number_format($sum,2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
					$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	             }

	    $section->addText("รายได้งานบริการงานวิศวกรรมตามสัญญาในปี ".$year." ดังนี้",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>300,'spaceAfter'=>0));
	    $table = $section->addTable(array("cellMargin"=>0));
	    $no = 1;
	    foreach ($data as $key => $value) {
			        $table->addRow();
					$table->addCell(250)->addText($no.".",'rStyle',array('align'=>'right','spaceAfter'=>0));
					$table->addCell(6650)->addText("  รายได้".$value["name"],'rStyle',array('spaceAfter'=>0));
					$table->addCell(1750)->addText("คิดเป็นร้อยละ",'rStyle',array('spaceAfter'=>0));
					$table->addCell(250)->addText(number_format(($value["value"]*100)/$sumAll),'rStyle',array("align"=>"right",'spaceAfter'=>0));
					$table->addCell(2450)->addText("  ของรายได้ทั้งหมด",'rStyle',array('spaceAfter'=>0));
	            $no++; 	    	
	    }

	    $section->addImage($items[0]->filename);
        $section->addText("รูปที่ 1",array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('align'=>'center', 'spaceBefore'=>300));
	     
	        
	        //chart 2: outcome by workcat
	        $section->addText("ค่าใช้จ่ายงานบริการวิศวกรรมตามสัญญาในปี ".$year." ดังนี้",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>300,'spaceAfter'=>0));
		    
		   
	        $data = array();
	        $data2 = array();
	        $no = 1;
	        $sumWAll = 0;
	        $sumWAll2 = 0;
	         foreach ($workcat as $key => $wc) {
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sumW = 0;
	             	$sumW2 = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             
	             	}
	             	$sumWAll += $sumW;
	             	$sumWAll2 += $sumW2;
	             	$data[] = array("name"=>"ค่าจ้างเหมา".$wc->wc_name, "value"=>$sumW,"drill"=> 0);
	             	$data2[] = array("name"=>"ค่าดำเนินงาน".$wc->wc_name, "value"=>$sumW2,"drill"=> 0);

	              
	    			$section->addText("  ".($no++).". ".$wc->wc_name,array('name'=>'TH SarabunPSK', 'bold'=>true,'color'=>'black','size'=>17),array('spaceBefore'=>0,'spaceAfter'=>0));
	              

	             	$table = $section->addTable(array("cellMargin"=>0));
	             	$table->addRow();
					$table->addCell(6850)->addText("ค่าใช้จ่ายจ้างเหมา",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1950)->addText(number_format($sumW,2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
					$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	            

					$table->addRow();
					$table->addCell(6850)->addText("ค่าใช้จ่ายดำเนินงาน",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1950)->addText(number_format($sumW2,2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
					$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	            					
					

	             }     


		    $section->addImage($items[1]->filename);
	        $section->addText("รูปที่ 2",array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('align'=>'center', 'spaceBefore'=>300));
		   
		    $section->addText("ค่าใช้จ่ายงานบริการวิศวกรรมตามสัญญาในปี ".$year." ดังนี้",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>300,'spaceAfter'=>0));
		    $section->addText("  1. ค่าจ้างเหมาช่วงของงานบริการวิศวกรรมคิดเป็นร้อยละ   ".number_format(($sumWAll*100)/($sumWAll+$sumWAll2),1)."  ของค่าใช้จ่ายรวมที่เกิดขึ้น ของแต่ละประเภทของงาน โดยสรุปได้ ดังนี้",array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('spaceBefore'=>0,'spaceAfter'=>0));
	        $no = 1;
	        foreach ($data as $key => $value) {
				   if($sumWAll!=0)     
	                 $section->addText("      1.".($no++)." ค่าจ้างเหมาช่วง".$value["name"]."     คิดเป็นร้อยละ   ".number_format(($value["value"]*100)/($sumWAll),0)."  ของค่าใช้จ่ายทั้งหมด ",array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('spaceBefore'=>0,'spaceAfter'=>0));
				   else
					$section->addText("      1.".($no++)." ค่าจ้างเหมาช่วง".$value["name"]."     คิดเป็นร้อยละ  -  ของค่าใช้จ่ายทั้งหมด ",array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('spaceBefore'=>0,'spaceAfter'=>0));
	        	
	        }        
			$value = $sumWAll+$sumWAll2!=0 ? number_format(($sumWAll2*100)/($sumWAll+$sumWAll2),1) : '-';
			$section->addText("  2. ค่าใช้จ่ายในการดำเนินงานของงานบริการวิศวกรรมคิดเป็นร้อยละ   ".$value."  ของค่าใช้จ่ายรวมที่เกิดขึ้น ของแต่ละประเภทของงาน โดยสรุปได้ ดังนี้",array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('spaceBefore'=>300,'spaceAfter'=>0));
	        $no = 1;
	        foreach ($data2 as $key => $value) {
				    $value2 =  $sumWAll2!=0 ? number_format(($value["value"]*100)/($sumWAll2),1) : '-';
	                $section->addText("      1.".($no++)." ค่าใช้จ่ายในการดำเนินงานของ".$value["name"]."     คิดเป็นร้อยละ   ".$value2."  ของค่าใช้จ่ายทั้งหมด ",array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('spaceBefore'=>0,'spaceAfter'=>0));
	        
	        }
			//chart 3: outcome by workcat
			$section->addText("แยกค่าใช้จ่ายของงานแต่ละประเภทของปี ".$year." มีรายละเอียดดังนี้",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>300,'spaceAfter'=>0));
		    $no_pic = 3;	 
		    $no = 1;
			foreach ($workcat as $key => $wc) {
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sumW = 0;
	             	$sumW2 = 0;
	             	$data = array();
	             	foreach ($projects as $key => $pj) {
	             		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             
	             	}
	             	$data[] = array("name"=>"ค่าจ้างเหมา", "value"=>$sumW,"drill"=> 0);
	             	$data[] = array("name"=>"ค่าดำเนินงาน", "value"=>$sumW2,"drill"=> 0);


	             	$section->addText("  ".($no++).". ".$wc->wc_name,array('name'=>'TH SarabunPSK', 'bold'=>true,'color'=>'black','size'=>17),array('spaceBefore'=>0,'spaceAfter'=>0));
	              

	             	$table = $section->addTable(array("cellMargin"=>0));
	             	$table->addRow();
					$table->addCell(6850)->addText("ค่าใช้จ่ายจ้างเหมา",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1950)->addText(number_format($sumW,2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
					$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	            
					$table->addRow();
					$table->addCell(6850)->addText("ค่าใช้จ่ายดำเนินงาน",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
					$table->addCell(1950)->addText(number_format($sumW2,2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
					$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	            	

	             	$section->addImage($items[$no_pic-1]->filename);
	                $section->addText("รูปที่ ".($no_pic++),array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('align'=>'center', 'spaceBefore'=>300));
		   
	             }     
	         

          $section->addText("การเพิ่มค่า EP",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>300,'spaceAfter'=>0));
		  $section->addText("             EP  = NOPAT – Capital Charge",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>0,'spaceAfter'=>0));
		  $section->addText("             NOPAT	= รายได้ – ค่าใช้จ่าย- ภาษี",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>0,'spaceAfter'=>0));
		   
		  $section->addText("ค่าใช้จ่ายเปรียบเทียบกับรายได้ ปี ".$year." ดังนี้",array('name'=>'TH SarabunPSK', 'color'=>'black','bold'=>true, 'size'=>17),array('align'=>'left', 'spaceBefore'=>300,'spaceAfter'=>0));
		  
		  $departments = Department::model()->findAll();

		  $income = array();
		  $outcome = array();
		  $management = array();
		  $sap = array();
		  $no = 1;
		  foreach ($departments as $key => $dept) {
		  	    $department = $dept->id;
		  	    $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='$department' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$income[$dept->id] = !empty($pp[0]) ? $pp[0]["sum"] : 0;

         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='$department' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$outcome[$dept->id] = !empty($pp[0]) ? $pp[0]["sum"] : 0;

         		$pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id='$department' AND year='$year'")
                                            ->queryAll();
         		//print_r($pp);
         		$sap[$dept->id] = !empty($pp[0]) ? $pp[0]["cost"] : 0;


         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='$department' AND mc_type!=0 AND mc_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
                $manage[$dept->id] = !empty($pp[0]) ? $pp[0]["sum"] : 0;

                $section->addText(($no++).". ".$dept->name,array('name'=>'TH SarabunPSK', 'bold'=>true,'color'=>'black','size'=>17),array('spaceBefore'=>0,'spaceAfter'=>0));
	        
                $table = $section->addTable(array("cellMargin"=>0));
	            $table->addRow();
				$table->addCell(6850)->addText("รายได้",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1950)->addText(number_format($income[$dept->id],2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
				$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));

				
	            $table->addRow();
				$table->addCell(6850)->addText("ค่าใช้จ่ายจ้างเหมา",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1950)->addText(number_format($outcome[$dept->id],2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
				$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	       		
	            $table->addRow();
				$table->addCell(6850)->addText("ค่าใช้จ่ายดำเนินงาน",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1950)->addText(number_format($manage[$dept->id],2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
				$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	       		
	            $table->addRow();
				$table->addCell(6850)->addText("ค่าใช้จ่ายบริหารงาน",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1750)->addText("เป็นจำนวนเงิน",'rStyle',array('spaceAfter'=>0));
				$table->addCell(1950)->addText(number_format($sap[$dept->id],2),'rStyle',array("align"=>"right",'spaceAfter'=>0));
				$table->addCell(750)->addText("บาท",'rStyle',array("align"=>"right",'spaceAfter'=>0));
	       		
	       		$section->addImage($items[$no_pic-1]->filename);
	            $section->addText("รูปที่ ".($no_pic++),array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('align'=>'center', 'spaceBefore'=>300));
		        

		  }
      
      	        $section->addImage($items[$no_pic-1]->filename);
	            $section->addText("รูปที่ ".($no_pic++),array('name'=>'TH SarabunPSK', 'color'=>'black','size'=>17),array('align'=>'center', 'spaceBefore'=>300));
		   		
    //$section->addTextBreak(1);
  

		   ob_end_clean();
			ob_start();

			header('Content-Type: application/vnd.ms-word');
			header('Content-Disposition: attachment;filename="service_report.docx"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
			$objWriter->save('php://output');  //

//delete images file form exporter-server			 
    $files = glob(Yii::getPathOfAlias('EXPORT_PATH').'/*.jpg');
	foreach($files as $file) {
	    unlink($file);
	}

			 Yii::app()->end(); 

    
	
}	   



	public function actionDocgen()
    {
	    if(isset($_POST['type']) && isset($_POST['title']) && isset($_POST['header']) && isset($_POST['footer']) && isset($_POST['data'])){
	    
	  $title=urldecode($_POST['title']);
	  $header=urldecode($_POST['header']);
	  $footer=urldecode($_POST['footer']);
	    
	  $type=urldecode($_POST['type']);
	  $data=json_decode(urldecode($_POST['data']));
	  
	  
	  $items=array();
	  for($i=0; $i < count($data); $i++){
	    $items[]= $this->svgToJpg($data[$i]);
	  }
	 
	  if($type=='pdf'){
	    $this->doPDF($title,$header,$footer,$items);
	  }elseif($type=='doc'){
	    $this->doDoc($title,$header,$footer,$items);
	  }
	  foreach($items as $item){
	    unlink($item->filename);
	  }
	  
	}else{
	  print 'ERROR docgen.php: no post data!';
	}
 }


    public function actionGenService()
    {
    	$year = $_GET["fiscalyear"];
    	$report = $_GET["report"];
    	$workcat = $_GET["workcat"];
    	$department = $_GET["department"];

    	if($report=="all")
    	{
    		 $report = array();
    		 $dateBegin = $year."-01-01";
    		 $dateEnd = $year."-12-31";
             
    		//chart 1: income 
	             $workcat = WorkCategory::model()->findAll();
	             $data = array();
	             foreach ($workcat as $key => $wc) {
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sum = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sum += $pj->getIncome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             	}
	             	$data[] = array("name"=>$wc->wc_name, "value"=>$sum,"drill"=> 0);
	             }
	        $report[] = array("name"=>"รายได้งานบริการวิศวกรรมของ กบว.","data"=>$data);
	        
	        //chart 2: outcome by workcat
	        $data = array();
	         foreach ($workcat as $key => $wc) {
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sumW = 0;
	             	$sumW2 = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             
	             	}
	             	$data[] = array("name"=>"ค่าจ้างเหมา".$wc->wc_name, "value"=>$sumW,"drill"=> 0);
	             	$data[] = array("name"=>"ค่าดำเนินงาน".$wc->wc_name, "value"=>$sumW2,"drill"=> 0);
	             }     
	        $report[] = array("name"=>"ค่าใช้จ่ายงานบริการวิศวกรรมตามสัญญา ","data"=>$data);
	        

			//chart 3: outcome by workcat
				 
			foreach ($workcat as $key => $wc) {
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sumW = 0;
	             	$sumW2 = 0;
	             	$data = array();
	             	foreach ($projects as $key => $pj) {
	             		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             
	             	}
	             	$data[] = array("name"=>"ค่าจ้างเหมา", "value"=>$sumW,"drill"=> 0);
	             	$data[] = array("name"=>"ค่าดำเนินงาน", "value"=>$sumW2,"drill"=> 0);

	             	$report[] = array("name"=>"ค่าใช้จ่าย".$wc->wc_name,"data"=>$data); 
	             }     
	         
			//chart 4 : compare income and outcome
	          
	         $departments = Department::model()->findAll(); 
             $data = array();
             foreach ($departments as $key => $value) {
               $department = $value->id;
	           $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='$department' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$tsd_income = !empty($pp[0]) ? $pp[0]["sum"] : 0;

         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='$department' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$tsd_outcome = !empty($pp[0]) ? $pp[0]["sum"] : 0;

         		$pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id='$department' AND year='$year'")
                                            ->queryAll();
         		//print_r($pp);
         		$tsd_sap = !empty($pp[0]) ? $pp[0]["cost"] : 0;


         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='$department' AND mc_type!=0 AND mc_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
                $tsd_manage = !empty($pp[0]) ? $pp[0]["sum"] : 0;
                
                $data2 = array();
                $data2[] = array("name"=>"รายได้", "value"=>$tsd_income,"drill"=> 0);
                $data2[] = array("name"=>"ค่าจ้างเหมา", "value"=>$tsd_outcome,"drill"=> 0);
                $data2[] = array("name"=>"ค่าดำเนินงาน", "value"=>$tsd_manage,"drill"=> 0);
                $data2[] = array("name"=>"ค่าบริหารงาน", "value"=>$tsd_sap,"drill"=> 0);
                $report[] = array("name"=>"รายได้เปรียบเทียบกับค่าใช้จ่าย ของ".$value->name,"data"=>$data2);

                $data[] = array("name"=>$value->shortname,"value"=>$data2,"drill"=> 0);
                     
            }    
            $report[] = array("name"=>"รายได้เปรียบเทียบกับค่าใช้จ่าย","data"=>$data);




	        echo json_encode($report);     
    	}

    	if($report==1)
    	{
    		 $dateBegin = $year."-01-01";
    		 $dateEnd = $year."-12-31";


             
    		 if(empty($workcat))
    		 {	
	             $workcat = WorkCategory::model()->findAll();
	             $data = array();
	             foreach ($workcat as $key => $wc) {
	             	if(empty($department))
	             	   $projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	else
	             	   $projects =Project::model()->with('user')->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id.' AND department_id='.$department));
                 		
	             	$sum = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sum += $pj->getIncome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             	}
	             	$data[] = array("name"=>$wc->wc_name, "value"=>$sum,"drill"=> 0);
	             }
	        }
	        else{
	        	 $wc = WorkCategory::model()->findByPk($workcat);
	             $data = array();
	            
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sum = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sum += $pj->getIncome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             	}
	             	$data[] = array("name"=>$wc->wc_name, "value"=>$sum,"drill"=> 0);
	            
	        }     
             echo json_encode($data);
    	}

    	if($report==2)
    	{
    		    
    		 $dateBegin = $year."-01-01";
    		 $dateEnd = $year."-12-31";
             

             $data = array();
             if(empty($department))
             {
             	$projects =Project::model()->findAll();
             	
             }
             else
             {
             	$projects =Project::model()->with('user')->findAll(array('condition'=>'department_id='.$department));
                 		
             }

             $sum = 0;
             	$sum2 = 0;
             	foreach ($projects as $key => $pj) {
             		$sum += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
             		$sum2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
             	}

             	
             	// $workcat = WorkCategory::model()->findAll();
	             // $dataW = array();
	             // $dataW2 = array();
	             // foreach ($workcat as $key => $wc) {
	             // 	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             // 	$sumW = 0;
	             // 	$sumW2 = 0;
	             // 	foreach ($projects as $key => $pj) {
	             // 		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             // 		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             
	             // 	}
	             // 	if($sumW!=0)
	             // 	$dataW[] = array("name"=>$wc->wc_name, "y"=>$sumW);
	             // 	if($sumW2!=0)
	             // 	$dataW2[] = array("name"=>$wc->wc_name, "y"=>$sumW2);
	             // }
	            // $sum = 50;
	            // $sum2 = 80;
             	$data[] = array("name"=>"ค่าจ้างเหมา", "value"=>$sum,"drill"=>0);
             	$data[] = array("name"=>"ค่าดำเนินงาน", "value"=>$sum2,"drill"=>0);
             

             echo json_encode($data);
    	}	

    	if($report==3)
    	{
    		    
    		 $dateBegin = $year."-01-01";
    		 $dateEnd = $year."-12-31";
             

             $data = array();
             if(empty($workcat))
    		 {	
             	$workcat = WorkCategory::model()->findAll();
	          
	             foreach ($workcat as $key => $wc) {
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sumW = 0;
	             	$sumW2 = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             
	             	}
	             	$data[] = array("name"=>"ค่าจ้างเหมา".$wc->wc_name, "value"=>$sumW,"drill"=> 0);
	             	$data[] = array("name"=>"ค่าดำเนินงาน".$wc->wc_name, "value"=>$sumW2,"drill"=> 0);
	             }
	         }
	         else{
	         	  $wc = WorkCategory::model()->findByPk($workcat);
	          
	             
	             	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
	             	$sumW = 0;
	             	$sumW2 = 0;
	             	foreach ($projects as $key => $pj) {
	             		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
	             
	             	}
	             	$data[] = array("name"=>"ค่าจ้างเหมา".$wc->wc_name, "value"=>$sumW,"drill"=> 0);
	             	$data[] = array("name"=>"ค่าดำเนินงาน".$wc->wc_name, "value"=>$sumW2,"drill"=> 0);
	            
	         }    
	            // $sum = 50;
	            // $sum2 = 80;
             

             echo json_encode($data);
    	}

    	if($report==4)
    	{
    		    
    		 $dateBegin = $year."-01-01";
    		 $dateEnd = $year."-12-31";
             

             $data = array();
             
		     if($department!="")
		     {        
		       //       if(empty($workcat))
		    		 // {	
		       //       	$workcat = WorkCategory::model()->findAll();
			          
			      //        foreach ($workcat as $key => $wc) {
			      //        	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
			      //        	$sumW = 0;
			      //        	$sumW2 = 0;
			      //        	foreach ($projects as $key => $pj) {
			      //        		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
			      //        		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
			             
			      //        	}
			      //        	$data[] = array("name"=>"ค่าจ้างเหมา".$wc->wc_name, "value"=>$sumW,"drill"=> 0);
			      //        	$data[] = array("name"=>"ค่าดำเนินงาน".$wc->wc_name, "value"=>$sumW2,"drill"=> 0);
			      //        }
			      //    }
			      //    else{
			         	  
			      //    	    $wc = WorkCategory::model()->findByPk($workcat);
			          
			             
			      //        	$projects =Project::model()->findAll(array('condition'=>'pj_work_cat='.$wc->wc_id));
			      //        	$sum = 0;
			      //        	$sumW = 0;
			      //        	$sumW2 = 0;
			      //        	foreach ($projects as $key => $pj) {
			      //        		$sumW += $pj->getOutcome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
			      //        		$sumW2 += $pj->getManageCost(" BETWEEN '$dateBegin' AND '$dateEnd' ");
			      //        		$sum += $pj->getIncome(" BETWEEN '$dateBegin' AND '$dateEnd' ");
			             
			      //        	}
			      //        	$data[] = array("name"=>"รายได้".$wc->wc_name, "value"=>$sum,"drill"=> 0);
			      //        	$data[] = array("name"=>"ค่าจ้างเหมา".$wc->wc_name, "value"=>$sumW,"drill"=> 0);
			      //        	$data[] = array("name"=>"ค่าดำเนินงาน".$wc->wc_name, "value"=>$sumW2,"drill"=> 0);
			            
			      //    } 

			      $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='$department' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$tsd_income = $pp[0]["sum"];

         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='$department' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$tsd_outcome = $pp[0]["sum"];

         		$pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id='$department' AND year='$year'")
                                            ->queryAll();
         		//print_r($pp);
         		$tsd_sap = !empty($pp[0]) ? $pp[0]["cost"] : 0;


         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='$department' AND mc_type!=0 AND mc_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
                $tsd_manage = $pp[0]["sum"];

                $data[] = array("name"=>"รายได้", "value"=>$tsd_income,"drill"=> 0);
                $data[] = array("name"=>"ค่าจ้างเหมา", "value"=>$tsd_outcome,"drill"=> 0);
                $data[] = array("name"=>"ค่าดำเนินงาน", "value"=>$tsd_manage,"drill"=> 0);
                $data[] = array("name"=>"ค่าบริหารงาน", "value"=>$tsd_sap,"drill"=> 0);
                
   
	        }
	        else{

	        	

	        	//tsd กองบริการวิศวกรรมระบบส่ง
	        	$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id=3 AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$tsd_income = $pp[0]["sum"];

         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id=3 AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$tsd_outcome = $pp[0]["sum"];

         		$pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=3 AND year='$year'")
                                            ->queryAll();
         		//print_r($pp);
         		$tsd_sap = !empty($pp[0]) ? $pp[0]["cost"] : 0;


         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id=3 AND mc_type!=0 AND mc_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
                $tsd_manage = $pp[0]["sum"];

                $data2 = array();
                $data2[] = array("name"=>"รายได้", "value"=>$tsd_income,"drill"=> 0);
                $data2[] = array("name"=>"ค่าจ้างเหมา", "value"=>$tsd_outcome,"drill"=> 0);
                $data2[] = array("name"=>"ค่าดำเนินงาน", "value"=>$tsd_manage,"drill"=> 0);
                $data2[] = array("name"=>"ค่าบริหารงาน", "value"=>$tsd_sap,"drill"=> 0);
                $data[] = array("name"=>"กบศ.","value"=>$data2);

         		//msd กองบริการบำรุงรักษา
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_project_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id=1 AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date BETWEEN '$dateBegin' AND '$dateEnd'")
		                                            ->queryAll();
		         $msd_income = $pp[0]["sum"];

		        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id=1 AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$msd_outcome = $pp[0]["sum"];

         		$pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id=1 AND year='$year'")
                                            ->queryAll();
         		$msd_sap = !empty($pp[0]) ? $pp[0]["cost"] : 0;

         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id=1 AND mc_type!=0 AND mc_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
                $msd_manage = $pp[0]["sum"];


                $data2 = array();
                $data2[] = array("name"=>"รายได้", "value"=>$msd_income,"drill"=> 0);
                $data2[] = array("name"=>"ค่าจ้างเหมา", "value"=>$msd_outcome,"drill"=> 0);
                $data2[] = array("name"=>"ค่าดำเนินงาน", "value"=>$msd_manage,"drill"=> 0);
                $data2[] = array("name"=>"ค่าบริหารงาน", "value"=>$msd_sap,"drill"=> 0);
                $data[] = array("name"=>"กรษ.","value"=>$data2);


		         //dsd กองบริการวิศวกรรมระบบจำหน่าย
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_project_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id='2' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date BETWEEN '$dateBegin' AND '$dateEnd'")
		                                            ->queryAll();
		         $dsd_income = $pp[0]["sum"];

		         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('user','user_create=u_id')
                                            ->where("department_id='2' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
         		$dsd_outcome = $pp[0]["sum"];

         		$pp = Yii::app()->db->createCommand()
                                            ->select('cost')
                                            ->from('management_cost_sap')
                                            ->where("department_id='2' AND year='$year'")
                                            ->queryAll();
         		$dsd_sap = !empty($pp[0]) ? $pp[0]["cost"] : 0;


         		$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='2' AND mc_type!=0 AND mc_date BETWEEN '$dateBegin' AND '$dateEnd'")
                                            ->queryAll();
                $dsd_manage = $pp[0]["sum"];

                $data2 = array();
                $data2[] = array("name"=>"รายได้", "value"=>$dsd_income,"drill"=> 0);
                $data2[] = array("name"=>"ค่าจ้างเหมา", "value"=>$dsd_outcome,"drill"=> 0);
                $data2[] = array("name"=>"ค่าดำเนินงาน", "value"=>$dsd_manage,"drill"=> 0);
                $data2[] = array("name"=>"ค่าบริหารงาน", "value"=>$dsd_sap,"drill"=> 0);
                $data[] = array("name"=>"กบจ.","value"=>$data2);


	        }

             echo json_encode($data);
    	}			
	

    }

    public function actionGenStatement()
    {
        	
	    
	    $model = Project::model()->findAll();	
	    
    	$monthBegin = $_GET["monthBegin"];
    	$monthEnd = $_GET["monthEnd"];
    	$yearBegin = $_GET["yearBegin"];
    	$yearEnd = $_GET["yearEnd"];

    	// header('Content-type: text/plain');
     //       echo($_GET["fiscalyear"]);                    
     //    exit;

        $this->renderPartial('_formStatement', array(
            'model' => $model,'monthBegin'=>$monthBegin,'monthEnd'=>$monthEnd,'yearBegin'=>$yearBegin,'yearEnd'=>$yearEnd,
            'display' => 'block',
        ), false, true);

        
    }

    public function actionPrintStatement()
    {
        	
	    
	    $model = Project::model()->findAll();	
	    
    	$monthBegin = $_GET["monthBegin"];
    	$monthEnd = $_GET["monthEnd"];
    	$yearBegin = $_GET["yearBegin"];
    	$yearEnd = $_GET["yearEnd"];

    	// header('Content-type: text/plain');
     //       echo($_GET["fiscalyear"]);                    
     //    exit;

        $this->renderPartial('_formStatementPDF', array(
            'model' => $model,'monthBegin'=>$monthBegin,'monthEnd'=>$monthEnd,'yearBegin'=>$yearBegin,'yearEnd'=>$yearEnd,
            'display' => 'block',
        ), false, true);

        
    }

    public function actionGenSummaryCashflow()
    {
        
    	
	    	// if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    	// 	$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	// else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	// else
	    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
    	$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    }
        $this->renderPartial('_formSummaryCashflow', array(
            'model' => $model,
            'display' => 'block',
        ), false, true);

        
    }

    function renderDate($value)
	{
	    $th_month = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	    $dates = explode("/", $value);
	    $d=0;
	    $mi = 0;
	    $yi = 0;
	    foreach ($dates as $key => $value) {
	         $d++;
	         if($d==2)
	            $mi = $value;
	         if($d==3)
	            $yi = $value;
	    }
	    if(substr($mi, 0,1)==0)
	        $mi = substr($mi, 1);
	    if(substr($dates[0], 0,1)==0)
	        $d = substr($dates[0], 1);
	    else
	        $d = $dates[0];

	    $renderDate = $d." ".$th_month[$mi]." ".substr($yi,2);
	    if($renderDate==0)
	        $renderDate = "";   

	    return $renderDate;             
	}

	function renderDate2($value)
	{
	    $th_month = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	    $dates = explode("-", $value);
	    $d=0;
	    $mi = 0;
	    $yi = 0;
	    foreach ($dates as $key => $value) {
	         $d++;
	         if($d==2)
	            $mi = $value;
	         if($d==1)
	            $yi = $value;
	    }
	    if(substr($mi, 0,1)==0)
	        $mi = substr($mi, 1);
	    if(substr($dates[2], 0,1)==0)
	        $d = substr($dates[2], 1);
	    else
	    	$d = $dates[2];

	    $renderDate = $d." ".$th_month[$mi]." ".$yi;
	    if($renderDate==0)
	        $renderDate = "";   

	    return $renderDate;             
	}

	public function actionGenSummaryExcel()
    {
    	   $model = Project::model()->findByPk($_GET["project"]);

		   Yii::import('ext.phpexcel.XPHPExcel');    
		   $objPHPExcel= XPHPExcel::createPHPExcel();
		   $objReader = PHPExcel_IOFactory::createReader('Excel5');
           $objPHPExcel = $objReader->load("report/templateSummary.xls");

		    $title = new PHPExcel_Style();
		    $title->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,     
			            'bold'=>true,         
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			          
			            
			    ));
		    $header = new PHPExcel_Style();
			$header->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15, 
			            'bold'=>true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' =>'64ED74')
			        ),
			            
			    ));

			$header2 = new PHPExcel_Style();
			$header2->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15, 
			            'bold'=>true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' =>'F7E672')
			        ),
			            
			    ));

			$detail = new PHPExcel_Style();
			$detail->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15, 
			            //'bold'=>true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        )			            
			    ));
			$detail_tb = new PHPExcel_Style();
			$detail_tb->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'top'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

		   $row_start = 2;
		   $row = 2;
		    $pj = $model;
			//project contract
			$Criteria = new CDbCriteria();
			$Criteria->condition = "pc_proj_id='$pj->pj_id'";
			$pcs = ProjectContract::model()->findAll($Criteria);

		   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row++,"โครงการ ".$pcs[0]->pc_details);
		   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row++,"ให้ ".$pj->pj_name);
		   $objPHPExcel->getActiveSheet()->setSharedStyle($title, "A".$row_start.":J".$row);
		   $objPHPExcel->getActiveSheet()->getStyle("A".$row_start.":J".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);		   
		   
		   $row++;
		   $row_pj = $row;
		   $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':J'.$row);
		   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row++,"ส่วนผู้ว่าจ้าง : ".$pj->pj_name);
		   $objPHPExcel->getActiveSheet()->setSharedStyle($header, "A".$row_pj.":J".($row-1));
		   $objPHPExcel->getActiveSheet()->getStyle("A".$row_pj.":J".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		   
		   $row_detail = $row;
		   foreach ($pcs as $key => $pc) {
				//echo   "<tr><td width='30%'>ใบสั่งจ้างเลขที่ : ".$pc->pc_code."</td><td width='30%'>วันที่เริ่มในสัญญา : ".renderDate($pc->pc_sign_date)."</td><td width='50%' colspan=2>วันที่สิ้นสุดในสัญญา : ".renderDate($pc->pc_end_date)."</td></tr>";
				
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"ใบสั่งจ้างเลขที่ : ".$pc->pc_code);
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$row.':E'.$row);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"วันที่เริ่มในสัญญา : ".$this->renderDate($pc->pc_sign_date));

				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$row.':I'.$row);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"วันที่สิ้นสุดในสัญญา : ".$this->renderDate($pc->pc_end_date));
				$row++;
			}
		   	
		    //workcode
			$Criteria = new CDbCriteria();
			$Criteria->condition = "pj_id='$pj->pj_id'";
			$wcs = WorkCode::model()->findAll($Criteria);
			

			$i=0;
			$row_code = $row;
			foreach ($wcs as $key => $wc) {
				if($i==0)  
				  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"หมายเลขงาน : ".$wc->code);
				else
				  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"                   : ".$wc->code);
				$i++;
				$row++;
			}
			if($i==0)
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"หมายเลขงาน : ");

			$row = $row_code;
			$i=0;
			$sum_pc_cost = 0;
			$check = false;
			foreach ($pcs as $key => $pc) {

				$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
		                				///print_r($changeHists);
                                        //echo $pp[0]["sum"];    

				$pcCost =$pc->pc_cost + $pp[0]["sum"];

				$sum_pc_cost += $pcCost;
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$row.':E'.$row);
			    
			    
			    if(!empty($pc->pc_name_request))
				{    	
				    $check = true;
				    if($i==0)  
					  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"แจ้งจัดสรรงบ กปง./กซข./กฟจ. : ".$pc->pc_name_request);
					else
					  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"                                          : ".$pc->pc_name_request);
				}
				else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"แจ้งจัดสรรงบ กปง./กซข./กฟจ. : ");
					
				}	
				$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$row.':I'.$row);
			    
			    if(!empty($pc->pc_code_request))
				{ 
				    $check = true;
				    if($i==0)  
					  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"เลขที่ส่ง / ลว. : ".$pc->pc_code_request);
					else
					  $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"                            : ".$pc->pc_code_request);
				}
				else{
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"เลขที่ส่ง / ลว. : ");
					
				}	
				$i++;

				 $row++;	
			}
			

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row_code,"วงเงิน : ".number_format($sum_pc_cost,2));
				
			$row = $objPHPExcel->getActiveSheet()->getHighestRow();
			if(!$check)
				$row--;
			$objPHPExcel->getActiveSheet()->setSharedStyle($detail, "A".$row_detail.":J".($row));


			//table header
 // header('Content-type: text/plain');
 //                           		count($pcs);                    
 //                           	    exit;
			//$row = 10;
			$row++;
			$row_detail = $row;
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':A'.($row+1));			    
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,"ที่");
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$row.':E'.($row));			    
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"ด้านการดำเนินการโครงการ");			
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$row.':J'.($row));			    
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"ด้านการเงิน");
			$row++;
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"รายละเอียด");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"อนุมัติโดย/ลงวันที่");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row,"วงเงิน/เป็นเงินเพิ่ม");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row,"ระยะเวลาแล้วเสร็จ/ระยะเวลาขอขยาย");
			
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"ชำระเงินงวดที่");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row,"ใบแจ้งหนี้/ลงวันที่");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row,"ใบเสร็จเลขที่/ลงวันที่");
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row,"วงเงิน");
			$row++;
			
			$row_ap = $row;
			$row_pa = $row;
			$index = 1;
			$sum_pay = 0;
			foreach ($pcs as $key => $pc) {
				$approve = Yii::app()->db->createCommand()
	                            ->select('detail,approveBy,dateApprove,cost,timeSpend')
	                            ->from('contract_approve_history')
	                            ->where("contract_id='$pc->pc_id' AND type=1")
	                            ->queryAll();
	            foreach ($approve as $key => $value) {
			    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row_ap,$index);
			    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row_ap,$value["detail"]);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row_ap,$value["approveBy"]."\r".$this->renderDate2($value["dateApprove"]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row_ap,number_format($value["cost"],2));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row_ap,$value["timeSpend"]);
					$index++;
			    	$row_ap++;
	            }
	            
	            $payment = Yii::app()->db->createCommand()
	                            ->select('*')
	                            ->from('payment_project_contract')
	                            ->where("proj_id='$pc->pc_id'")
	                            ->queryAll();                
	           
	            foreach ($payment as $key => $value) {
	            	
	        		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row_pa,$value["detail"]);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row_pa,$value["invoice_no"]."\r".$this->renderDate2($value["invoice_date"]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row_pa,$value["bill_no"]."\r".$this->renderDate2($value["bill_date"]));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row_pa,number_format($value["money"],2));
					$row_pa++;

					if($value["bill_no"]!=""){
               			$sum_pay += $value["money"];
               		}
	            }
			}
			$remain = $sum_pc_cost - $sum_pay;
			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$row_pa.':I'.($row_pa));	
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row_pa,"              คงเหลือ");
		    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row_pa,number_format($remain,2));
					

			$row_tb = $row;
			$row = $objPHPExcel->getActiveSheet()->getHighestRow()+1;	
			$objPHPExcel->getActiveSheet()->setSharedStyle($detail_tb, "A".$row_detail.":E".($row-1));
			$objPHPExcel->getActiveSheet()->setSharedStyle($detail_tb, "G".$row_detail.":J".($row-1));
			$objPHPExcel->getActiveSheet()->getStyle("A".$row_detail.":J".($row_tb-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		    $objPHPExcel->getActiveSheet()->getStyle("A".$row_detail.":J".($row_tb-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
            
            $objPHPExcel->getActiveSheet()->getStyle("A".$row_tb.":J".($row-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
            $objPHPExcel->getActiveSheet()->getStyle("D".$row_tb.":D".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("J".$row_tb.":J".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle("A".$row_tb.":A".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("C".$row_tb.":C".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle("H".$row_tb.":I".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            

            $objPHPExcel->getActiveSheet()->getStyle("A".$row_detail.":J".($row-1))->getAlignment()->setWrapText(true);		   
		
            

            //----------------outsource-------------------------//
            $Criteria = new CDbCriteria();
			$Criteria->condition = "oc_proj_id='$pj->pj_id'";
			$ocs = OutsourceContract::model()->findAll($Criteria);


			$index = 0;

			foreach ($ocs as $key => $oc) {
			        $index++;
			        $row++;
			        $vendor = Vendor::model()->findByPk($oc->oc_vendor_id);	
					
			        $sum_oc_cost = 0;
					$pp = Yii::app()->db->createCommand()
				                                            ->select('SUM(cost) as sum')
				                                            ->from('contract_change_history')
				                                            ->where("contract_id='$oc->oc_id' AND type=2")
				                                            ->queryAll();
						                				///print_r($changeHists);
				    $oc->oc_cost = str_replace(",", "", $oc->oc_cost);    

					$sum_oc_cost =$oc->oc_cost + $pp[0]["sum"];

					
		            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':J'.$row);
				   	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,"ส่วนผู้รับจ้าง รายที่ ".$index." : ".$vendor->v_name);
				   	$objPHPExcel->getActiveSheet()->setSharedStyle($header2, "A".$row.":J".$row);
				   	$objPHPExcel->getActiveSheet()->getStyle("A".$row.":J".$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				    $row++;
				    $row_oc = $row;
				    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"สัญญาจ้างเลขที่ : ".$oc->oc_code);
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$row.':E'.$row);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"วันที่เริ่มในสัญญา : ".$this->renderDate($oc->oc_sign_date));

					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$row.':I'.$row);
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"วันที่สิ้นสุดในสัญญา : ".$this->renderDate($oc->oc_end_date));
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row,"วงเงิน : ".number_format($sum_oc_cost,2));
				
					$row++;
					//po
					$Criteria = new CDbCriteria();
					$Criteria->condition = "contract_id='$oc->oc_id'";
					$pos = WorkCodeOutsource::model()->findAll($Criteria);
					
					//print_r($pos);
					
					$index2 = 1;
					foreach ($pos as $key => $po) {
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,$index2);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"PO เลขที่ : ".$po->PO);
						$objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$row.':G'.$row);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"เลขที่ส่งแจ้งรับรองงบ กปง. : ".$po->letter);
						$objPHPExcel->setActiveSheetIndex(0)->mergeCells('H'.$row.':I'.$row);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row,"เป็นเงิน : ".number_format($po->money,2));
					    $index2++;
					    $row++;
					}
					$objPHPExcel->getActiveSheet()->setSharedStyle($detail, "A".$row_oc.":J".($row-1));

					$row_detail = $row;
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':A'.($row+1));			    
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row,"ที่");
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$row.':E'.($row));			    
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"ด้านการดำเนินการโครงการ");			
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$row.':J'.($row));			    
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"ด้านการเงิน");
					$row++;
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row,"รายละเอียด");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,"อนุมัติโดย/ลงวันที่");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row,"วงเงิน/เป็นเงินเพิ่ม");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row,"ระยะเวลาแล้วเสร็จ/ระยะเวลาขอขยาย");
					
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row,"ชำระเงินงวดที่");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row,"อนุมัติโดย");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row,"วัน/เดือน/ปี");
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row,"วงเงิน");
					$row++;

					$approve = Yii::app()->db->createCommand()
		                            ->select('detail,approveBy,dateApprove,cost,timeSpend')
		                            ->from('contract_approve_history')
		                            ->where("contract_id='$oc->oc_id' AND type=2")
		                            ->queryAll();
		            $row_ap = $row;
		            $index3 = 1;                
		            foreach ($approve as $key => $value) {
				    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row_ap,$index3);
				    	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row_ap,$value["detail"]);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row_ap,$value["approveBy"]."\r".$this->renderDate2($value["dateApprove"]));
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row_ap,number_format($value["cost"],2));
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row_ap,$value["timeSpend"]);
						$index3++;
				    	$row_ap++;
		            }
		                            
		        
			        $payment = Yii::app()->db->createCommand()
			                            ->select('*')
			                            ->from('payment_outsource_contract')
			                            ->where("contract_id='$oc->oc_id'")
		            	                ->queryAll();                
			        $sum_pay = 0;
			        $row_pa = $row;
			        foreach ($payment as $key => $value) {
			        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row_pa,$value["detail"]);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row_pa,$value["approve_by"]);
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row_pa,$this->renderDate2($value["approve_date"]));
						$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row_pa,number_format($value["money"],2));
						$row_pa++;

						if($value["approve_date"]!=""){
	               			$sum_pay += $value["money"];
	               		}
	               	}

	               	$remain = $sum_oc_cost - $sum_pay;
					$objPHPExcel->setActiveSheetIndex(0)->mergeCells('G'.$row_pa.':I'.($row_pa));	
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row_pa,"              คงเหลือ");
		    		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$row_pa,number_format($remain,2));
						
		    		$row_tb = $row;
					$row = $objPHPExcel->getActiveSheet()->getHighestRow()+1;	
					$objPHPExcel->getActiveSheet()->setSharedStyle($detail_tb, "A".$row_detail.":E".($row-1));
					$objPHPExcel->getActiveSheet()->setSharedStyle($detail_tb, "G".$row_detail.":J".($row-1));
					$objPHPExcel->getActiveSheet()->getStyle("A".$row_detail.":J".($row_tb-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
				    $objPHPExcel->getActiveSheet()->getStyle("A".$row_detail.":J".($row_tb-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
		            
		            $objPHPExcel->getActiveSheet()->getStyle("A".$row_tb.":J".($row-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		            $objPHPExcel->getActiveSheet()->getStyle("D".$row_tb.":D".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		            $objPHPExcel->getActiveSheet()->getStyle("J".$row_tb.":J".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		            $objPHPExcel->getActiveSheet()->getStyle("A".$row_tb.":A".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		            $objPHPExcel->getActiveSheet()->getStyle("C".$row_tb.":C".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		            $objPHPExcel->getActiveSheet()->getStyle("H".$row_tb.":I".($row-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		            

		            $objPHPExcel->getActiveSheet()->getStyle("A".$row_detail.":J".($row-1))->getAlignment()->setWrapText(true);		   
				
				    //$row++;
			}	   	

		    $objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

		    ob_end_clean();
			ob_start();

			header('Content-Type: application/vnd.ms-excel');
			header('Content-Disposition: attachment;filename="summary_report.xls"');
			header('Cache-Control: max-age=0');
			// If you're serving to IE 9, then the following may be needed
			header('Cache-Control: max-age=1');

			// If you're serving to IE over SSL, then the following may be needed
			header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
			header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
			header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
			header ('Pragma: public'); // HTTP/1.0

			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
			$objWriter->save('php://output');  //
			 Yii::app()->end(); 

    }	

    public function actionGenProgressExcel()
    {
			

    	   // if(isset($_GET["project"]) && !empty($_GET["project"])) 
    	   // 		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	       // else
    	  	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
    	  	
    	$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    	}
	
		   Yii::import('ext.phpexcel.XPHPExcel');    
		   $objPHPExcel= XPHPExcel::createPHPExcel();
		   $objReader = PHPExcel_IOFactory::createReader('Excel5');
           $objPHPExcel = $objReader->load("report/templateProgress.xls");


           		//fiscalyear
                $fiscalyear = array();

                foreach ($model as $key => $value) {
                	
                	//print_r($value);
                	if(!in_array($value->pj_fiscalyear."/".$value->pj_work_cat, $fiscalyear))
                	   $fiscalyear[] = $value->pj_fiscalyear."/".$value->pj_work_cat;
                

                }

                //print_r($model);
                $row = 3;

                $filapar = new PHPExcel_Style();
			    $filapar->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' =>'FA9D8E')
			        ),
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

				$sum = new PHPExcel_Style();
			    $sum->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            'color' => array('rgb' =>'E070F4')
			        ),
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

			    $normal = new PHPExcel_Style();
			    $normal->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

			    $end_project = new PHPExcel_Style();
			    $end_project->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));



			    $cell_underline = array();
			    $cell_pc_end = array();
			    $cell_oc_end = array();

                asort($fiscalyear);
                //summary all
                    $sumall_pc_cost = 0;
                    $sumall_pc_receive = 0;
                     
                    $sumall_oc_cost = 0;
                    $sumall_oc_receive = 0;

                    $sumall_m_real = 0;
                    $sumall_m_type1 = 0;
                    $sumall_m_expect = 0;
                    $sumall_profit = 0;
                foreach ($fiscalyear as $key => $value) {
                	$data = explode("/", $value);
                	$year = $data[0];
                	$cat = $data[1];

                	$mWorkCat = WorkCategory::model()->findByPk($cat);

		   			// Rename sheet
		   			$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':AD'.$row);
		      		$objPHPExcel->getActiveSheet()->setTitle('ปี '.$year);
		      		 $objPHPExcel->setActiveSheetIndex(0)
		             			->setCellValue('A'.$row, "ปี ".$year." ".$mWorkCat->wc_name);
                	// $objPHPExcel->setActiveSheetIndex(0)
		            			// ->setCellValue('A4', "1");
                	
                	$objPHPExcel->getActiveSheet()->setSharedStyle($filapar, "A".$row.":AD".$row);
                	//$objPHPExcel->getActiveSheet()->setSharedStyle($normal, "A4:AD4");

                	$maxPayment = 5;
                	$index = 1;

                	 //summary
                         $sum_pc_cost = 0;
                         $sum_pc_receive = 0;
                         $sum_pc_T = 0;
                         $sum_pc_A = 0;

                         $sum_oc_cost = 0;
                         $sum_oc_receive = 0;
                         $sum_oc_T = 0;
                         $sum_oc_A = 0;

                         $sum_m_real = 0;
                         $sum_m_type1 = 0;
                         $sum_m_expect = 0;
                         $sum_profit = 0;

                    $row++;     
                	foreach ($model as $key => $pj) {
                	  if($pj->pj_fiscalyear==$year && $pj->pj_work_cat==$cat)
                	  {
                	  		//project contract
	                	 $Criteria = new CDbCriteria();
	                     $Criteria->condition = "pc_proj_id='$pj->pj_id'";
	                	 $pcs = ProjectContract::model()->findAll($Criteria);
                         $nPC = count($pcs);

                         //2.outsource contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                         $ocs = OutsourceContract::model()->findAll($Criteria);
                         $nOC = count($ocs);

                         //management cost
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project!=3";
                        $m_plan = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=2";
                        $m_real = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=3";
                        $m_type1 = ManagementCost::model()->findAll($Criteria);

                        //find tax
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=2 AND mc_detail LIKE '%อากร%'";
                        $m_tax = ManagementCost::model()->findAll($Criteria);

                        //end

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0")
                                            ->queryAll();
                        $sum_m_expect += $pp[0]["sum"];


                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=3")
                                            ->queryAll();
                        $m_type1_sum = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type!=0")
                                            ->queryAll();
                        $m_real_sum = $pp[0]["sum"];

                        $sum_m_real += $m_real_sum;
                        $sum_m_type1 += $m_type1_sum;
                        //profit
                        //1.income
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('project_contract','proj_id=pc_id')
                                            ->where("pc_proj_id='$pj->pj_id'")
                                            ->queryAll();
                        //echo $pp[0]["sum"];
                        $income = $pp[0]["sum"];
                        
                        //1.outcome
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract','contract_id=oc_id')
                                            ->where("oc_proj_id='$pj->pj_id'")
                                            ->queryAll();                    
                        $outcome = $pp[0]["sum"];                    
                        $m_profit = $income - $outcome  - $m_real_sum;

                        $sum_profit += $m_profit;

                         //end
                         $pcCost = 0;
                         $ocCost = 0;
                         	
                                	
                            	$objPHPExcel->setActiveSheetIndex(0)
		            						->setCellValue('A'.$row, $index);
		            			$objPHPExcel->setActiveSheetIndex(0)
		            						->setCellValue('B'.$row, $pj->pj_name);	
		            			//workcode
		                			$Criteria = new CDbCriteria();
		                            $Criteria->condition = "pj_id='$pj->pj_id'";
		                			$workcodes = WorkCode::model()->findAll($Criteria);
		                			$row_i = $row;
		                			foreach ($workcodes as $key => $wc) {
		                				$row_i++;
		                				$objPHPExcel->setActiveSheetIndex(0)
		            						->setCellValue('B'.$row_i, $wc->code);	
		            			
		                			}

		                			

		                		// 	if(!empty($pj->pj_CA))
		                		// 	{
		                		// 		$row_i++;
		                		// 		$objPHPExcel->setActiveSheetIndex(0)
		            						// ->setCellValue('B'.$row_i, $pj->pj_CA);	
		            					
		                		// 	}
		            			
		            			//draw PC
		                			
		                		$k = 0;
		                		$row_max = $row;
                            	foreach ($pcs as $key => $pc) {
                            			if($k==0)
                            				$row_pc = $row;
                            			else
                            				$row_pc = $row_max;				
                            			$k++;
                            				
	                            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row_pc++, $pc->pc_details);
		                                if(!empty($pc->pc_guarantee))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row_pc++, "-หนังสือค้ำประกัน ".$pc->pc_guarantee);
		                                if(!empty($pc->pc_garantee_end))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row_pc++, "-เลขที่บันทึกส่งกองการเงิน ".$pc->pc_guarantee_end);
		                                
		                                if(!empty($pc->pc_PO))
		                                {
		                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row_pc++, "-".$pc->pc_PO);
		                               
		                                }	
		                                //อากร
			                			foreach ($m_tax as $key => $t) {
			                				
			                				$objPHPExcel->setActiveSheetIndex(0)
			            						->setCellValue('C'.$row_pc++, "-".$t->mc_detail." ".number_format($t->mc_cost,2)." บาท");	
			            			
			                			}
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row_max, $pc->pc_code);
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$row_max, $this->renderDate($pc->pc_sign_date));
										

										
		                               	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($row_max+2), "ครบกำหนด");
		                               	$cell_underline[] = 'E'.($row_max+2);
		                               	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.($row_max+3), $this->renderDate($pc->pc_end_date));

		                               	$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
		                				///print_r($changeHists);
                                        //echo $pp[0]["sum"];    

		                                $pcCost =$pc->pc_cost + $pp[0]["sum"];

		                                $sum_pc_cost += $pcCost;
		                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($row_max), number_format($pcCost,2));

		                                //draw Payment PC
			                            	$Criteria = new CDbCriteria();
			                                $Criteria->condition = "proj_id='$pc->pc_id'";
			                                $paymentProjs = PaymentProjectContract::model()->findAll($Criteria);
			                                $row_pay_pc = $row_max;
			                                foreach ($paymentProjs as $key =>$pay)
			                                {
			                                		
			                                		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.($row_pay_pc), $pay->detail);
			                                		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($row_pay_pc), $pay->money);

			                                    	//find pay before
			                                    	$str_date = explode("/", $pay->invoice_date);
			                                        $invoice_date= "";
			                                        if(count($str_date)>1)
			                                            $invoice_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
			                                        $pp = Yii::app()->db->createCommand()
			                                            ->select('SUM(money) as sum')
			                                            ->from('payment_project_contract')
			                                            ->where('invoice_date < "'.$invoice_date.'" AND proj_id='.$pc->pc_id)
			                                            ->queryAll();
			                                            
			                                        //print_r($pay->invoice_date);    
			                                        $pay->money = str_replace(",", "", $pay->money);
			                                        $sum_pc_receive += $pay->money;

			                                        $pc_remain = $pcCost - $pay->money - $pp[0]["sum"];
			                                        if($pc_remain!=0)
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($row_pay_pc), number_format($pc_remain,2));
			                                        else
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($row_pay_pc), "-");

			                                        if(!empty($pay->invoice_date))
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($row_pay_pc), $pay->invoice_no.'('.$this->renderDate($pay->invoice_date).")");
			                                        else
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($row_pay_pc), $pay->invoice_no);
			                                        if(!empty($pay->bill_date))
			                                           $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.($row_pay_pc), $pay->bill_no.'('.$this->renderDate($pay->bill_date).")");
			                                        else
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.($row_pay_pc), $pay->bill_no);
			                                        
			                                       
			                                        
			                                        $row_pay_pc++; 
			                                }

			                                      //cal %A
                                        //sum income;
                                        $data = Yii::app()->db->createCommand()
                                                            ->select('sum(money) as sum')
                                                            ->from('payment_project_contract')
                                                            ->where('proj_id=:id AND (bill_date!="" AND bill_date!="0000-00-00")', array(':id'=>$pc->pc_id))
                                                            ->queryAll();
                                                                                        
                                        $sum_income = $data[0]["sum"];

                                         $data = Yii::app()->db->createCommand()
                                                            ->select('sum(cost) as sum')
                                                            ->from('contract_change_history')
                                                            ->where('contract_id=:id  AND type=1', array(':id'=>$pc->pc_id))
                                                            ->queryAll();
                                                                                        
                                        $change = $data[0]["sum"];      

                                        // $data = Yii::app()->db->createCommand()
                                        //                  ->select('sum(money) as sum')
                                        //                  ->from('payment_outsource_contract')
                                        //                  ->where('contract_id=:id AND (approve_date!="" AND approve_date!="0000-00-00")', array(':id'=>$modelPC->pc_id))
                                        //                  ->queryAll();
                                                                                        
                                        // $sum_payment = $data[0]["sum"];  
                                        $cost = str_replace(",", "", $pc->pc_cost) + $change;
                                        $pc->pc_A_percent =number_format((1 - ($cost - $sum_income)/$cost)*100,2);//number_format(($cost - $sum_income)*100/$cost,2);


			                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.($row_max), $pc->pc_T_percent);
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.($row_max), $pc->pc_A_percent);
			                                        	$sum_pc_T += $pc->pc_T_percent;
			                                            $sum_pc_A += $pc->pc_A_percent;
			                            
		                               	$row_max = $objPHPExcel->getActiveSheet()->getHighestRow() + 2;	
		                               	if(count($pcs)>1) 
		                               	  $cell_pc_end[] = $row_max - 1;                              
		                            }    


                            	                               
                                	//draw OC
                                    $k = 0;
		                			$row_max = $row;
                            		foreach ($ocs as $key => $oc) {
                            			if($k==0)
                            				$row_oc = $row;
                            			else
                            				$row_oc = $row_max;				
                            			$k++;
                            				
                            			$vendor = vendor::model()->findByPk($oc->oc_vendor_id);
	                            		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.($row_max), $vendor->v_name);
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_max), $oc->oc_detail);
                                        
                                        $row_oc++;
		                                if(!empty($oc->oc_PO))
		                                {
		                                    $oc->oc_PO = str_replace("PO", "", $oc->oc_PO);
		                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_oc++), $oc->oc_PO);
                                        
		                                }
		                                if(!empty($oc->oc_letter))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_oc++), $oc->oc_letter);
                                        
		                                	//echo "-หนังสือสั่งจ้าง ".$oc->oc_letter."<br>";
		                                if(!empty($oc->oc_guarantee))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_oc++), $oc->oc_guarantee);
                                        
		                                	//echo "-หนังสือค้ำประกัน ".$oc->oc_guarantee."<br>";
		                                if(!empty($oc->oc_guarantee_cf))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_oc++), $oc->oc_guarantee_cf);
                                        
		                                	//echo "-หนังสือยืนยันค้ำประกัน ".$oc->oc_guarantee_cf."<br>";
		                                if(!empty($oc->oc_adv_guarantee))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_oc++), $oc->oc_adv_guarantee);
                                        
		                                	//echo "-หนังสือค้ำประกันล่วงหน้า ".$oc->oc_adv_guarantee."<br>";
		                                if(!empty($oc->oc_adv_guarantee_cf))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_oc++), $oc->oc_adv_guarantee_cf);
                                        
		                                	//echo "-หนังสือยืนยันค้ำประกันล่วงหน้า ".$oc->oc_adv_guarantee_cf."<br>";
		                                
		                                if(!empty($oc->oc_insurance))
		                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.($row_oc++), $oc->oc_insurance."(".$this->renderDate($oc->oc_insurance_start)."-".$this->renderDate($oc->oc_insurance_end).")");
                                        
		                                	//echo "-กรมธรรม์ประกันภัย ".$oc->oc_insurance."(".renderDate($oc->oc_insurance_start)."-".renderDate($oc->oc_insurance_end).")<br>";
		                                	
				                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row_max, $oc->oc_code);
										$objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$row_max, $this->renderDate($oc->oc_sign_date));
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$row_max, $this->renderDate($oc->oc_end_date));
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$row_max, $this->renderDate($oc->oc_approve_date));
                                                                                

		                                $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$oc->oc_id' AND type=2")
                                            ->queryAll();
		                				///print_r($changeHists);
                                        //echo $pp[0]["sum"];    
                                        $oc->oc_cost = str_replace(",", "", $oc->oc_cost);
		                                $ocCost =$oc->oc_cost + $pp[0]["sum"];

		                                $sum_oc_cost += $ocCost; 

		                                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$row_max, number_format($ocCost,2));
                                         
		                                //echo "<td rowspan='".$maxPayment."' style='text-align:right'>".number_format($ocCost,2)."</td>";

		                                //draw Payment OC
		                            	$Criteria = new CDbCriteria();
		                                $Criteria->condition = "contract_id='$oc->oc_id'";
		                                $paymentProjs = PaymentOutsourceContract::model()->findAll($Criteria);
		                                
		                                
		                                $row_pay_oc = $row_max;
		                                foreach ($paymentProjs as $key => $pay)
		                                {
		                                		
		                                		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.($row_pay_oc), $pay->detail);
			                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.($row_pay_oc), $pay->money);
			                                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.($row_pay_oc), $this->renderDate($pay->approve_date));

		                                    	//find pay before
		                                    	$str_date = explode("/", $pay->invoice_receive_date);
		                                        $invoice_date= "";
		                                        if(count($str_date)>1)
		                                            $invoice_date= $str_date[2]."-".$str_date[1]."-".$str_date[0];
		                                        $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_outsource_contract')
		                                            ->where('invoice_receive_date < "'.$invoice_date.'" AND contract_id='.$oc->oc_id)
		                                            ->queryAll();
		                                            
		                                        //print_r($pp);    
		                                        $pay->money = str_replace(",", "", $pay->money);
		                                        $sum_oc_receive += $pay->money;
		                                        $oc_remain = $ocCost - $pay->money - $pp[0]["sum"];

		                                        if($oc_remain!=0)
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.($row_pay_oc), number_format($oc_remain,2));
			                                        else
			                                        	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.($row_pay_oc), "-");

			                                    $row_pay_oc++;    

		                                } 
		                                //echo "row".$row_pay_oc;
		                                   //cal %A
                                                        //sum income;
                                                        

                                                         $data = Yii::app()->db->createCommand()
                                                                            ->select('sum(cost) as sum')
                                                                            ->from('contract_change_history')
                                                                            ->where('contract_id=:id  AND type=2', array(':id'=>$oc->oc_id))
                                                                            ->queryAll();
                                                                                                        
                                                        $change = $data[0]["sum"];      

                                                        $data = Yii::app()->db->createCommand()
                                                                         ->select('sum(money) as sum')
                                                                         ->from('payment_outsource_contract')
                                                                         ->where('contract_id=:id AND (approve_date!="" AND approve_date!="0000-00-00")', array(':id'=>$oc->oc_id))
                                                                         ->queryAll();
                                                                                                        
                                                        $sum_payment = $data[0]["sum"];  
                                                        $cost = str_replace(",", "", $oc->oc_cost) + $change;
                                                        $oc->oc_A_percent =number_format((1 - ($cost - $sum_payment)/$cost)*100,2);//number_format(($cost - $sum_income)*100/$cost,2);

		                                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.($row_max), $oc->oc_T_percent);
			                             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.($row_max), $oc->oc_A_percent);
			                             $sum_oc_T += $oc->oc_T_percent;
			                             $sum_oc_A += $oc->oc_A_percent;       

		                                $row_max = $objPHPExcel->getActiveSheet()->getHighestRow() + 2;	 
		                               	if(count($ocs)>1)
		                               	$cell_oc_end[] = $row_max - 1;

				                	}
                            	
                            	//management cost
                                $row_ma = $row;
                                foreach ($m_plan as $key => $m) {
                                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.($row_ma++), number_format($m->mc_cost,2));
			                
                                }

                                $row_ma = $row;
                                foreach ($m_type1 as $key => $m) {
                                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.($row_ma++), number_format($m->mc_cost,2));
			                
                                }
                                $row_ma = $row;
                                foreach ($m_real as $key => $m) {
                                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.($row_ma++), number_format($m->mc_cost,2));
			                
                                }	
                                 
                                if($m_profit!=0)
									$objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.($row), number_format($m_profit,2));
			                	

                                $row_i = $objPHPExcel->getActiveSheet()->getHighestRow()+2;
                                //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row_i, "end");
                                
		            			$objPHPExcel->getActiveSheet()->setSharedStyle($normal, "A".$row.":AD".$row_i);					
                				$objPHPExcel->getActiveSheet()->setSharedStyle($end_project, "A".($row_i-1).":AD".($row_i));

                				$objPHPExcel->getActiveSheet()->getStyle("D".$row.':E'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                				$objPHPExcel->getActiveSheet()->getStyle("J".$row.':M'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                				$objPHPExcel->getActiveSheet()->getStyle("P".$row.':S'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                				$objPHPExcel->getActiveSheet()->getStyle("W".$row.':W'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                				$objPHPExcel->getActiveSheet()->getStyle("Y".$row.':Z'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
							    
                				//money format
                				
                				$objPHPExcel->getActiveSheet()->getStyle("F".$row.':F'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                            	$objPHPExcel->getActiveSheet()->getStyle("H".$row.':I'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->getStyle("T".$row.':T'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								
								$objPHPExcel->getActiveSheet()->getStyle("V".$row.':V'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
								$objPHPExcel->getActiveSheet()->getStyle("X".$row.':X'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);		
								$objPHPExcel->getActiveSheet()->getStyle("AA".$row.':AD'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
																

								foreach ($cell_pc_end as $key => $value) {
									$objPHPExcel->getActiveSheet()->setSharedStyle($end_project, "C".$value.":M".$value);
							   
								}
								foreach ($cell_oc_end as $key => $value) {
									$objPHPExcel->getActiveSheet()->setSharedStyle($end_project, "N".$value.":AD".$value);
							   
								}
							    $row = $row_i;   
								$index++;
                	  }
                	}  

                	//summary
                	 $sumall_pc_cost += $sum_pc_cost;
                     $sumall_pc_receive += $sum_pc_receive;
                     $sumall_oc_cost += $sum_oc_cost;
                     $sumall_oc_receive += $sum_oc_receive;

                     $sumall_m_real += $sum_m_real;
                     $sumall_m_type1 += $sum_m_type1;
                     $sumall_m_expect += $sum_m_expect;
                     $sumall_profit += $sum_profit;

                	 $row_i = $objPHPExcel->getActiveSheet()->getHighestRow();
                	 $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row_i.':B'.$row_i);
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($row_i), "รวมเป็นจำนวนเงิน");
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($row_i), number_format($sum_pc_cost,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($row_i), number_format($sum_pc_receive,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($row_i), number_format($sum_pc_cost - $sum_pc_receive,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.($row_i), number_format($sum_oc_cost,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.($row_i), number_format($sum_oc_receive,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.($row_i), number_format($sum_oc_cost - $sum_oc_receive,2));
 
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.($row_i), number_format($sum_m_expect,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.($row_i), number_format($sum_m_type1,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.($row_i), number_format($sum_m_real,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.($row_i), number_format($sum_profit,2));
                	 $objPHPExcel->getActiveSheet()->setSharedStyle($sum, "A".($row_i).":AD".($row_i));
					 $objPHPExcel->getActiveSheet()->getStyle("A".$row_i.':B'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					 $objPHPExcel->getActiveSheet()->getStyle("C".$row_i.':AD'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			 		 $row++;	
			                	
		      	}	

		      	$row_i = $objPHPExcel->getActiveSheet()->getHighestRow() + 1;
                	 $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row_i.':B'.$row_i);
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.($row_i), "รวมเป็นจำนวนเงินทั้งหมด");
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.($row_i), number_format($sumall_pc_cost,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.($row_i), number_format($sumall_pc_receive,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.($row_i), number_format($sumall_pc_cost - $sumall_pc_receive,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.($row_i), number_format($sumall_oc_cost,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.($row_i), number_format($sumall_oc_receive,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.($row_i), number_format($sumall_oc_cost - $sumall_oc_receive,2));
 
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.($row_i), number_format($sumall_m_expect,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.($row_i), number_format($sumall_m_type1,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.($row_i), number_format($sumall_m_real,2));
                	 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.($row_i), number_format($sumall_profit,2));
                	 $objPHPExcel->getActiveSheet()->setSharedStyle($sum, "A".($row_i).":AD".($row_i));
					 $objPHPExcel->getActiveSheet()->getStyle("A".$row_i.':B'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					 $objPHPExcel->getActiveSheet()->getStyle("C".$row_i.':AD'.$row_i)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			 		 
		   
		      	$styleArray = array(
										  'font' => array(
										    'underline' => PHPExcel_Style_Font::UNDERLINE_SINGLE
										  )
							);
		      	foreach ($cell_underline as $key => $value) {
		      		$objPHPExcel->getActiveSheet()->getStyle($value)->applyFromArray($styleArray);
		          
		      	}
		      	                      	
		      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
		    $objPHPExcel->setActiveSheetIndex(0);
		  	 
			$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);


		  //?????important clear cabage
		ob_end_clean();
		ob_start();

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="progress_report.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');  //
		 Yii::app()->end(); 
        
    }

    


    public function actionGenSummary()
    {
        
    	
    	// if(isset($_GET["project"]) && !empty($_GET["project"])) 
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
    	// else
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
    	$model = Project::model()->findByPk($_GET["project"]);
        $this->renderPartial('_formSummary', array(
            'model' => $model,
            'display' => 'block',
        ), false, true);

        
    }

    public function actionPrintSummary()
    {
        
    	
    	// if(isset($_GET["project"]) && !empty($_GET["project"])) 
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
    	// else
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
    	$model = Project::model()->findByPk($_GET["project"]);
        $this->render('_formSummaryPDF', array(
            'model' => $model,
            
        ));

        
    }

    public function actionPrintCashflow()
    {
        
    	
     //    if(isset($_GET["project"]) && !empty($_GET["project"]))    		
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
    	// 	$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	

    	$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    	}
    	$monthBegin = 0;///$_GET["monthBegin"];
    	$monthEnd = $_GET["monthEnd"];
    	$yearBegin = 0;//$_GET["yearBegin"];
    	$yearEnd = $_GET["yearEnd"];

    	// header('Content-type: text/plain');
     //       echo($_GET["fiscalyear"]);                    
     //    exit;

        $this->renderPartial('_formCashflowPDF', array(
            'model' => $model,'monthBegin'=>$monthBegin,'monthEnd'=>$monthEnd,'yearBegin'=>$yearBegin,'yearEnd'=>$yearEnd,
            'display' => 'block',
        ));

        
    }

    public function actionPrintSummaryCashflow()
    {
        
    	
    	//  if(isset($_GET["project"]) && !empty($_GET["project"]))    		
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
    	// 	$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
    	
    	$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    	}
        $this->render('_formSummaryCashflowPDF', array(
            'model' => $model,'fiscalyear'=>$_GET["fiscalyear"]
            
        ));

        
    }

    public function actionPrintProgress()
    {
        
    	
    	$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    	}
        $this->render('_formProgressPDF', array(
            'model' => $model
            
        ));

        
    }

    public function actionGenCashflowExcel()
    {
			

    	// if(isset($_GET["project"]) && !empty($_GET["project"]))    		
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
    	// 	$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	

    	$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    }

    	$monthBegin = 0;//$_GET["monthBegin"];
    	$monthEnd = $_GET["monthEnd"];
    	$yearBegin = 0;//$_GET["yearBegin"];
    	$yearEnd = $_GET["yearEnd"];
	
		Yii::import('ext.phpexcel.XPHPExcel');    
		$objPHPExcel= XPHPExcel::createPHPExcel();
		//$objReader = PHPExcel_IOFactory::createReader('Excel5');
        //$objPHPExcel = $objReader->load("report/templateSummaryCashflow.xls");

        $header = new PHPExcel_Style();
		$header->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 18,   
			            'bold'  => true,           
			            'color' => array(
			            	'rgb'   => '000000'
			            	)
			       		)
			    	)  
			  ); 
		$tableHead = new PHPExcel_Style();
	    $tableHead->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			             'bold'  => true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'FA9D8E')
			        ),
			            'borders' => array(
			            	'top'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

		$tableHeadOne = new PHPExcel_Style();
	    $tableHeadOne->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			             'bold'  => true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'FA9D8E')
			        ),
			         'borders' => array(
			            	'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_DOTTED ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

		$cashsum = new PHPExcel_Style();
	    $cashsum->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			                          
			            'color' => array(
			            'rgb'   => 'ff0000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'FA9D8E')
			        ),
			            'borders' => array(
			            	'top'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_DOUBLE ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

		$normal = new PHPExcel_Style();
	    $normal->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			                          
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'FA9D8E')
			        ),
			            'borders' => array(
			            	'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_DOTTED ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

		$end = new PHPExcel_Style();
	    $end->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			                          
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'FA9D8E')
			        ),
			            'borders' => array(
			            	'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));
		

		
		$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

		$monthBetween = $month_th[$monthEnd]." ".$yearEnd;


		$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
		$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;

		$number = $number<10 ? "0".$number : $number;
		$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
		$monthCondition = " <= '".$dayEnd."'";

		$sheet = 0;
		$sumPayPCAll = 0;
		$sumPayOCAll = 0;
		foreach ($model as $key => $pj) {
			    $objPHPExcel->createSheet($sheet);
			    //$objPHPExcel->setActiveSheetIndex($sheet)->setTitle("PJ".($sheet+1));
				$pjname = str_replace("บริษัท", "", $pj->pj_name);
				//$pjname = explode(" ", $pjname);

				$pj_sheetname = iconv_substr($pjname, 0,30, "UTF-8");;
				//echo $pj_sheetname."<br>"; 
					 ///header('Content-type: text/plain');
            //echo($pj_sheetname);                    
         //exit;
				$objPHPExcel->setActiveSheetIndex($sheet)->setTitle($pj_sheetname);
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('A')->setWidth(15);
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('B')->setWidth(20);	
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('C')->setWidth(25);	
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('D')->setWidth(15);	
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('E')->setWidth(20);	
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('F')->setWidth(25);		   	      

				$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells("A1:F1");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A1', "สรุปรายได้/ค่าใช้จ่าย");
				$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A2:F2');
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A2', $pj->pj_name);
				$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A3:F3');
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A3', "ประจำเดือน ".$monthBetween);
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($header, 'A1:F3');
				$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A1:F3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				//table header
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A4', "วดป.\nใบเสร็จรับเงิน");
				$objPHPExcel->getActiveSheet()->getStyle('A4')->getAlignment()->setWrapText(true);
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B4', "รายการ");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C4', "จำนวนเงิน");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D4', "วดป.\nอนุมัติรับเงิน");
				$objPHPExcel->getActiveSheet()->getStyle('D4')->getAlignment()->setWrapText(true);
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E4', "รายการ");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F4', "รายจ่าย");
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($tableHead, 'A4:F4');
				$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A4:F4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

			
				$row = 5;
				//project contract
	    		$Criteria = new CDbCriteria();
	            $Criteria->condition = "pc_proj_id='$pj->pj_id'";
	            $pcs = ProjectContract::model()->findAll($Criteria);
	            $rowPCname = array();
	            $rowPCnameOC = array();
	            $rowPCnameOne = array();
	            $rowRemain = array();
	            $rowRemainOC = array();
	            $rowMaxPC = 0;
	            $sumPayPCAll = 0;
	            if(count($pcs)==1)
	            {
	            	$sumPayPC = 0;
	            	$rowPCnameOne[] = $row;
	            	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$row, "วงเงินสัญญา");
	            	$pc = $pcs[0];
	            	$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll();
                    $costPC = $pp[0]["sum"] + $pc->pc_cost;                      

	            	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row, number_format($costPC,2));	
	           		$rowPC = $row;
	           		$rowPC++;
		            	//pc payment
		            	$Criteria = new CDbCriteria();
                		$Criteria->condition = "proj_id='$pc->pc_id' AND bill_date!='' AND bill_date ".$monthCondition;
                		$payment = PaymentProjectContract::model()->findAll($Criteria);

                		foreach ($payment as $key => $pay) {
                			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$rowPC,$this->renderDate($pay->bill_date));
                			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$rowPC,$pay->detail);
	            			$money = str_replace(",", "", $pay->money);
		        			$sumPayPC += $money;
		        			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$rowPC,number_format($money,2));
	            			$rowPC++;
                		}

                		
 						$rowPC++;
 						$rowPC += 2;
                	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$rowPC,"คงเหลือค้างรับ");

                	$rowRemain[] = $rowPC;
                	$rm = $costPC-$sumPayPC==0 ? "-": number_format($costPC-$sumPayPC,2);
		        	$sumPayPCAll += $sumPayPC;
		        	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$rowPC,$rm);
		        	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($normal, 'A'.$row.":C".$rowPC);
		        	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'C'.$rowPC);
 						    
	            }
	            else{
	            	$rowPC = $row;
	            	
	            	$iPC = 0;
	            	foreach ($pcs as $key => $pc) {
	            		$rowPCname[] = $rowPC;
	            		$sumPayPC = 0;
	            		$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells("A".$rowPC.":B".$rowPC);
	            		$vendor = Vendor::model()->findByPk($pc->pc_vendor_id);
	            		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$rowPC,$vendor->v_name);
		            
		            	$pp = Yii::app()->db->createCommand()
	                                            ->select('SUM(cost) as sum')
	                                            ->from('contract_change_history')
	                                            ->where("contract_id='$pc->pc_id' AND type=1")
	                                            ->queryAll();
	                    $costPC = $pp[0]["sum"] + $pc->pc_cost;                      

		            	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$rowPC, number_format($costPC,2));	
	            		$rowPC++;
		            	//pc payment
		            	$Criteria = new CDbCriteria();
                		$Criteria->condition = "proj_id='$pc->pc_id' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date ".$monthCondition;
                		$payment = PaymentProjectContract::model()->findAll($Criteria);

                		foreach ($payment as $key => $pay) {
                			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$rowPC,$this->renderDate($pay->bill_date));
                			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$rowPC,$pay->detail);
	            			$money = str_replace(",", "", $pay->money);
		        			$sumPayPC += $money;
		        			$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$rowPC,number_format($money,2));
	            			$rowPC++;
                		}
                		$iPC ++;

                		$rowPC += 2;
                		$rowRemain[] = $rowPC;
                	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$rowPC,"คงเหลือค้างรับ");
                	$rm = $costPC-$sumPayPC==0 ? "-": number_format($costPC-$sumPayPC,2);
		        	$sumPayPCAll += $sumPayPC;
		        	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$rowPC,$rm);
		        	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($normal, 'A'.$row.":C".$rowPC);
		        	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'C'.$rowPC);
	
 						$rowPC += 2;	               			
                		
	            	}

	            	

		        	$rowPC += 2;
 						
	            }

	            


	            //outsource
	            $rowOC = 5;
	            $Criteria = new CDbCriteria();
                $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                $ocs = OutsourceContract::model()->findAll($Criteria);
                $sumPayOCAll = 0;
                foreach ($ocs as $key => $oc) {
                	$sumPayOC = 0;
                	$vendor = Vendor::model()->findByPk($oc->oc_vendor_id);
                	$pp = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$oc->oc_id' AND type=2")
                                            ->queryAll();
                    $costOC = $pp[0]["sum"] + str_replace(",", "", $oc->oc_cost); 

                	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$rowOC,$vendor->v_name);
                	$rowPCnameOC[] = $rowOC;
                	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$rowOC,number_format($costOC,2));
                	$rowOC++;

                	//payment
                	$Criteria = new CDbCriteria();
                	$Criteria->condition = "contract_id='$oc->oc_id' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date ".$monthCondition;
                	$paymentOC = PaymentOutsourceContract::model()->findAll($Criteria);
                	foreach ($paymentOC as $key => $pay) {
                		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$rowOC,$this->renderDate($pay->approve_date));
                		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$rowOC,$pay->detail);
                		$money = str_replace(",", "", $pay->money);
		        		$sumPayOC += $money;
		        		$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$rowOC,number_format($money,2));
                		
                		$rowOC++;


                	}

                	
                	$rowOC += 2;
	                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$rowOC,"ค้างจ่าย");
	                $rowRemainOC[] = $rowOC;
	                	$rm = $costOC-$sumPayOC==0 ? "-": number_format($costOC-$sumPayOC,2);
			        	$sumPayOCAll += $sumPayOC;
			        	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$rowOC,$rm);
			        	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($normal, 'D'.$row.":F".$rowOC);
			        	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'F'.$rowOC);


                	$rowOC+=2;
                }
                $row = $objPHPExcel->getActiveSheet()->getHighestRow()+2;

                $row_max = $objPHPExcel->getActiveSheet()->getHighestRow()+5;
                $rowN = count($rowRemain)>0 ? count($rowRemain)-1:count($rowRemain);
                $rowNOC = count($rowRemainOC)>0 ? count($rowRemainOC)-1:count($rowRemainOC);
                $rowMaxPC = count($rowRemain)<0 ? 5 : $rowRemain[$rowN];
                
                $rowMaxOC = empty($rowRemainOC) ? 5 :  $rowRemainOC[$rowNOC];


                //summary
                
                $pay_pc = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum,YEAR(bill_date) as year')
                                            ->from('payment_project_contract')
                                            ->join('project_contract p', 'proj_id=p.pc_id')
                                            ->where("p.pc_proj_id='$pj->pj_id' AND bill_date!='' AND YEAR(bill_date)!=0 AND bill_date ".$monthCondition)
                                            ->group("YEAR(bill_date)")
                                            ->queryAll();

                 $pay_oc = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum,YEAR(approve_date) as year')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract o', 'contract_id=o.oc_id')
                                            ->where("o.oc_proj_id='$pj->pj_id' AND approve_date!='' AND YEAR(approve_date)!=0 AND approve_date ".$monthCondition)
                                            ->group("YEAR(approve_date)")
                                            ->queryAll();                            
                $rowSum = $row;
                $max = count($pay_pc) < count($pay_oc) ? count($pay_oc): count($pay_pc);
        		for ($i=0; $i < $max; $i++) { 
        			if(!empty($pay_pc[$i]))
	                {
	                	if($pay_pc[$i]["year"]==$yearEnd)
	                      $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$row,'รวมรายรับ ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd);
	               		else
	               		  $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$row,'รวมรายรับ ณ เดือน ธันวาคม '.$pay_pc[$i]["year"]);	
	                
	                	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($pay_pc[$i]["sum"],2));
	                }
	           
	                
	                if(!empty($pay_oc[$i]))
	                {
	                	if($pay_oc[$i]["year"]==$yearEnd)
	                      $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,'รวมรายรับ ณ เดือน '.$month_th[$monthEnd].' '.$yearEnd);
	               		else
	               		  $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,'รวมรายรับ ณ เดือน ธันวาคม '.$pay_oc[$i]["year"]);	
	                
	                	$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$row,number_format($pay_oc[$i]["sum"],2));
	                }
	               
	                $row++;
                }
                //management
                $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=2 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum1 = $pp[0]["sum"];
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=1 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum2 = $pp[0]["sum"];
                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=3 AND mc_date ".$monthCondition)
                                            ->queryAll();
                        $m_sum3 = $pp[0]["sum"];


                         $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost) as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=1")
                                            ->queryAll();
                        $m_plan1 = $pp[0]["mc_cost"];

                        $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost)  as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=2")
                                            ->queryAll();
                        $m_plan2 = $pp[0]["mc_cost"];

                        $pp = Yii::app()->db->createCommand()
                                            ->select('sum(mc_cost)  as mc_cost')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0 AND mc_in_project=3")
                                            ->queryAll();
                        $m_plan3 = $pp[0]["mc_cost"];
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,'ค่าบริหารโครงการ ('.number_format($m_plan1,2).')');
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$row,number_format($m_sum1,2));
                $row++;
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,'ค่ารับรอง ('.number_format($m_plan2,2).')');
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$row,number_format($m_sum2,2));
                $row++;
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,'ค่าบุคลากร ('.number_format($m_plan3,2).')');
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$row,number_format($m_sum3,2));
                $row++;
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,'กำไร/ขาดทุน');
                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('F'.$row,number_format($sumPayPCAll-$sumPayOCAll-$m_sum1-$m_sum2-$m_sum3,2));


                
                $objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($normal, 'A'.$rowMaxPC.":C".$row_max);                
			    $objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($normal, 'D'.$rowMaxOC.":F".$row_max); 	
			    $objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($end, 'A'.$row_max.":F".$row_max);


			    $objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($tableHeadOne, 'A'.$rowSum.':F'.$row);
 				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'F'.$row);

                foreach ($rowPCname as $key => $r) {
	            	//set style projectname
					$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($tableHeadOne, 'A'.$r.':C'.$r);

	            }
	            foreach ($rowPCnameOne as $key => $r) {
	            	//set style projectname
					$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($tableHeadOne, 'A'.$r.':C'.$r);

	            }
                foreach ($rowRemain as $key => $row) {
                	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'C'.$row);
                }
                foreach ($rowRemainOC as $key => $row) {
                	$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'F'.$row);
                }
                foreach ($rowPCnameOC as $key => $r) {
	            	//set style projectname
					$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($tableHeadOne, 'D'.$r.':F'.$r);

	            }


	            $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('C5:C256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	            $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('F5:F256')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

			$sheet++;	
		}	

		///header('Content-type: text/plain');
         //   echo($pj_sheetname);                    
         //exit;
		ob_end_clean();
		ob_start();

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="cashflow_report.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
        
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');  //
		Yii::app()->end(); 
    }       


    public function actionGenStatementExcel()
    {
			

    	$monthBegin = $_GET["monthBegin"];
    	$monthEnd = $_GET["monthEnd"];
    	$yearBegin = $_GET["yearBegin"];
    	$yearEnd = $_GET["yearEnd"];
	
		Yii::import('ext.phpexcel.XPHPExcel');    
		$objPHPExcel= XPHPExcel::createPHPExcel();

        $header = new PHPExcel_Style();
		$header->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 18,   
			            'bold'  => true,           
			            'color' => array(
			            	'rgb'   => '000000'
			            	)
			       		)
			    	)  
			  ); 
		$tableHead = new PHPExcel_Style();
	    $tableHead->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			             'bold'  => true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            
			    ));

		$tableHeadOne = new PHPExcel_Style();
	    $tableHeadOne->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			             'bold'  => true,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'FA9D8E')
			        ),
			         'borders' => array(
			            	'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_DOTTED ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

		$cashsum = new PHPExcel_Style();
	    $cashsum->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			                          
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			         
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
			        	)
			    ));

	    $cashsumAll = new PHPExcel_Style();
	    $cashsumAll->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			                          
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			         
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_DOUBLE ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
			        	)
			    ));


		$normal = new PHPExcel_Style();
	    $normal->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 16,   
			                          
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			    ));
		

		
		$month_th = array("1" => "มกราคม", "2" => "กุมภาพันธ์", "3" => "มีนาคม","4" => "เมษายน", "5" => "พฤษภาคม", "6" => "มิถุนายน","7" => "กรกฎาคม", "8" => "สิงหาคม", "9" => "กันยายน","10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");

		if($monthBegin==$monthEnd && $yearBegin==$yearEnd)
		    $monthBetween = $month_th[$monthBegin]." ".$yearBegin;
		else if($yearBegin==$yearEnd)
			$monthBetween = $month_th[$monthBegin]."-".$month_th[$monthEnd]." ".$yearEnd;
		else
		    $monthBetween = $month_th[$monthBegin]." ".$yearBegin."-".$month_th[$monthEnd]." ".$yearEnd;

		$number = cal_days_in_month(CAL_GREGORIAN, $monthEnd, $yearEnd-543);
		$monthBegin2 = $monthBegin<10 ? "0".$monthBegin : $monthBegin;
		$monthEnd2 = $monthEnd<10 ? "0".$monthEnd : $monthEnd;
		$dayBegin = $yearBegin."-".$monthBegin2."-"."01";

		$number = $number<10 ? "0".$number : $number;
		$dayEnd = $yearEnd."-".$monthEnd2."-".$number;
		$monthCondition = " BETWEEN '".$dayBegin."' AND '".$dayEnd."'";
			    

				$sheet = 0;
			    $objPHPExcel->createSheet(0);
				$objPHPExcel->setActiveSheetIndex($sheet)->setTitle("งบกำไรขาดทุน");
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('A')->setWidth(10);
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('B')->setWidth(50);	
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('C')->setWidth(20);	
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('D')->setWidth(20);	
				$objPHPExcel->setActiveSheetIndex($sheet)->getColumnDimension('E')->setWidth(20);	
						   	      

				$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells("A1:E1");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A1', "ฝ่ายบริการวิศวกรรม การไฟฟ้าส่วนภูมิภาค");
				$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A2:E2');
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A2', "งบกำไรขาดทุน");
				$objPHPExcel->setActiveSheetIndex($sheet)->mergeCells('A3:E3');
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A3', "ประจำเดือน ".$monthBetween);
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($header, 'A1:E3');
				$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('A1:E3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				//table header
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D4', "จำนวนเงิน (บาท)");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E4', "หมายเหตุ");

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A5', "รายได้ :");

				$row = 6;
				 //tsd กองบริการวิศวกรรมระบบส่ง
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_project_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id='0' AND bill_date!='' AND bill_date ".$monthCondition)
		                                            ->queryAll();
		         $tsd_sum = $pp[0]["sum"];
				
				 //msd กองบริการบำรุงรักษา
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_project_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id='1' AND bill_date!='' AND bill_date ".$monthCondition)
		                                            ->queryAll();
		         $msd_sum = $pp[0]["sum"];

		         //dsd กองบริการวิศวกรรมระบบจำหน่าย
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_project_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id='2' AND bill_date!='' AND bill_date ".$monthCondition)
		                                            ->queryAll();
		         $dsd_sum = $pp[0]["sum"];

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"รายได้จากกองบริการวิศวกรรมระบบส่ง");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($tsd_sum,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"1");
				$row++;


				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"รายได้จากกองบริการบำรุงรักษา");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($msd_sum,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"2");
				$row++;

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"รายได้จากกองบริการวิศวกรรมระบบจำหน่าย");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($dsd_sum,2));
				$income = $dsd_sum+$tsd_sum+$msd_sum;
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,number_format($income,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'D'.$row);
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"3");
				$row++;

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$row, "หักค่าใช้จ่าย :");
				$row++;

				 //tsd กองบริการวิศวกรรมระบบส่ง
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_outsource_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id='0' AND approve_date!='' AND approve_date ".$monthCondition)
		                                            ->queryAll();
		         $tsd_sum = $pp[0]["sum"];
				
				 //msd กองบริการบำรุงรักษา
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_outsource_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id='1' AND approve_date!='' AND approve_date ".$monthCondition)
		                                            ->queryAll();
		         $msd_sum = $pp[0]["sum"];

		         //dsd กองบริการวิศวกรรมระบบจำหน่าย
				 $pp = Yii::app()->db->createCommand()
		                                            ->select('SUM(money) as sum')
		                                            ->from('payment_outsource_contract')
		                                            ->join('user','user_create=u_id')
		                                            ->where("department_id='2' AND approve_date!='' AND approve_date ".$monthCondition)
		                                            ->queryAll();
		         $dsd_sum = $pp[0]["sum"];
				
				

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าจ้างเหมา-กองบริการวิศวกรรมระบบส่ง");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($tsd_sum,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"1");
				$row++;


				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าจ้างเหมา-กองบริการบำรุงรักษา");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($msd_sum,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"2");
				$row++;

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าจ้างเหมา-กองบริการวิศวกรรมระบบจำหน่าย");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($dsd_sum,2));
				
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"3");
				$row++;
				


		  				// $pp = Yii::app()->db->createCommand()
        //                                     ->select('SUM(mc_cost) as sum')
        //                                     ->from('management_cost')
        //                                     ->join('user','mc_user_update=u_id')
        //                                     ->where("department_id='0' AND mc_type=1 AND mc_date ".$monthCondition)
        //                                     ->queryAll();
        //                 $m_type1_tsd = $pp[0]["sum"];                    

        //                 $pp = Yii::app()->db->createCommand()
        //                                     ->select('SUM(mc_cost) as sum')
        //                                     ->from('management_cost')
        //                                     ->join('user','mc_user_update=u_id')
        //                                     ->where("department_id='0' AND mc_type=2 AND mc_date ".$monthCondition)
        //                                     ->queryAll();
                      
        //                 $m_real_tsd = $pp[0]["sum"];
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='0' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_tsd = $pp[0]["sum"];
                        
                        $m_tsd = $m_real_tsd;// + $m_type1_tsd;

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='1' AND mc_type=1 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                        // $m_type1_msd = $pp[0]["sum"];                    

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='1' AND mc_type=2 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                      
                        // $m_real_msd = $pp[0]["sum"];
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='1' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_msd = $pp[0]["sum"];

                        $m_msd = $m_real_msd;// + $m_type1_msd;

                        // $pp = Yii::app()->db->createCommand()
                        //                     ->select('SUM(mc_cost) as sum')
                        //                     ->from('management_cost')
                        //                     ->join('user','mc_user_update=u_id')
                        //                     ->where("department_id='2' AND mc_type=1 AND mc_date ".$monthCondition)
                        //                     ->queryAll();
                        // $m_type1_dsd = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->join('user','mc_user_update=u_id')
                                            ->where("department_id='2' AND mc_type!=0 AND mc_date ".$monthCondition)
                                            ->queryAll();
                      
                        $m_real_dsd = $pp[0]["sum"];
                        $m_dsd = $m_real_dsd;// + $m_type1_dsd;

	                 $tsd_sap = 0;
	          $msd_sap = 0;
	          $dsd_sap = 0;

	          $pp = Yii::app()->db->createCommand()
	                                            ->select('cost')
	                                            ->from('management_cost_sap')
	                                            ->where("department_id=0 AND year=".$yearEnd)
	                                            ->queryAll();
	         
	          if(count($pp)>0)
	             $tsd_sap = $pp[0]["cost"];
	          
	          $pp = Yii::app()->db->createCommand()
	                                            ->select('cost')
	                                            ->from('management_cost_sap')
	                                            ->where("department_id=1 AND year=".$yearEnd)
	                                            ->queryAll();
	          if(count($pp)>0)
	             $msd_sap = $pp[0]["cost"];
	          
	          $pp = Yii::app()->db->createCommand()
	                                            ->select('cost')
	                                            ->from('management_cost_sap')
	                                            ->where("department_id=2 AND year=".$yearEnd)
	                                            ->queryAll();
	          if(count($pp)>0)
	             $dsd_sap = $pp[0]["cost"];   
	             
	                  $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าใช้จ่ายในการดำเนินงาน-กองบริการวิศวกรรมระบบส่ง");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($m_tsd,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"1");
				$row++;


				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าใช้จ่ายในการดำเนินงาน-กองบริการบำรุงรักษา");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($m_msd,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"2");
				$row++;

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าใช้จ่ายในการดำเนินงาน-กองบริการวิศวกรรมระบบจำหน่าย");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($m_dsd,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"3");
				$row++;     

                $objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าใช้จ่ายในการบริหารงาน-กองบริการวิศวกรรมระบบส่ง");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($tsd_sap,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"1");
				$row++;


				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าใช้จ่ายในการบริหารงาน-กองบริการบำรุงรักษา");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($msd_sap,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"2");
				$row++;

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('B'.$row,"ค่าใช้จ่ายในการบริหารงาน-กองบริการวิศวกรรมระบบจำหน่าย");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('C'.$row,number_format($dsd_sap,2));
				 $outcome = $dsd_sap+$tsd_sap+$msd_sap+$dsd_sum+$tsd_sum+$msd_sum+$m_tsd+$m_msd+$m_dsd;
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,number_format($outcome,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsum, 'D'.$row);
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('E'.$row,"3");
				$row++;
        

				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('A'.$row, "กำไรสุทธิ :");
				$objPHPExcel->setActiveSheetIndex($sheet)->setCellValue('D'.$row,"=D8-D".($row-1).")");//number_format($income - $outcome,2));
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($cashsumAll, 'D'.$row);
				//$row++;

				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($tableHead, 'A4:E5');
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($tableHead, 'A4:A10');
				
				$objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($normal, 'B6:C20');
				$objPHPExcel->setActiveSheetIndex($sheet)->getStyle('B4:E5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

				
	            $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('C4:D20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	            $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('D'.$row)->getNumberFormat()->setFormatCode('#,##0.00'); 
				
	            
	            $objPHPExcel->setActiveSheetIndex($sheet)->setSharedStyle($normal, 'E6:E20');
	            $objPHPExcel->setActiveSheetIndex($sheet)->getStyle('E6:E20')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		///header('Content-type: text/plain');
         //   echo($pj_sheetname);                    
         //exit;
		ob_end_clean();
		ob_start();

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="statement_report.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
        
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');  //
		Yii::app()->end(); 
    }       

    public function actionGenSummaryCashflowExcel()
    {
			

    	// if(isset($_GET["project"]) && !empty($_GET["project"]))    		
    	//    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
    	// 	$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
    	// else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
    	// else
    	//     $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	

		$user_dept = Yii::app()->user->userdept;
        if(!Yii::app()->user->isExecutive())
		{

			if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"].' AND user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)','join'=>'LEFT JOIN user ON pj_user_create=user.u_id LEFT JOIN work_category ON wc_id=pj_work_cat', 'condition'=>'user.department_id='.$user_dept.' AND work_category.department_id='.$user_dept, 'params'=>array()));	
	    

		}
		else
		{	
	    	if(isset($_GET["project"]) && !empty($_GET["project"]))    		
	    	   $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_id='.$_GET["project"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && empty($_GET["fiscalyear"]))   
	    		$model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"], 'params'=>array()));	
	    	else if(isset($_GET["workcat"]) && !empty($_GET["workcat"]) && isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_work_cat='.$_GET["workcat"].' AND pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else if(isset($_GET["fiscalyear"]) && !empty($_GET["fiscalyear"]))  
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'pj_fiscalyear='.$_GET["fiscalyear"], 'params'=>array()));	 	
	    	else
	    	    $model = Project::model()->findAll(array('order'=>'CONCAT(pj_fiscalyear,pj_work_cat)', 'condition'=>'', 'params'=>array()));	
	    }	
		   Yii::import('ext.phpexcel.XPHPExcel');    
		   $objPHPExcel= XPHPExcel::createPHPExcel();
		   $objReader = PHPExcel_IOFactory::createReader('Excel5');
           $objPHPExcel = $objReader->load("report/templateSummaryCashflow.xls");


           		//fiscalyear
                $fiscalyear = array();

                foreach ($model as $key => $value) {
                	
                	//print_r($value);
                	if(!in_array($value->pj_fiscalyear."/".$value->pj_work_cat, $fiscalyear))
                	   $fiscalyear[] = $value->pj_fiscalyear."/".$value->pj_work_cat;
                

                }

                //print_r($model);
                $row =1;

                $filapar = new PHPExcel_Style();
			    $filapar->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'FA9D8E')
			        ),
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

				$sum = new PHPExcel_Style();
			    $sum->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			            'fill'  => array(
			            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
			            //'color' => array('rgb' =>'E070F4')
			        ),
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

			    $normal = new PHPExcel_Style();
			    $normal->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

			    $right = new PHPExcel_Style();
			    $right->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

			    $left = new PHPExcel_Style();
			    $left->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				                        
			        	)
			    ));

			    $bottom_right = new PHPExcel_Style();
			    $bottom_right->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));


			    $bottom_left = new PHPExcel_Style();
			    $bottom_left->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));
			    $bottom = new PHPExcel_Style();
			    $bottom->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));

			    $end_project = new PHPExcel_Style();
			    $end_project->applyFromArray(
			        array(
			            'font'  => array(
			            'name'  => 'TH SarabunPSK', 
			            'size'  => 15,              
			            'color' => array(
			            'rgb'   => '000000'
			            )
			        ),
			           
			            'borders' => array(
				            'left'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'right'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	),
				           	'bottom'    => array(
				            	'style'   => PHPExcel_Style_Border::BORDER_THIN ,
				            	'color'   => array(
				            		'rgb'     => '000000'
				              	)
				           	)             
			        	)
			    ));



			    $cell_underline = array();
			    $cell_pc_end = array();
			    $cell_oc_end = array();
			    $row = 4;
                asort($fiscalyear);

                //summary all
                $sumall_pc_cost = 0;
                $sumall_pc_receive = 0;
                         
                $sumall_oc_cost = 0;
                $sumall_oc_receive = 0;
                       
                $sumall_m_real = 0;
                $sumall_m_type1 = 0;
                $sumall_m_expect = 0;


                foreach ($fiscalyear as $key => $value) {
                	$data = explode("/", $value);
                	$year = $data[0];
                	$cat = $data[1];

                	$mWorkCat = WorkCategory::model()->findByPk($cat);

		   			// Rename sheet
		      		$objPHPExcel->getActiveSheet()->setTitle('ปี '.$year);
		      		
		      		//title 
		      		$objPHPExcel->setActiveSheetIndex(0)
		             			->setCellValue('A1', "สรุปงานรายรับ-รายจ่ายงานโครงการปี  ".$year);
                	
                	//workcategory
                	
                	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':P'.$row);
                	$objPHPExcel->setActiveSheetIndex(0)
		             			->setCellValue('A'.$row, $mWorkCat->wc_name);
                	$objPHPExcel->getActiveSheet()->setSharedStyle($filapar, "A".$row.":P".$row);
                	
                	$index = 1;

                	//summary
                    $sum_pc_cost = 0;
                    $sum_pc_receive = 0;
                         
                    $sum_oc_cost = 0;
                    $sum_oc_receive = 0;
                       
                    $sum_m_real = 0;
                    $sum_m_type1 = 0;
                    $sum_m_expect = 0;

                    $row++;     
                	foreach ($model as $key => $pj) {
                	  if($pj->pj_fiscalyear==$year && $pj->pj_work_cat==$cat)
                	  {
                	  	 
                	  	

                	  	 //project contract
	                	 $Criteria = new CDbCriteria();
	                     $Criteria->condition = "pc_proj_id='$pj->pj_id'";
	                	 $pcs = ProjectContract::model()->findAll($Criteria);
                         $nPC = count($pcs);

                         $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(pc_cost) as sum')
                                            ->from('project_contract')
                                            ->where("pc_proj_id='$pj->pj_id'")
                                            ->queryAll();  
                        $pcCostAll = $pp[0]["sum"];                     
                        foreach ($pcs as $key => $pc) {
                            $pp2 = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$pc->pc_id' AND type=1")
                                            ->queryAll(); 
                            $pcCostAll += $pp2[0]["sum"];                 
                         } 
                         
                                                                                
                            

                         //2.outsource contract
                         $Criteria = new CDbCriteria();
                         $Criteria->condition = "oc_proj_id='$pj->pj_id'";
                         $ocs = OutsourceContract::model()->findAll($Criteria);
                         $nOC = count($ocs);

                         //management cost
                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=0";
                        $m_plan = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type!=0 AND mc_type!=1";
                        $m_real = ManagementCost::model()->findAll($Criteria);

                        $Criteria = new CDbCriteria();
                        $Criteria->condition = "mc_proj_id='$pj->pj_id' AND mc_type=1";
                        $m_type1 = ManagementCost::model()->findAll($Criteria);

                        

                        //end

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=0")
                                            ->queryAll();
                        $sum_m_expect += $pp[0]["sum"];
                        $m_expect_sum = $pp[0]["sum"];


                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type=1")
                                            ->queryAll();
                        $m_type1_sum = $pp[0]["sum"];                    

                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(mc_cost) as sum')
                                            ->from('management_cost')
                                            ->where("mc_proj_id='$pj->pj_id' AND mc_type!=0 AND mc_type!=1")
                                            ->queryAll();
                        $m_real_sum = $pp[0]["sum"];

                        $sum_m_real += $m_real_sum;
                        $sum_m_type1 += $m_type1_sum;
                        //profit
                        //1.income
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_project_contract')
                                            ->join('project_contract','proj_id=pc_id')
                                            ->where("pc_proj_id='$pj->pj_id' AND bill_no!=''")
                                            ->queryAll();
                        //echo $pp[0]["sum"];
                        $income = $pp[0]["sum"];
                        
                        //1.outcome
                        
                        $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->join('outsource_contract','contract_id=oc_id')
                                            ->where("oc_proj_id='$pj->pj_id'")
                                            ->queryAll();                    
                        $outcome = $pp[0]["sum"];                    
                      



                         $maxContract = $nOC==0? 1:$nOC;

                         $pj_rowspan = $maxContract ;

                        
                        //draw project
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':A'.($row+$pj_rowspan-1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('B'.$row.':B'.($row+$pj_rowspan-1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C'.$row.':C'.($row+$pj_rowspan-1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('D'.$row.':D'.($row+$pj_rowspan-1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('F'.$row.':F'.($row+$pj_rowspan-1));
                		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, $index);
                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $pj->pj_name);
                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, number_format($pcCostAll,2));
                	  	
                	  	$sum_pc_cost += $pcCostAll;
                        $sum_pc_receive += $income;
                        $income1 = $income==0 ? '-' : number_format($income,2);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $income1);
                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, number_format($pcCostAll-$income,2));                	  	
                	  	
                	  	//draw management cost
                	  	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('M'.$row.':M'.($row+$pj_rowspan-1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('N'.$row.':N'.($row+$pj_rowspan-1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('O'.$row.':O'.($row+$pj_rowspan-1));
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('P'.$row.':P'.($row+$pj_rowspan-1));
                	  	$expect = $m_expect_sum==0 ? "-" : number_format($m_expect_sum,2);
                        $real = $m_real_sum==0 ? "-" : number_format($m_real_sum,2);
                        $type1 = $m_type1_sum==0 ? "-" : number_format($m_type1_sum,2);
                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row, $expect);
                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row, $real);
                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row, $type1);
                	  	$rm =($m_expect_sum - $m_type1_sum - $m_real_sum)==0 ? "-" : number_format($m_expect_sum - $m_type1_sum - $m_real_sum,2);                                    
                	  	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row, $rm);

                	  	//draw pc
                	  	$row_pc = $row;
                	  	foreach ($ocs as $key => $oc) {
                	  		$vendor = Vendor::model()->findByPk($oc->oc_vendor_id);
                	  		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$row_pc, $vendor->v_name);
                	  		
                	  		 $pp2 = Yii::app()->db->createCommand()
                                            ->select('SUM(cost) as sum')
                                            ->from('contract_change_history')
                                            ->where("contract_id='$oc->oc_id' AND type=2")
                                            ->queryAll(); 
                                    $ocCostAll =str_replace(",", "", $oc->oc_cost) + $pp2[0]["sum"];  

                	  		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row_pc, number_format($ocCostAll,2));
                	  		$sum_oc_cost += $ocCostAll;

                	  		 $pp = Yii::app()->db->createCommand()
                                            ->select('SUM(money) as sum')
                                            ->from('payment_outsource_contract')
                                            ->where("contract_id='$oc->oc_id' AND approve_date!=''")
                                            ->queryAll();                    
                                    $outcomeOC = $pp[0]["sum"];   
                                    $sum_oc_receive += $outcome; 
                                    $outcomeOC1 = $outcomeOC==0 ? '-' : number_format($outcomeOC,2);
                	  		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row_pc, $outcomeOC1);


                	  		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row_pc, number_format($ocCostAll-$outcomeOC,2));

                	  		$row_pc++;
                	  	}

                	  	if(count($ocs)==0)
                	  		$row_pc++;

                	  	$objPHPExcel->getActiveSheet()->setSharedStyle($filapar, "A".$row.":P".($row_pc-1));
                	  	$objPHPExcel->getActiveSheet()->getStyle("A".$row.":F".($row_pc-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                	  	$objPHPExcel->getActiveSheet()->getStyle("M".$row.":P".($row_pc-1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		            	$objPHPExcel->getActiveSheet()->getStyle("A".$row.":A".($row_pc-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		            	$objPHPExcel->getActiveSheet()->getStyle("C".$row.":F".($row_pc-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		            	$objPHPExcel->getActiveSheet()->getStyle("H".$row.":P".($row_pc-1))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                	  	
                        //end

                         //       $row_i = $objPHPExcel->getActiveSheet()->getHighestRow()+2;
						///	    $row = $row_i;
						$row = $row_pc;
						//$row++;   
						$index++;
                	  }
                	}  
                	//summary
                	$sumall_pc_cost += $sum_pc_cost;
                	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':B'.$row);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, "รวม");
                    $sum_cost = $sum_pc_cost==0 ? "-" : number_format($sum_pc_cost,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $sum_cost);

    				$sumall_pc_receive += $sum_pc_receive;

                    $sum_receive = $sum_pc_receive==0 ? "-" : number_format($sum_pc_receive,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $sum_receive);

                    $rm = $sum_pc_cost-$sum_pc_receive==0 ? "-" : number_format($sum_pc_cost-$sum_pc_receive,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, $rm);	

    				$sumall_oc_cost += $sum_oc_cost;
    				$sum_cost = $sum_oc_cost==0 ? "-" : number_format($sum_oc_cost,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $sum_cost);	
    				$sumall_oc_receive += $sum_oc_receive;
    				$sum_receive = $sum_oc_receive==0 ? "-" : number_format($sum_oc_receive,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, $sum_receive);	

    				$rm = $sum_oc_cost-$sum_oc_receive==0 ? "-" : number_format($sum_oc_cost-$sum_oc_receive,2);    				
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row, $rm);	

    				$sumall_m_expect += $sum_m_expect;
    				$sum_expect = $sum_m_expect==0 ? "-": number_format($sum_m_expect,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row, $sum_expect);	
    				$sumall_m_real += $sum_m_real;
    				$sum_real = $sum_m_real==0 ? "-": number_format($sum_m_real,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row, $sum_real);	
    				$sumall_m_type1 += $sum_m_type1;
    				$sum_type1 = $sum_m_type1==0 ? "-": number_format($sum_m_type1,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row, $sum_type1);	

    				$sum_rm = $sum_m_expect - $sum_m_real - $sum_m_type1==0 ? "-": number_format($sum_m_expect - $sum_m_real - $sum_m_type1,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row, $sum_rm);	

    				$objPHPExcel->getActiveSheet()->setSharedStyle($filapar, "A".$row.":P".$row);
                	$objPHPExcel->getActiveSheet()->getStyle("A".$row.":F".($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                	$objPHPExcel->getActiveSheet()->getStyle("M".$row.":P".($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		            $objPHPExcel->getActiveSheet()->getStyle("A".$row.":A".($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		            $objPHPExcel->getActiveSheet()->getStyle("C".$row.":F".($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		            $objPHPExcel->getActiveSheet()->getStyle("H".$row.":P".($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                	  		  	
   					$row++;                         	
		      	}	
		   
		    //summary
                	$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A'.$row.':B'.$row);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, "รวมทั้งหมด");
                    $sum_cost = $sumall_pc_cost==0 ? "-" : number_format($sumall_pc_cost,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $sum_cost);

                    $sum_receive = $sumall_pc_receive==0 ? "-" : number_format($sumall_pc_receive,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $sum_receive);

                    $rm = $sumall_pc_cost-$sumall_pc_receive==0 ? "-" : number_format($sumall_pc_cost-$sumall_pc_receive,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$row, $rm);	

    				$sum_cost = $sumall_oc_cost==0 ? "-" : number_format($sumall_oc_cost,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$row, $sum_cost);	

    				$sum_receive = $sumall_oc_receive==0 ? "-" : number_format($sumall_oc_receive,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$row, $sum_receive);	

    				$rm = $sumall_oc_cost-$sumall_oc_receive==0 ? "-" : number_format($sumall_oc_cost-$sumall_oc_receive,2);    				
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$row, $rm);	

    				$sum_expect = $sumall_m_expect==0 ? "-": number_format($sumall_m_expect,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$row, $sum_expect);	

    				$sum_real = $sumall_m_real==0 ? "-": number_format($sumall_m_real,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$row, $sum_real);	

    				$sum_type1 = $sumall_m_type1==0 ? "-": number_format($sumall_m_type1,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$row, $sum_type1);	

    				$sum_rm = $sumall_m_expect - $sumall_m_real - $sumall_m_type1==0 ? "-": number_format($sumall_m_expect - $sumall_m_real - $sumall_m_type1,2);
    				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$row, $sum_rm);	

    				$objPHPExcel->getActiveSheet()->setSharedStyle($filapar, "A".$row.":P".$row);
                	$objPHPExcel->getActiveSheet()->getStyle("A".$row.":F".($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                	$objPHPExcel->getActiveSheet()->getStyle("M".$row.":P".($row))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
		            $objPHPExcel->getActiveSheet()->getStyle("A".$row.":A".($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		            $objPHPExcel->getActiveSheet()->getStyle("C".$row.":F".($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		            $objPHPExcel->getActiveSheet()->getStyle("H".$row.":P".($row))->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
		      	                      	
		      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
		    $objPHPExcel->setActiveSheetIndex(0);
		  	 
			$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);


		  //?????important clear cabage
		ob_end_clean();
		ob_start();

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="summaryCashflow_report.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->save('php://output');  //
		 Yii::app()->end(); 
        
    }

    

}