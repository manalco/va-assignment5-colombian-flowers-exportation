<?php
  $output = array();
  if (($handle = fopen("assets/data/Cadena_Productiva_Flores_-_Exportaciones.csv.csv", "r")) !== FALSE) {
    $header = array();
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      
    }
    fclose($handle);

    $fp = fopen('assets/data/flowersExp.json', 'w');
    fwrite($fp, json_encode($output));
    fclose($fp);
  }

  function sanitize($temp){
    $temp = str_replace('-.', '-0.', $temp);
    if($temp[0] == '.'){
      $temp = str_replace('.', '0.', $temp);
    }
    return $temp;
  }
?>
<pre><?php print_r($output); ?></pre>