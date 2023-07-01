<?php

function returnAsJSON($inputArray){
  return json_encode($inputArray);
}

function connectDatabase(){
  $host="localhost";
  $un="phpmyadmin";
  $pw="gajen";
  $database="forAravin";
  return new mysqli($host,$un,$pw,$database);
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

if(
  isset($_GET['lookupMonth'])&&
  isset($_GET['lookupYear'])&&
  isset($_GET['employeeID'])
){
  $connection=connectDatabase();
  $lookupMonth=$_GET['lookupMonth'];
  $lookupYear=$_GET['lookupYear'];
  $employeeID=$_GET['employeeID'];
  $sql = "SELECT 
  a.AppointmentId,a.CustomerId,a.EmployeeId,a.Date as appDate,a.StartTime,a.EndTime,a.AppointmentStatus,a.ReservationNumber,a.TotalPrice,
  customer.UserId, customer.UserName, CONCAT(customer.Title,'.',customer.FirstName,' ',customer.LastName) as customerName, customer.Gender
  FROM tbl_appointments a
  JOIN tbl_users customer ON customer.UserId=a.CustomerId
  JOIN tbl_users staff ON staff.UserId=a.EmployeeId
  WHERE YEAR(a.Date)='$lookupYear' AND MONTH(a.Date)='$lookupMonth' AND a.EmployeeId='$employeeID'
  ";
  $result=$connection->query($sql);
  echo returnAsJSON(mysqli_fetch_all ($result, MYSQLI_ASSOC));
}

?>