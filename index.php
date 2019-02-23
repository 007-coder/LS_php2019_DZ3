<?php 
define('DS', DIRECTORY_SEPARATOR);
require_once (__DIR__.DS.'src'.DS.'functions.php');

$exName = 'ДЗ3';
?>

<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <title>LoftSchool <?php echo $exName ?>. Вакуленко Юрий. vakulenkoyura211@gmail.com</title>
  <meta name="description" content="">
  <meta name="author" content="Вакуленко Юрий. vakulenkoyura211@gmail.com">
</head>

<body>

  <h1>Домашнее задание <?php echo $exName ?></h1>
  <h4>Вакуленко Юрий. vakulenkoyura211@gmail.com</h4>

  <h3>Задание #1</h3>  
  <?php
    $file = __DIR__.DS.'src'.DS.'data.xml';

    if (file_exists($file)) {

      $xmlData = file_get_contents($file);
      //      
      $xmlObj = simplexml_load_file($file);

      if (empty($xmlObj)) {
        echo 'Файл с данными пуст.';
      }
      else {
         echo task1($xmlObj);        
      } 

    } 
    // else for if (file_exists)
    else {
      echo 'Основной файл с данными не существует! Нечего обрабатывать.';
    }

    ?> 
  
    <h3>Задание #2</h3>
    <?php 
    $jData = [
      'key1'=>'data1',
      'key2'=>'data2',
      'key3'=> [
        'ks1'=>'tra-ta-ta',
        'ks2'=>'tra-ta-ta222',
        'ks3'=>[
          'megaBomb'=>'Boom',
          'megaBomb2'=>'Boom2',
        ]
      ]
    ];
    

    $JSONjData = json_encode($jData);
    $file0 = __DIR__.DS.'src'.DS.'output.json';
    $file2 = __DIR__.DS.'src'.DS.'output2.json';
    $file1JSONdata = '';

    if (!file_exists($file0)) {
      file_put_contents(__DIR__.DS.'src'.DS.'output.json', $JSONjData);
    } 
    else {
      $file1 = file_get_contents($file0);
          
      $JSONfromFile1 = json_decode($file1,true);

      if (rand(0,1)) {        
        $JSONfromFile1['key3']['ks3']['megaBomb'] = 'NEW BadaBoom';
        $JSONfromFile1['key3']['ks3']['megaBomb2'] = 'NEW BadaBoom';
      }     

      file_put_contents($file2, json_encode($JSONfromFile1));


      $file0Content = file_get_contents($file0);
      $file2Content = file_get_contents($file2);      

      $JSONfromFile0 = json_decode($file0Content,true);
      $JSONfromFile2 = json_decode($file2Content,true);

      echo '<h4>output.json</h4>';
      wrap_pre($JSONfromFile0);
      echo '<h4>output2.json</h4>';
      wrap_pre($JSONfromFile2);


      echo '<pre> Расхождение: '.print_r(task2($JSONfromFile0, $JSONfromFile2), true).'</pre>';
    } 
    
    ?>

    <h3>Задание #3</h3>
    <?php 
    echo '<b>'.task3(__DIR__.DS.'src'.DS.'task3.csv', 60).'</b><br>';
    ?>



    <h3>Задание #4</h3>
    <?php 
    $urlData = file_get_contents('https://en.wikipedia.org/w/api.php?action=query&titles=Main%20Page&prop=revisions&r
vprop=content&format=json');

    if ($urlData !='') {      

      function myFind($value, $key) {
        if (in_array($key, ['title', 'pageid'])) {
          echo "<b>$key</b> -  <i>$value</i><br>";  
        }
      }
      $urlJSONDec = json_decode($urlData, true);
      array_walk_recursive($urlJSONDec, 'myFind');      

    }
    ?>



    

    

    



</body>

</html>
