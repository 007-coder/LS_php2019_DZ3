<?php 

function wrap_pre($data) {
  echo '<pre>'.print_r($data, true).'</pre>';
}

function task1($xmlObj) {
  $html = '';
  //
  $orderAttributes = $xmlObj->attributes();
  $orderAddress = $xmlObj->Address;       
  $orderItems = $xmlObj->Items->Item;
  //
  $orderNumber = (isset($orderAttributes['PurchaseOrderNumber'])) ? '# '.$orderAttributes['PurchaseOrderNumber'] : '';
  $orderDate = (isset($orderAttributes['OrderDate'])) ? ' от '.$orderAttributes['OrderDate'] : '';

  $html .= 
  '<hr><h2>Заказ '.$orderNumber.$orderDate.'</h2><hr>';


  // Адрес доставки НАЧАЛО
  if (count($orderAddress)) {
    $html .= 
    '<h4>Адресс</h4>';

    if ($xmlObj->DeliveryNotes !='') {
      $html .= 
      '<p>Комментарии для доставки: <b>'.$xmlObj->DeliveryNotes.'</b></p>';   
    }

    $html .= 
    '<table width="100%">
      <tbody>
        <tr>';   

        $addrAttrNames = [
          'Type'=>'Тип'
        ];
        $addrLabels = [
          'Name'=>'Имя',
          'Street'=>'Улица',
          'City'=>'Город',
          'State'=>'Область',
          'Zip'=>'Почтовый индекс',
          'Country'=>'Страна',
        ];

        // Order Address HTML
        foreach ($orderAddress as $adressVal) {

          $addrAttr = $adressVal->attributes();
          $addrAttrStr = '';

          if (count($addrAttr)) {
            $addrAttrStr .= '<p>';                  
            $a = 0;
            foreach ($addrAttr as $k => $AASval) {
              $a++;
              $coma = (count($addrAttr) === $a) ? '' : ', ';
              $addrAttrStr .= $addrAttrNames[$k].': <b><u>'.$AASval.$coma.'</u></b>';
            }
            $addrAttrStr .= '</p>';                  
          }

          
          $html .= 
          '<td width="50%">';
            $html .= $addrAttrStr;
            foreach ($adressVal as $ka => $aVal) {
              $html .= '<p>'.$addrLabels[$ka].': <b>'.$aVal.'</b></p>';
            } 
          $html .= 
          '</td>';
        }

    $html .= 
    '   </tr> 
      </tbody>
    </table>';

    $html .= '<hr>';

  }
  // Адрес доставки КОНЕЦ

  // Товары НАЧАЛО
  if (count($orderItems)) {
    $html .= 
    '<h4>Товары в заказе</h4>';

    $html .= 
    '<ol>';

    foreach ($orderItems as $orItem) {

      $orItemAttr = $orItem->attributes();         

      $html .= 
      '<li>';
        $html .=
        '<p>Номер партии: <b>'.$orItemAttr['PartNumber'].'</b></p>';

        $orItemLabels = [
          'ProductName'=>'Название товара',
          'Quantity'=>'Кол-во',
          'USPrice'=>'Цена в USD',
          'Comment'=>'Комментарий',
          'ShipDate'=>'Дата поставки'                
        ];
        foreach ($orItem as $ki => $oiVal) {
          $html .= '<p>'.$orItemLabels[$ki].': <b>'.$oiVal.'</b></p>';
        }

      $html .= 
      '</li>';
    }

    $html .= 
    '</ol>';

    $html .= '<hr>';

  }
  // Товары КОНЕЦ        

  return $html;

}



//array_diff_assoc_recursive
function task2($array1, $array2)
{
  foreach($array1 as $key => $value)
  {
    if(is_array($value))
    {
      if(!isset($array2[$key]))
      {
        $difference[$key] = $value;
      }
      elseif(!is_array($array2[$key]))
      {
        $difference[$key] = $value;
      }
      else
      {
        $new_diff = task2($value, $array2[$key]);
        if($new_diff != FALSE)
        {
          $difference[$key] = $new_diff;
        }
      }
    }

    elseif(!isset($array2[$key]) || $array2[$key] != $value)
    {
      $difference[$key] = $value;
    }
  }
  return (!isset($difference)) ? 0 : $difference;
}


function task3($csvFile, $countItems) {
  $summ = $csvSumm =  0;

  for ($i=0; $i < $countItems ; $i++) {       
    $num = rand(1,100);
    $data[] = $num;      
    /*if ($num % 2 === 0) {
      $summ += $num;
    }*/      
  }    
  $toCSVstr = implode(';', $data)."\n";

  file_put_contents($csvFile, $toCSVstr);

  $fp = fopen($csvFile, 'r');
  if (!$fp) {
    echo 'cannot read csv file';
  } else {
    while ($val = fgetcsv($fp, 1000*1024, ';')) {
      foreach ($val as $number) {
        if ((int)$number % 2 === 0) {
          $csvSumm += (int)$number;
        }
      }
      

      //wrap_pre($val);

    }
  }  

  return $csvSumm;

}




function process_array ($in, $out = [], $prefix = '') {
    foreach ($in as $key => $value) {
        if (is_array($value)) {
            $out = array_merge($out, process_array($value, $out, $prefix . $key . '|'));
        }
        else {
            $out["{$prefix}{$key}"] = $value;
        }
    }

    return $out;
}
