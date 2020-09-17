<?php
$this->breadcrumbs=array(
	'mail',
);


?>

<h1>Send Mail</h1>

<?php 

	//Yii::import('application.extensions.phpmailer.JPhpMailer');
	//$mail = new JPhpMailer;
	
	require_once('PHPMailer/PHPMailerAutoload.php');
    $mail = new PHPMailer(true);

	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = "tls"; //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้

	
	$mail->Port = 587;  //ตรงส่วนนี้ผมไม่แน่ใจ ลองเปลี่ยนไปมาใช้งานได้
	$mail->isHTML();
	$mail->CharSet = "utf-8"; //ตั้งเป็น UTF-8 เพื่อให้อ่านภาษาไทยได้
	
	/*-------------GMAIL-----------------*/
	//test gmail : status = OK
	$mail->Host = "smtp.gmail.com";
	$mail->Username = "boybe7oo@gmail.com"; //ให้ใส่ Gmail ของคุณเต็มๆเลย
	$mail->Password = "jrtavkgjpodgudxu"; // ใส่รหัสผ่าน
	$mail->SetFrom = ('boybe7oo@gmail.com'); //ตั้ง email เพื่อใช้เป็นเมล์อ้างอิงในการส่ง ใส่หรือไม่ใส่ก็ได้ เพราะผมก็ไม่รู้ว่ามันแาดงให้เห็นตรงไหน*/

	$mail->FromName = "boybe"; //ชื่อที่ใช้ในการส่ง
	$mail->Subject = "ทดสอบการส่งอีเมล์  gmail xxx";  //หัวเรื่อง emal ที่ส่ง
	$mail->Body = "ได้แล้วครับ หลังจากที่งมกับ Code นี้มานานแสนนาน</b>"; //รายละเอียดที่ส่ง
	$mail->AddAddress('boybe7oo@gmail.com','boy gmail'); //อีเมล์และชื่อผู้รับ
	$mail->AddAddress('pathomphong.p@mwa.co.th','boy pea'); //อีเมล์และชื่อผู้รับ
	$mail->SMTPKeepAlive = true;
	//ส่วนของการแนบไฟล์ ซึ่งทดสอบแล้วแนบได้จริงทั้งไฟล์ .rar , .jpg , png ซึ่งคงมีหลายนามสกุลที่แนบได้
	//$mail->AddAttachment("files/1.rar");
	//$mail->AddAttachment("files/2.rar");
	//$mail->AddAttachment("files/1.jpg");
	//$mail->AddAttachment("files/2.png");
	
	$mail->SMTPDebug = SMTP::DEBUG_SERVER;
	try {
		//ตรวจสอบว่าส่งผ่านหรือไม่
		if ($mail->Send()){
		echo "ข้อความของคุณได้ส่งพร้อมไฟล์แนบแล้วจ้า";
		
		}else{
		echo "การส่งไม่สำเร็จ".$mail->ErrorInfo;;
		}
	} catch (phpmailerException $e) {
	echo $e->errorMessage(); //Pretty error messages from PHPMailer

	} catch (Exception $e) {
	echo $e->getMessage(); //Boring error messages from anything else!
	}
 ?>
