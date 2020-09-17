<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
   
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />


	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<!-- <script type="text/javascript" src="./themes/bootstrap/js/jquery.yiigridview.js"></script> -->
	<?php 
       /* Yii::app()->getClientScript()->reset(); 
        Yii::app()->bootstrap->register();   */

        
        Yii::app()->bootstrap->init();
        $cs = Yii::app()->clientScript;
        echo '<script type="text/javascript" src="'.Yii::app()->theme->getBaseUrl().'/js/jquery.yiigridview.js'.'"></script>';
        echo '<link rel="shortcut icon" href="'.Yii::app()->baseUrl.'/favicon.ico">';
       // $cs->registerScriptFile(Yii::app()->theme->getBaseUrl().'/js/jquery.yiigridview.js');
  ?>
</head>

<style>

.dropdown-menu {
   /*background-color: #33aa33;*/
   
}
.navbar .nav > li > .dropdown-menu:after {
  /*border-bottom: 6px solid #33aa33;*/
}
.dropdown-menu > li > a {
  /*color: white;*/

}
.dropdown-menu > li > a:hover {
  background-color: white;
  
}

.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus,
.dropdown-submenu:hover > a,
.dropdown-submenu:focus > a {
  color: #ffffff;
  text-decoration: none;
  background-color: #dbdad7;
  background-image: -moz-linear-gradient(top, #70cc68, #70cc68);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#70cc68), to(#70cc68));
  background-image: -webkit-linear-gradient(top, #70cc68, #70cc68);
  background-image: -o-linear-gradient(top,  #70cc68, #70cc68);
  background-image: linear-gradient(to bottom ,#70cc68, #70cc68);
  background-repeat: repeat-x;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff202120', endColorstr='#ff51a351', GradientType=0);
}

.dropdown-menu > .active > a,
.dropdown-menu > .active > a:hover,
.dropdown-menu > .active > a:focus {
  color: #ffffff;
  text-decoration: none;
  background-color: #202120;
  background-image: -moz-linear-gradient(top, #70cc68, #70cc68);
  background-image: -webkit-gradient(linear, 0 0, 0 100%, from(#70cc68), to(#70cc68));
  background-image: -webkit-linear-gradient(top, #70cc68, #70cc68);
  background-image: -o-linear-gradient(top,  #70cc68, #70cc68);
  background-image: linear-gradient(to bottom ,#70cc68, #70cc68);
  background-repeat: repeat-x;
  outline: 0;
  filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff202120', endColorstr='#ff51a351', GradientType=0);
}

.navbar .brand {
display: block;
float: left;
padding: 10px 20px 10px;
/*margin-left: -20px;*/
font-size: 20px;
font-weight: 200;
color: #fff;
text-shadow: 0 0 0 #ffffff;
}        

        
.navbar .nav > li > a{
float: none;
padding: 20px 15px 10px;
color: #fff;
text-decoration: none;
text-shadow: 0 0 0 #ffffff;
height: 35px;
}       

.navbar .nav > li > a >  i{
float: none;
/*margin-top: 5px;*/
}

.navbar .btn, .navbar .btn-group {
    margin-top: 15px;
}
.navbar .nav  > li > a:hover, .nav > li > a:focus {
    float: none;
    padding: 20px 15px 10px;
    color: #fff;
    text-decoration: none;
    text-shadow: 0 0 0 #ffffff;
    background-color: #33aa33;
}
.navbar .nav  > .active > a, .navbar .nav > .active > a:hover, .navbar .nav > .active > a:focus {
    color: #ffffff;
    background-color: #499249;

}       
 .navbar-inner {
	  /*background-color:#229922;*/
    background-color:#828080;
    color:#ffffff;
  	border-radius:0;
}
  
.navbar-inner .navbar-nav > li > a {
  	color:#fff;
  	padding-left:20px;
  	padding-right:20px;
}
.navbar-inner .navbar-nav > .active > a, .navbar-nav > .active > a:hover, .navbar-nav > .active > a:focus {
    color: #ffffff;
     background-color: #33aa33;
	background-color:transparent;
}
      
.navbar-inner .navbar-nav > li > a:hover, .nav > li > a:focus {
    text-decoration: none;
    background-color: #33aa33;
}
      
.navbar-inner .navbar-brand {
  	color:#eeeeee;
}
.navbar-inner .navbar-toggle {
  	background-color:#eeeeee;
}
.navbar-inner .icon-bar {
  	background-color:#33aa33;
}

.nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
	background-color: #33aa33;
	border-color: #428bca;
}

.navbar-inner {
    min-height: 0px;
}

.navbar .nav li.dropdown.open > .dropdown-toggle, .navbar .nav li.dropdown.active > .dropdown-toggle, .navbar .nav li.dropdown.open.active > .dropdown-toggle {
  color: white;  
  background-color: #33aa33;
  border-color: #428bca;
}

nav .badge {
  background: #67c1ef;
  border-color: #30aae9;
  background-image: -webkit-linear-gradient(top, #acddf6, #67c1ef);
  background-image: -moz-linear-gradient(top, #acddf6, #67c1ef);
  background-image: -o-linear-gradient(top, #acddf6, #67c1ef);
  background-image: linear-gradient(to bottom, #acddf6, #67c1ef);
}

nav .badge.green {
  background: #77cc51;
  border-color: #59ad33;
  background-image: -webkit-linear-gradient(top, #a5dd8c, #77cc51);
  background-image: -moz-linear-gradient(top, #a5dd8c, #77cc51);
  background-image: -o-linear-gradient(top, #a5dd8c, #77cc51);
  background-image: linear-gradient(to bottom, #a5dd8c, #77cc51);
}

nav .badge.yellow {
  background: #faba3e;
  border-color: #f4a306;
  background-image: -webkit-linear-gradient(top, #fcd589, #faba3e);
  background-image: -moz-linear-gradient(top, #fcd589, #faba3e);
  background-image: -o-linear-gradient(top, #fcd589, #faba3e);
  background-image: linear-gradient(to bottom, #fcd589, #faba3e);
}

nav .badge.red {
  background: #fa623f;
  border-color: #fa5a35;
  background-image: -webkit-linear-gradient(top, #fc9f8a, #fa623f);
  background-image: -moz-linear-gradient(top, #fc9f8a, #fa623f);
  background-image: -o-linear-gradient(top, #fc9f8a, #fa623f);
  background-image: linear-gradient(to bottom, #fc9f8a, #fa623f);
}


@font-face {
    font-family: 'Boon400';
    src: url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.eot') format('embedded-opentype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.woff') format('woff'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.ttf') format('truetype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-400.svg#Boon400') format('svg');
}

@font-face {
    font-family: 'Boon700';
    src: url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.eot');
    src: url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.eot') format('embedded-opentype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.woff') format('woff'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.ttf') format('truetype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/boon-700.svg#Boon700') format('svg');
}

@font-face {
    font-family: 'THSarabunPSK';
    src: url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.eot');
    src: url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.eot') format('embedded-opentype'),
         url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.woff') format('woff'),
         url('<?=Yii::app()->baseUrl;?>/fonts/thsarabunnew-webfont.ttf') format('truetype');
       
}

body{
    
    
     width:100%;
     min-height:340px;
     position: relative;
     /*background: url(../images/intro-bg.jpg) no-repeat center center;*/
     background-size: cover;
     font: 14px/1.4em 'Boon400',sans-serif;
     font-weight: normal;
}

input, select, textarea {
font-family: 'Boon400', sans-serif;
}

h1,h2,h3,h4{
        font-family: 'Boon700',sans-serif;
        font-weight: normal;
}

table tr .tr_white {
  background-color: #ffffff;
}

select, input[type="file"] {
    height: 30px;
    line-height: 30px;
}

#footer {
    background-color: #F0EFEF;
}
.credit {
    margin: 6px 0;
    color: #ccc;
    text-align: center;
}
#wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        /*margin: 0 auto -60px;*/
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
.the-legend {
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 0;
    width: inherit;
    padding: 0 10px;
    border-bottom: none;
}

.well-yellow {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #f8c10621;
    border: 1px solid #e3e3e3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
}

.well-blue {
    min-height: 20px;
    padding: 19px;
    margin-bottom: 20px;
    background-color: #c5d7df;
    border: 1px solid #e3e3e3;
    -webkit-border-radius: 4px;
    -moz-border-radius: 4px;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    -moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
}
/*scrollable*/
 .ui-autocomplete {
            max-height: 200px;
            max-width: 800px;
            overflow-y: auto;
            /* prevent horizontal scrollbar */
            overflow-x: hidden;
            /* add padding to account for vertical scrollbar */
            padding-right: 20px;
        } 
</style>     
<script type="text/javascript">
  
          function formatNumber(n) {
            // format number 1000000 to 1,234,567
     
            return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",")

          }


          function formatCurrency(input, blur) {
            // appends $ to value, validates decimal side
            // and puts cursor back in right position.
            
            // get input value
            var input_val = input.val();
            
            // don't validate empty input
            if (input_val === "") { return; }
            
            // original length
            var original_len = input_val.length;

            // initial caret position 
            var caret_pos = input.prop("selectionStart");
              
            // check for decimal
            if (input_val.indexOf(".") >= 0) {

              // get position of first decimal
              // this prevents multiple decimals from
              // being entered
              var decimal_pos = input_val.indexOf(".");

              // split number by decimal point
              var left_side = input_val.substring(0, decimal_pos);
              var right_side = input_val.substring(decimal_pos);

              // add commas to left side of number
              left_side = formatNumber(left_side);

              // validate right side
              right_side = formatNumber(right_side);
              
              // On blur make sure 2 numbers after decimal
              if (blur === "blur") {
                right_side += "00";
              }
              
              // Limit decimal to only 2 digits
              right_side = right_side.substring(0, 2);

              // join number by .
              input_val = "" + left_side + "." + right_side;

            } else {
              // no decimal entered
              // add commas to number
              // remove all non-digits
              input_val = formatNumber(input_val);
              input_val = "" + input_val;
              
              // final formatting
              if (blur === "blur") {
                input_val += ".00";
              }
            }
            
            // send updated string to input
            input.val(input_val);

            // put caret back in the right position
            var updated_len = input_val.length;
            caret_pos = updated_len - original_len + caret_pos;
            input[0].setSelectionRange(caret_pos, caret_pos);
          }
</script>
     
<body class="body">

<?php 
 //echo Yii::app()->theme->getBaseUrl(); 


if(Yii::app()->user->id !="")
{
    $num = 0;
    if(Yii::app()->user->isAccess('/notify/index'))
    {
        Yii::import('application.controllers.NotifyController');
        ///$num = notify::model()->getNotify();
        
        //$num = NotifyController::gnotify(1); // preparing object
        $Criteria = new CDbCriteria();
        $Criteria->condition = 'status=1';
        $num = count(Notify::model()->findAll($Criteria));
        
      
    }  

     $badge= '';
       
       if($num>0) 
        $badge=$this->widget('bootstrap.widgets.TbBadge', array(
          'type'=>'warning',
          'label'=>$num,
        ), true);

   $this->widget('bootstrap.widgets.TbNavbar',array(
    'fixed'=>'top',
    'collapse'=>true,    
    'htmlOptions'=>array('class'=>'noPrint'),
    'brand' =>  CHtml::image(Yii::app()->getBaseUrl() . '../images/pea_logo.png', 'Logo', array('width' => '300', 'height' => '30')),
    'items'=>array(
        array(
            'class'=>'bootstrap.widgets.TbMenu',
            'encodeLabel'=>false,
            'items'=>array(
                array('label'=>'หน้าแรก','icon'=>'home', 'url'=>array('/site/index')),
                // array('label'=>'โครงการ','icon'=>'flag', 'url'=>array('/project/index')),
                array('label'=>'โครงการ ','icon'=>'flag', 'url'=>'#','items'=>array(
                     array('label'=>'ข้อมูลโครงการ', 'url'=>array('/project/index')),
                     array('label'=>'บันทึกค่าบริหารโครงการ', 'url'=>array('/managementCost/index'),'visible'=>Yii::app()->user->isAccess('/managementCost/index')),
                     array('label'=>'บันทึกความก้าวหน้าสัญญาหลัก', 'url'=>array('/paymentProjectContract/index'),'visible'=>Yii::app()->user->isAccess('/paymentProjectContract/index')),
                     array('label'=>'บันทึกความก้าวหน้าสัญญาจ้างช่วง/ซื้อ', 'url'=>array('/paymentOutsourceContract/index'),'visible'=>Yii::app()->user->isAccess('/paymentOutsourceContract/index')),
                     array('label'=>'บันทึกค่าบริหารโครงการ (SAP)', 'url'=>array('/managementCostSap/index'),'visible'=>Yii::app()->user->isAccess('/managementCostSap/index')),
                      array('label'=>'หนังสือขอคืนค้ำประกันสัญญา', 'url'=>array('/report/guarantee'),'visible'=>Yii::app()->user->isAccess('/report/guarantee')),
                     
                    ),
                ),
                array('label'=>'รายงาน ','icon'=>'list-alt', 'url'=>'#','items'=>array(
                     array('label'=>'project progress report', 'url'=>array('/report/progress'),'visible'=>Yii::app()->user->isAccess('/report/progress')),
                     array('label'=>'project summary report', 'url'=>array('/report/summary'),'visible'=>Yii::app()->user->isAccess('/report/summary')),
                     array('label'=>'BSC report', 'url'=>array('/report/bsc'),'visible'=>Yii::app()->user->isAccess('/report/bsc')),
                     array('label'=>'รายงานค่ารับรองโครงการ', 'url'=>array('/report/management'),'visible'=>Yii::app()->user->isAccess('/report/management')),
                    array('label'=>'รายงานรายได้', 'url'=>array('/report/income'),'visible'=>Yii::app()->user->isAccess('/report/income')),
                     array('label'=>'รายงานสรุปรายได้/ค่าใช้จ่าย', 'url'=>array('/report/cashflow'),'visible'=>Yii::app()->user->isAccess('/report/cashflow')),
                     array('label'=>'รายงานสรุปรายได้ ค่าใช้จ่ายงานบริการวิศวกรรม', 'url'=>array('/report/service'),'visible'=>Yii::app()->user->isAccess('/report/service')),
                     array('label'=>'สรุปงานรายรับ-รายจ่ายงานโครงการ', 'url'=>array('/report/summaryCashflow'),'visible'=>Yii::app()->user->isAccess('/report/summaryCashflow')),
                      array('label'=>'รายงานงบกำไรขาดทุน', 'url'=>array('/report/statement'),'visible'=>Yii::app()->user->isAccess('/report/statement')),
                    
                                                                 

                    ),
                ),
                array('label'=>'แจ้งเตือน '.$badge,'icon'=>'comment', 'url'=>array('/notify/index'), 'visible'=>Yii::app()->user->isAccess('/notify/index')),
                array('label'=>'คู่สัญญา','icon'=>'briefcase', 'url'=>array('/vendor/admin'), 'visible'=>Yii::app()->user->isAccess('/vendor/admin')),
                array('label'=>'ประเภทงาน','icon'=>'briefcase', 'url'=>array('/workcategory/admin'), 'visible'=>Yii::app()->user->isAccess('/workcategory/admin')),
                
   
                array('label'=>'ผู้ดูแลระบบ ','icon'=>'eye-open', 'url'=>'#','visible'=>Yii::app()->user->isAccess('/user/index'),'items'=>array(
                    
                     array('label'=>'ผู้ใช้งาน', 'url'=>array('/user/index'),'visible'=>Yii::app()->user->isAccess('/user/index')),
                     array('label'=>'กำหนดสิทธิผู้ใช้งาน', 'url'=>array('/authen/index'),'visible'=>Yii::app()->user->isAccess('/authen/index')),
                     
                    ),
                ),
            ),
        ),    
        array(
            'class'=>'bootstrap.widgets.TbButtonGroup',           
            'htmlOptions'=>array('class'=>'pull-right'),
            'type'=>'success', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons'=>array(
                    array('label'=>Yii::app()->user->title.Yii::app()->user->firstname." ".Yii::app()->user->lastname,'icon'=>Yii::app()->user->usertype, 'url'=>'#'),
                    //array('label'=>Yii::app()->user->username,'icon'=>Yii::app()->user->usertype, 'url'=>'#'),
                    array('items'=>array(
                        array('label'=>'เปลี่ยนรหัสผ่าน','icon'=>'cog', 'url'=>array('/user/password/'.Yii::app()->user->ID), 'visible'=>!Yii::app()->user->isGuest),
                        '---',
                        array('label'=>'ออกจากระบบ','icon'=>'off', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest),
                    )),
                ),
            
        ),
        ),
    ));
 }
else{
    $this->widget('bootstrap.widgets.TbNavbar',array(
    'fixed'=>'top',
    'collapse'=>true,    
    'htmlOptions'=>array('class'=>'noprint'),
    'brand' =>  CHtml::image(Yii::app()->getBaseUrl() . '../images/pea_logo.png', 'Logo', array('width' => '260', 'height' => '30')),
   
    ));
}     
 
   ?>

    <div class="container" id="page" style="padding-top: 70px">

	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>


</div><!-- page -->


<div class="navbar navbar-fixed-bottom">
    <div class="navbar-inner" style="background-color: rgba(0, 0, 0, 0.76);">
        <div class="width-constraint clearfix">
             <p class="muted credit">พัฒนาโดย ฝ่ายบริการวิศวกรรม การไฟฟ้าส่วนภูมิภาค © 2020</p>
     
        </div>
    </div>
</div>
</body>
</html>
