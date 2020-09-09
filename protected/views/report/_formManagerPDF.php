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


    $renderDate = $d." ".$th_month[$mi]." ".$yi;
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



// Include the main TCPDF library (search for installation path).
require_once('/../tcpdf/tcpdf.php');

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        
        // Set font
        //$this->SetFont('helvetica', 'B', 20);
        // Title
        //$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-10);
        // Set font
        $this->SetFont('thsarabun', '', 11);
        // Page number
        //$this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
        // Logo
        //$image_file = 'bank/image/mwa2.jpg';
        //$this->Image($image_file, 170, 270, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $this->Cell(0, 5, date("d/m/Y"), 0, false, 'R', 0, '', 0, false, 'T', 'M');

        $this->writeHTMLCell(145, 550, 70, 200, '-'.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'-', 0, 1, false, true, 'C', false);
        //writeHTMLCell ($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true)
    }
}

// create new PDF document
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Boybe');
$pdf->SetTitle('Manager report');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setPrintHeader(false);
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, 10, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('thsarabun', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
//$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$th_month = array("01"=>"ม.ค.",'02'=>"ก.พ.",'03'=>"มี.ค.",'04'=>"เม.ย.",'05'=>"พ.ค.",'06'=>"มิ.ย.",'07'=>"ก.ค.",'08'=>"ส.ค.",'09'=>"ก.ย.",'10'=>"ต.ค.",'11'=>"พ.ย.",'12'=>"ธ.ค.");

$html = "";
	$start_str = explode("-", $start_date);
    $end_str = explode("-", $end_date);

    $html .= '<div style="text-align:center">รายงานผู้จัดการโครงการ/ผู้อำนวยการโครงการ<br>ช่วงเดือน '.$th_month[$start_str[1]]." ".($start_str[0]+543)." ถึงเดือน ".$th_month[$end_str[1]]." ".($end_str[0]+543).'</div>';
    $html .= "<br>";
    
    $html .= '<table border="1" width="130%" style="margin-left:0px;margin-bottom:20px;">';
		$html .='<tr style="background-color:#F5C27F">';
		$html .='<td style="text-align:center;width:5%">ลำดับ</td>';
		$html .='<td style="text-align:center;width:20%">ช่ื่อ-นามสกุล</td>';
		$html .='<td style="text-align:center;width:10%">ตำแหน่ง</td>';
		 $html .='<td styl="text-align:center;width:35%">โครงการ</td>';
         $html .='<td style="text-align:center;width:18%">ประเภทงาน</td>';
		 $html .='<td style="text-align:center;width:7%">ปีงบประมาณ</td>';

		$html .='</tr>';

        $firtQuery = Yii::app()->db->createCommand()
                ->select('pj_name,pj_work_cat,pj_fiscalyear,pj_manager_name')
                ->from('project')
                ->where('pj_manager_name!="" AND pj_manager_name LIKE "%'.$name.'%" AND (pj_date_approved BETWEEN "'.$start_date.'" AND "'.$end_date.'")')
                ->order("pj_fiscalyear DESC")
                ->queryAll();
        

        $second = Yii::app()->db->createCommand()
                ->select('pj_name,pj_work_cat,pj_fiscalyear,pj_director_name')
                ->from('project')
                ->where('pj_director_name!="" AND pj_director_name LIKE "%'.$name.'%" AND (pj_date_approved BETWEEN "'.$start_date.'" AND "'.$end_date.'")')
             
                ->order("pj_fiscalyear DESC")
                ->queryAll();

        $result = array_merge($firtQuery, $second);              
        $no = 1; 
       

        function array_orderby()
        {
            $args = func_get_args();
            $data = array_shift($args);
            foreach ($args as $n => $field) {
                if (is_string($field)) {
                    $tmp = array();
                    foreach ($data as $key => $row)
                        $tmp[$key] = $row[$field];
                    $args[$n] = $tmp;
                    }
            }
            $args[] = &$data;
            call_user_func_array('array_multisort', $args);
            return array_pop($args);
        }



        // Pass the array, followed by the column names and sort flags
        $sorted = array_orderby($result, 'pj_fiscalyear', SORT_DESC);        
       
        $no = 1;        
        foreach ($sorted as $key => $value) {
           $html .='<tr>';
                 $html .='<td style="text-align:center;">'.($no++)."</td>";
                 if(isset($value['pj_manager_name']))
                 {
                 	$html .='<td style="text-align:left;">'.$value['pj_manager_name']."</td>";
                 	$html .='<td style="text-align:center;">ผู้จัดการโครงการ</td>';
                 }
                 else
                 {
                 	 $html .='<td style="text-align:left;">'.$value['pj_director_name']."</td>";
                 	 $html .='<td style="text-align:center;">ผู้อำนวยการโครงการ</td>';
                 }
                 $html .='<td style="text-align:left;">'.$value['pj_name']."</td>";
                 $html .='<td style="text-align:center;">'.WorkCategory::model()->findByPK($value['pj_work_cat'])->wc_name."</td>";
                 $html .='<td style="text-align:center;">'.$value['pj_fiscalyear']."</td>";
           $html .='</tr>';
        } 

       

	$html .='</table>';


   
  
$pdf->AddPage();
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output($_SERVER['DOCUMENT_ROOT']."/".Yii::app()->baseUrl.'/report/temp/tempReport.pdf','F');
// Print text using writeHTMLCell()


// ---------------------------------------------------------

// Close and output PDF document
// // This method has several options, check the source code documentation for more information.
// if(file_exists($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
// {    
//     if(unlink($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf'))
//         $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
// }else{
//    $pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/'.'tempReport.pdf','F');
// }
ob_end_clean() ;

exit;
?>