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
$pdf->SetTitle('BSC report');
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
$html = "";

    $html .= '<div style="text-align:center">ข้อมูลด้านการให้บริการ วันที่ '.renderDate($date_start).' ถึงวันที่ '.renderDate($date_end).' (วงเงินไม่รวมภาษีมูลค่าเพิ่ม)</div>';
    $html .= "<br>";
    
    $Criteria = new CDbCriteria();
    $dateStr = explode("/", $date_start);
    $date_start = ($dateStr[2]-543)."-".$dateStr[1]."-".$dateStr[0];
    $dateStr = explode("/", $date_end);
    $date_end = ($dateStr[2]-543)."-".$dateStr[1]."-".$dateStr[0];


    $Criteria->join = 'LEFT JOIN project_contract ON pc_proj_id=pj_id'; 
    $Criteria->condition = " (pc_end_date >= '$date_start' AND pc_sign_date<='$date_end') OR (pc_sign_date <= '$date_end' AND pc_end_date>='$date_start') AND (pc_sign_date!='0000-00-00' AND pc_end_date='0000-00-00') GROUP BY pj_id ";// AND pj_status=1";

    //$html .=  " (pc_end_date >= '$date_start' AND pc_sign_date<='$date_end') OR (pc_sign_date <= '$date_end' AND pc_end_date>='$date_start') AND (pc_sign_date!='0000-00-00' AND pc_end_date='0000-00-00')  ";
    $Criteria->order = 'pj_fiscalyear DESC, pj_date_approved DESC';
    $projects = Project::model()->findAll($Criteria);



    $html .= '<table border="1" class="span12" style="margin-left:0px;">';
        $html .= '<thead><tr>';
         $html .= '<th  style="font-weight: bold;text-align:center;width:5%;background-color: #ddd;">ลำดับ</th>';
         $html .= '<th  style="font-weight: bold;text-align:center;width:25%;background-color: #ddd;">โครงการ/ผู้ว่าจ้าง</th>';
         $html .= '<th  style="font-weight: bold;text-align:center;width:40%;background-color: #ddd;">รายละเอียดงาน</th>';
         $html .= '<th style="font-weight: bold;text-align:center;width:10%;background-color: #ddd;">วงเงินตามสัญญา<br>(ไม่รวม VAT)</th>';
         $html .= '<th style="font-weight: bold;text-align:center;width:10%;background-color: #ddd;">กำไรขั้นต้น (บาท)</th>';        
         $html .= '<th style="font-weight: bold;text-align:center;width:10%;background-color: #ddd;">คิดเป็นร้อยละ</th>';
        
        $html .= '</tr></thead>';

        $i=1;
        $proj_cost_total = 0;
        $income_total = 0;
        $year = 0;
        
        $html .= '<tbody>';        
        foreach ($projects as $key => $proj) {
            if($year!=$proj->pj_fiscalyear)
            {
                $year = $proj->pj_fiscalyear;
                $html .= '<tr><td colspan="6" height="30"><b> ปีงบประมาณ '.$year.'</b></td></tr>';
            }
            $html .= '<tr>';
                $html .= '<td style="text-align:center;width:5%;" height=30>'.$i.'</td>';
                $html .= '<td style="width:25%;" height=30>'.$proj->pj_name.'</td>';
                //project contract
                $pcData=Yii::app()->db->createCommand("SELECT sum(pc_cost) as proj_cost,pc_details FROM project_contract WHERE pc_proj_id='$proj->pj_id'")->queryAll(); 
                
                $incomeData=Yii::app()->db->createCommand("SELECT sum(cost) as income FROM project_contract c LEFT JOIN contract_approve_history a ON pc_id=contract_id WHERE pc_proj_id='$proj->pj_id' AND type=1 AND detail LIKE '%กำไร%' AND dateApprove BETWEEN '$date_start' AND '$date_end' ")->queryAll();

                //if($proj->pj_id==281)
                //$html .= "SELECT sum(cost) as income FROM  contract_approve_history a LEFT JOIN project_contract c ON pc_id=contract_id WHERE pc_proj_id='$proj->pj_id' AND type=1 AND detail LIKE '%กำไร%' AND dateApprove BETWEEN '$date_start' AND '$date_end' ";

                $proj_cost_total += $pcData[0]['proj_cost'];
                $income_total += $incomeData[0]['income'];

                
                $html .= '<td style="width:40%;">'.$pcData[0]['pc_details'].'</td>';
                $html .= '<td style="text-align:right;width:10%;">'.number_format($pcData[0]['proj_cost'],2).'</td>';
                

                $html .= '<td style="text-align:right;width:10%;">'.number_format($incomeData[0]['income'],2).'</td>';
                $percent = $pcData[0]['proj_cost']==0 ? 0: ($incomeData[0]['income']/$pcData[0]['proj_cost'])*100;
                $html .= '<td style="text-align:right;width:10%;">'.number_format($percent,2).'</td>';
            $html .= '</tr>';

            $i++;
        }

        
        $html .= '<tr>';
         
         $html .= '<td colspan="3" style="text-align:center;width:70%;background-color: #ddd;" height=30>รวมเป็นเงิน</td>';
         $html .= '<td style="text-align:right;width:10%;background-color: #ddd;">'.number_format($proj_cost_total,2).'</td>';
         $html .= '<td style="text-align:right;width:10%;background-color: #ddd;">'.number_format($income_total,2).'</td>'; 
         $percent = $proj_cost_total==0 ? 0: ($income_total/$proj_cost_total)*100;   
         $html .= '<td style="text-align:right;background-color: #ddd;">'.number_format($percent,2).'</td>';
        
        $html .= '</tr>';
        $html .= '</tbody>';
    $html .= '</table>';


//echo $html;
  
$pdf->AddPage();
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
$pdf->Output($_SERVER['DOCUMENT_ROOT'].'/pea_track/report/temp/'.$filename,'F');
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