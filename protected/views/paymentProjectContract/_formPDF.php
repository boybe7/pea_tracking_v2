<?php

function bahtText($amount)
{
    $integer = explode('.', number_format(abs($amount), 2, '.', ''));

    $baht = convert($integer[0]);
    $satang = convert($integer[1]);

    $output = $amount < 0 ? 'ลบ' : '';
    $output .= $baht ? $baht.'บาท' : '';
    $output .= $satang ? $satang.'สตางค์' : 'ถ้วน';

    return $baht.$satang === '' ? 'ศูนย์บาทถ้วน' : $output;
}

function convert($number)
{
    $values = ['', 'หนึ่ง', 'สอง', 'สาม', 'สี่', 'ห้า', 'หก', 'เจ็ด', 'แปด', 'เก้า'];
    $places = ['', 'สิบ', 'ร้อย', 'พัน', 'หมื่น', 'แสน', 'ล้าน'];
    $exceptions = ['หนึ่งสิบ' => 'สิบ', 'สองสิบ' => 'ยี่สิบ', 'สิบหนึ่ง' => 'สิบเอ็ด'];

    $output = '';

    foreach (str_split(strrev($number)) as $place => $value) {
        if ($place % 6 === 0 && $place > 0) {
            $output = $places[6].$output;
        }

        if ($value !== '0') {
            $output = $values[$value].$places[$place % 6].$output;
        }
    }

    foreach ($exceptions as $search => $replace) {
        $output = str_replace($search, $replace, $output);
    }

    return $output;
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
        $this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'R', 0, '', 0, false, 'M', 'M');

        //$image_file = 'bank/image/mwa2.jpg';
        //$this->Image($image_file, 170, 270, 25, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
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
        //$this->Cell(0, 5, date("d/m/Y"), 0, false, 'R', 0, '', 0, false, 'T', 'M');

        //$this->writeHTMLCell(145, 550, 70, 200, '-'.$this->getAliasNumPage().'/'.$this->getAliasNbPages().'-', 0, 1, false, true, 'C', false);
        //writeHTMLCell ($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=false, $reseth=true, $align='', $autopadding=true)
    }
}

