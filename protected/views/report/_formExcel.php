<?php
$this->breadcrumbs=array(
	'Progress Report ',
	
);


?>

<style>

.reportTable thead th {
	text-align: center;
	font-weight: bold;
	background-color: #eeeeee;
	vertical-align: middle;
	}

.reportTable td {
	
}

<?php
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
?>


<?php
Yii::import('ext.phpexcel.XPHPExcel');    
      $objPHPExcel= XPHPExcel::createPHPExcel();
   
     // Set properties
     $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                             ->setLastModifiedBy("Maarten Balliauw")
                             ->setTitle("PDF Test Document")
                             ->setSubject("PDF Test Document")
                             ->setDescription("Test document for PDF, generated using PHP classes.")
                             ->setKeywords("pdf php")
                             ->setCategory("Test result file");
     // Add some data
     $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Hello')
            ->setCellValue('B2', 'world!')
            ->setCellValue('C1', 'Hello')
            ->setCellValue('D2', 'world!');
      // Miscellaneous glyphs, UTF-8
     $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A4', 'Miscellaneous glyphs')
            ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç');
      // Rename sheet
      $objPHPExcel->getActiveSheet()->setTitle('Simple');
      // Set active sheet index to the first sheet, so Excel opens this as the first sheet
     $objPHPExcel->setActiveSheetIndex(0);
      // Redirect output to a client’s web browser (Excel2007)
      // Redirect output to a client’s web browser (Excel2007)
// Redirect output to a client’s web browser (Excel5)



header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="01simple.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
//?????important clear cabage
ob_end_clean();
ob_start();
$objWriter->save('php://output');  //
 

?>