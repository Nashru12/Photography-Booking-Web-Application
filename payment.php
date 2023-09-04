<?php

$nama=$_POST['package_name'];
$email=$_POST['email'];
$telefon=$_POST['phone_number'];
$harga=$_POST['package_price'];
$rm=($harga*100);
$some_data = array(
    'userSecretKey'=> 'dyxj3ymw-wqzh-tmjy-bcuv-6jzxrbsb950t',
    'categoryCode'=> '4vvt3fmu',
    'billName'=> 'Ketawariang Studio Services',
    'billDescription'=> 'Your chosen package '.$nama,
    'billPriceSetting'=>$rm,
    'billPayorInfo'=>1,
    'billAmount'=>$rm,
    'billReturnUrl'=>'http://localhost/KetawariangStudio/cust-dashboard.php',
    'billCallbackUrl'=>'',
    'billExternalReferenceNo'=>'',
    'billTo'=>$nama,
    'billEmail'=>$email,
    'billPhone'=>$telefon,
    'billSplitPayment'=>0,
    'billSplitPaymentArgs'=>'',
    'billPaymentChannel'=>0,
  );  
  $curl = curl_init();
  curl_setopt($curl, CURLOPT_POST, 1);
  curl_setopt($curl, CURLOPT_URL, 'https://toyyibpay.com/index.php/api/createBill');  
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl, CURLOPT_POSTFIELDS, $some_data);
  $result = curl_exec($curl);
  $info = curl_getinfo($curl);  
  curl_close($curl);
  $obj = json_decode($result,true);
  $billcode=$obj[0]['BillCode'];
?>
<!--SEND USER TO TOYYIBPAY PAYMENT-->
<script type="text/javascript">
   window.location.href="https://toyyibpay.com/<?php echo $billcode;?>"; 
 </script>