<?php
  $output = array();
  $rels = array();
  $countries = array();
  if (($handle = fopen("assets/data/Cadena_Productiva_Flores_-_Exportaciones.csv", "r")) !== FALSE) {
    $header = array();
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
      if(empty($header)){
        $header = $data;
      }else{
        $d = array();
        $row = array();
        foreach ($data as $key => $value) {
          $d[$header[$key]] = $value;
        }

        if(isset($rels[$d['DepartamentoOrigen']])){
          if(!in_array($d['PaisDestino'], $rels[$d['DepartamentoOrigen']])){
            $rels[$d['DepartamentoOrigen']][] = $d['PaisDestino'];
          }
        }else{
          $rels[$d['DepartamentoOrigen']] = array($d['PaisDestino']);
        }
        $output[$d['DepartamentoOrigen'].'-'.$d['PaisDestino']] = array(
          'name' => 'Colombia.'.$d['DepartamentoOrigen'],
          'exports' => $rels[$d['DepartamentoOrigen']],
          'qty' => isset($output[$d['DepartamentoOrigen'].'-'.$d['PaisDestino']]['qty']) ? $output[$d['DepartamentoOrigen'].'-'.$d['PaisDestino']]['qty'] + $d['CantidadUnidades'] : $d['CantidadUnidades']
        );
        $countries[$d['PaisDestino']] = array(
          'name' => $d['PaisDestino'],
          'exports' => array()
        );
      }
    }
    //print"<pre>";print_r($rels);die();print"</pre>";
    fclose($handle);
    $temp = array();
    foreach ($output as $key => $value) {
      $temp[] = $value;
    }
    $output = $temp;
    $temp = array();
    foreach ($countries as $key => $value) {
      $temp[] = $value;
    }
    $countries = $temp;
    $output = array_merge($output,$countries);

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