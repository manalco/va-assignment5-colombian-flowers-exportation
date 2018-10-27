<?php
  //$years = [2006,2009,2010,2011,2012,2013];
  $years = [2014,2015,2016,2017,2018];
  foreach ($years as $key => $year) {
    $output = array();
    $output[] = array('name'=> 'Colombia.Colombia');
    $output[] = array('name'=> 'Africa.Africa');
    $output[] = array('name'=> 'Americas.Americas');
    $output[] = array('name'=> 'Asia.Asia');
    $output[] = array('name'=> 'Europe.Europe');
    $output[] = array('name'=> 'Oceania.Oceania');
    $rels = array();
    $countries = array();
    $max = 0;
    $min = 99999999999;
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

          if($d['Anio'] == $year){
            if(isset($rels[$d['DepartamentoOrigen']])){
              if(!in_array($d['PaisDestino'], $rels[$d['DepartamentoOrigen']])){
                $rels[$d['DepartamentoOrigen']][] = $d['PaisDestino'];
              }
            }else{
              $rels[$d['DepartamentoOrigen']] = array($d['PaisDestino']);
            }
            $output[$d['DepartamentoOrigen']]['name'] = 'Colombia.'.$d['DepartamentoOrigen'];
            $output[$d['DepartamentoOrigen']]['exports'] = $rels[$d['DepartamentoOrigen']];
            $output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']] = isset($output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']]) ? ($output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']] + $d['ValorMilesPesos']) : ($d['ValorMilesPesos']);
            
            $countries[$d['PaisDestino']] = array(
              'name' => $d['PaisDestino'],
              'exports' => array()
            );

            if($max < $output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']]){
              $max = $output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']];
            }
            if($min > $output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']] && $output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']] > 0){
              $min = $output[$d['DepartamentoOrigen']]['qty'][$d['PaisDestino']];
            }
          }
        }
      }
      
      //print"<pre>";print_r($rels);die();print"</pre>";
      fclose($handle);
      $output[] = array('name'=> 'Colombia.PFTZ.Colombian PFTZ');
      $temp = array();
      foreach ($output as $key => $value) {
        $temp[] = $value;
      }
      print "MAX: ".$max."<br/>";
      print "MIN: ".$min;
      $output = $temp;
      $temp = array();
      foreach ($countries as $key => $value) {
        $temp[] = $value;
      }
      $countries = $temp;
      $output = array_merge($output,$countries);

      $fp = fopen('assets/data/flowersExp-'.$year.'.json', 'w');
      fwrite($fp, json_encode($output));
      fclose($fp);
    }
    print"<pre>"; print_r($year); print" Processed</pre>";
  }
?>