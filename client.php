<?php


$url = 'https://shayzdev.000webhostapp.com/Payment_to_the_House_Committee/server.php?a=1&b=2';
$post_data = array('c' => '3', 'd' => '4');



$options = array(
        'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($post_data),
    )
);

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);



echo "<pre>";
print_r($result);

?>
