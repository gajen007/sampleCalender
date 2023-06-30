<?php

function returnAsJSON($inputArray){
  return json_encode($inputArray);
}

if(
  isset($_GET['clickedYear'])&&
  isset($_GET['clickedMonth'])
  ){
    if (empty($_GET['getYear'])||empty($_GET['getMonth'])) {
      $monthNameAndYear=date("Y")." ".date("F");
        echo returnAsJSON(array(
          'year'=>date("Y"),
          'month'=>date("m"),'monthNameAndYear'=>$monthNameAndYear,
        ));
    }
    else{
      $dateObj   = DateTime::createFromFormat('!m',$_GET['getMonth']);
      $monthNameAndYear=$_GET['getYear']." ".$dateObj->format('F');
        echo returnAsJSON(array(
          'year'=>$_GET['getYear'],
          'month'=>$_GET['getMonth'],
          'monthNameAndYear'=>$monthNameAndYear,
        ));
    }
  }
?>