<?php
#Get Deal information 
$vars = array( 
'TerminalNumber'=>'1000', 
'LowProfileCode'=>'f5d12e35-ebce-4c8a-94c6-0ab0f0314069', 
'UserName'=>'barak9611' 
);
 
# encode information
$urlencoded = http_build_query($vars);

#init curl connection
 if( function_exists( "curl_init" )) { 
   $CR = curl_init();
   curl_setopt($CR, CURLOPT_URL, 'https://secure.cardcom.co.il/Interface/BillGoldGetLowProfileIndicator.aspx');
   
   curl_setopt($CR, CURLOPT_POST, 1);
   curl_setopt($CR, CURLOPT_FAILONERROR, true);
   curl_setopt($CR, CURLOPT_POSTFIELDS, $urlencoded );
   curl_setopt($CR, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($CR, CURLOPT_SSL_VERIFYPEER, 0);
   curl_setopt($CR, CURLOPT_FAILONERROR,true);


   #actual curl execution perfom
   $result = curl_exec( $CR );
   $error = curl_error ( $CR );
   # some error , send email to developer
   if( !empty( $error )) {

    echo 'Error: '. $error ;

    return;
  }

   curl_close( $CR );

 }
$output = array();
parse_str($result,$output); # ResponseCode={0}&Description={1}......
if ($output['ResponseCode'] == '0') #  Found the  LowProfile , validate is deal was OK!
{
	#  if $output['DealResponse']  == 0 
  #  if $output['TokenResponse']  == 0 
  #  if $output['InvoiceResponseCode']  == 0 
  #  if $output['InvoiceResponseCode']  == 0 
	#  See : http://kb.cardcom.co.il/article/AA-00240/51/ for more information
	  echo  '$result: '.$result;

}else # some error , send email to developer
{
  echo 'Error : '. $result;
}
?>