// create new PDF document
//$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Boybe');
$pdf->SetTitle('Invoice');
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
$vendor = Vendor::model()->findByPK(ProjectContract::model()->findByPK($model->proj_id)->pc_vendor_id);
$project = Project::model()->findByPK(ProjectContract::model()->findByPK($model->proj_id)->pc_proj_id);
$vendor_name = empty($vendor) ?"" : $vendor->v_name;
$html = "";
    //header
    $html .= '<table border="0" class="span12" style="margin-left:0px;border-collapse: collapse;">';
        $html .= '<tr><td rowspan="2" width="70%"><img src="'.Yii::app()->baseUrl.'/images/pea_logo_th.jpeg" width="150"></td><td width="30%" style=""><br>ใบแจ้งหนี้  เลขที่ ...'.$model->invoice_no.'....</td></tr>';
        $html .= '<tr><td width="30%">วันที่    ...'.renderDate($model->invoice_date).'...</td></tr>';
    $html .= '</table><br><br>';

    $html .= '<table border="0" class="span12" style="margin-left:0px;border-collapse: collapse;">';
        $html .= '<tr><td width="10%">ชื่อลูกค้า</td><td width="90%" style="border-bottom:0.1e dashed #3b3a39;">'.$vendor_name.'</td></tr>';
        $html .= '<tr><td>ที่อยู่</td><td  style="border-bottom:0.1e dashed #3b3a39;">'.$model->address.'</td></tr>';
        //reference
        $ref_model = PaymentDocRefer::model()->findAll('payment_id =:id', array(':id' =>$model->id));
    
        $row = 0;
        foreach ($ref_model as $key => $value) {
            $no = count($ref_model)==1 ? "" : ($row+1).". ";

            if($row==0)
            {
                 $html .= '<tr><td>อ้างถึง</td><td  style="border-bottom:0.1e dashed #3b3a39;">'.$no.$value->detail.'</td></tr>';
            }
            else
            {
                $html .= '<tr><td></td><td  style="border-bottom:0.1e dashed #3b3a39;">'.$no.$value->detail.'</td></tr>';
            }
            $row++;
        }
    $html .= '</table><br><br>';


    $html .= '<table border="1" width="105%" style="margin-left:0px;">';
        $html .= '<tr >';
            $html .= '<td height="60px" style="font-weight: bold;text-align:center;width:10%;inline-height:250%;"><br><br>ลำดับที่</td>';
            $html .= '<td  style="font-weight: bold;text-align:center;width:60%;"><br><br>รายการ</td>';         
            $html .= '<td style="font-weight: bold;text-align:center;width:25%;"><br><br>จำนวนเงิน (บาท)</td>';        
        $html .= '</tr>';
        $html .= '<tr >';
            $html .= '<td height="60px" style="border-bottom:1px solid white;text-align:center;inline-height:250%;"><br>1</td>';
            $html .= '<td  style="border-left:1px solid black;border-right:1px solid black;border-bottom:1px solid white;"><br>'.$model->detail.'<br><br><br><br><br><br><br><br><br></td>';         
           
            $html .= '<td style="border-bottom:1px solid white;text-align:right;"><br>'.($model->money).'</td>';        
        $html .= '</tr>';
        $html .= '<tr >';
            $html .= '<td style="text-align:center;border-top:1px solid white;"><br></td>';
            $html .= '<td  style="text-align:center;border-left:1px solid black;border-right:1px solid black;border-top:1px solid white;">เป็นจำนวนเงิน<br>ภาษีมูลค่าเพิ่ม 7%</td>';         
            $tax = str_replace(",", "", $model->money)*0.7;
            $money = str_replace(",", "", $model->money);
            $html .= '<td style="text-align:right;border-top:1px solid white;">'.($model->money)."<br>".number_format($tax,2).'</td>';        
        $html .= '</tr>';
         $html .= '<tr >';
            $html .= '<td colspan="2" style="font-weight: bold;">รวมเป็นเงินทั้งสิ้น&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;('.bahtText($money+$tax).')           </td>';       
            $tax = str_replace(",", "", $model->money)*0.7;
            $html .= '<td style="font-weight: bold;text-align:right;">'.number_format($money+$tax,2).'</td>';        
        $html .= '</tr>';
       
    $html .= '</table>';

    $html .= '<br><br><table border="0" width="105%" style="margin-left:0px;">';
        $html .= '<tr><td width="40%" rowspan="3"></td><td width="40%" style="text-align:center;">(ลงชื่อ) ........................................................</td><td rowspan="3" width="20%"></td></tr>';
        $html .= '<tr><td style="text-align:center;">(.............'.$model->signed_name.'.............)</td></tr>';
        $html .= '<tr><td style="text-align:center;">ตำแหน่ง.............'.$model->signed_position.'.............</td></tr>';
        if($model->act_instead)
        {
             $html .= '<tr><td></td><td style="text-align:center;">...ปฏิบัติหน้าที่แทน ผวก....</td><td></td></tr>';   
        }
    $html .= '</table>';

    $html .= '<br><br><table border="0" width="100%" style="margin-left:0px;">';
        $html .= '<tr>
                     <td width="15%" rowspan="3">หมายเหตุ</td>
                     <td width="3%">1.</td>
                     <td width="80%" style="">โปรดชำระหนี้ภายใน '.$model->pay_day.' วัน หลังจากได้รับใบแจ้งหนี้ หากไม่สามารถชำระเงินภายในกำหนด การไฟฟ้าส่วนภูมิภาคจะคิดดอกเบี้ยเป็นรายวันในอัตราไม่น้อยกว่าร้อยละ 7.5 ต่อปี นับถัดจากวันที่ครบกำหนดชำระจนถึงวันที่การไฟฟ้าส่วนภูมิภาคได้รับชำระครบถ้วนแล้ว
                     </td>
                 </tr>';
         $html .= '<tr>
                    
                     <td >2.</td>
                     <td style="">เมื่อชำระเงินตามจำนวนข้างต้น ต้องเรียกใบเสร็จรับเงินทุกครั้ง มิฉะนั้นการไฟฟ้าส่วนภูมิภาคจะไม่ยอมรับว่าได้ชำระเงินถูกต้องและใบเสร็จรับเงินนั้นต้องมีลายเซ็นหัวหน้าแผนกการเงิน หรือหัวหน้าแผนก หรือหัวหน้าหมวดบัญีและการเงิน และลายมือชื่อของพนักงานเก็บเงิน หรือผู้รับเงิน
                     </td>
                 </tr>'; 

        $html .= '<tr>
                    
                     <td >3.</td>
                     <td  style="">เลขที่บัญชีลูกค้า  '.$project->pj_CA.'
                     </td>
                 </tr>';                  
       
    $html .= '</table>';    


//echo $html;
$filename = "invoice_".$model->id.".pdf";  
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