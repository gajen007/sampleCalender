<html>
<head>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
</head>
<body>
<?php
  $chosenYear="0";
  $chosenMonth="0";
  if (isset($_GET['chosenYear'])&&isset($_GET['chosenMonth'])) {
    $chosenYear=$_GET['chosenYear'];
    $chosenMonth=$_GET['chosenMonth'];
  }
  else{
    $chosenYear=date("Y");
    $chosenMonth=date("m");
  }
?>

<div class="row" style="margin:1%;">
	<div class="col-lg-12">
		<table class="table table-bordered">
			<tr><td align="center" colspan="7" id="monthAndYear"></td></tr>
			<tr><td class="border-right border-bottom-0" align="center"><button class="btn btn-danger btn-sm" disabled>Sun</button></td>
				<td class="border-right border-bottom-0" align="center"><button class="btn btn-success btn-sm" disabled>Mon</button></td>
				<td class="border-right border-bottom-0" align="center"><button class="btn btn-success btn-sm" disabled>Tue</button></td>
				<td class="border-right border-bottom-0" align="center"><button class="btn btn-success btn-sm" disabled>Wed</button></td>
				<td class="border-right border-bottom-0" align="center"><button class="btn btn-success btn-sm" disabled>Thu</button></td>
				<td class="border-right border-bottom-0" align="center"><button class="btn btn-success btn-sm" disabled>Fri</button></td>
				<td class="border-right border-bottom-0" align="center"><button class="btn btn-warning btn-sm" disabled>Sat</button></td>
				
			</tr>
			<tr id='week_1'><td class="border-right border-bottom-0 sun"></td><td class="border-right border-bottom-0 mon"></td><td class="border-right border-bottom-0 tue"></td><td class="border-right border-bottom-0 wed"></td><td class="border-right border-bottom-0 thu"></td><td class="border-right border-bottom-0 fri"></td><td class="border-right border-bottom-0 sat"></td></tr>
			<tr id='week_2'><td class="border-right border-bottom-0 sun"></td><td class="border-right border-bottom-0 mon"></td><td class="border-right border-bottom-0 tue"></td><td class="border-right border-bottom-0 wed"></td><td class="border-right border-bottom-0 thu"></td><td class="border-right border-bottom-0 fri"></td><td class="border-right border-bottom-0 sat"></td></tr>
			<tr id='week_3'><td class="border-right border-bottom-0 sun"></td><td class="border-right border-bottom-0 mon"></td><td class="border-right border-bottom-0 tue"></td><td class="border-right border-bottom-0 wed"></td><td class="border-right border-bottom-0 thu"></td><td class="border-right border-bottom-0 fri"></td><td class="border-right border-bottom-0 sat"></td></tr>
			<tr id='week_4'><td class="border-right border-bottom-0 sun"></td><td class="border-right border-bottom-0 mon"></td><td class="border-right border-bottom-0 tue"></td><td class="border-right border-bottom-0 wed"></td><td class="border-right border-bottom-0 thu"></td><td class="border-right border-bottom-0 fri"></td><td class="border-right border-bottom-0 sat"></td></tr>
			<tr id='week_5'><td class="border-right border-bottom-0 sun"></td><td class="border-right border-bottom-0 mon"></td><td class="border-right border-bottom-0 tue"></td><td class="border-right border-bottom-0 wed"></td><td class="border-right border-bottom-0 thu"></td><td class="border-right border-bottom-0 fri"></td><td class="border-right border-bottom-0 sat"></td></tr>
			<tr id='week_6'><td class="border-right border-bottom-0 sun"></td><td class="border-right border-bottom-0 mon"></td><td class="border-right border-bottom-0 tue"></td><td class="border-right border-bottom-0 wed"></td><td class="border-right border-bottom-0 thu"></td><td class="border-right border-bottom-0 fri"></td><td class="border-right border-bottom-0 sat"></td></tr>
		</table>		
	</div>
</div>

<script src="jquery/jquery-3.7.0.min.js"></script>
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
  function addZeroForMonthNumber(str){
    if (str.length==1) { return "0"+str; }
    else{ return str; }
  }

  function showCalender(){
    fetch("http://localhost/aravin/backend.php?clickedYear="+<?php echo $chosenYear; ?>+"&clickedMonth="+<?php echo $chosenMonth; ?>+"",{
          method:'GET',
          mode: 'no-cors',
          cache: 'no-cache'})
        .then(response => {
          if (response.status == 200) {
            return response.json();            
          }
          else {
            alert('Backend Error..!');
            console.log(response);
          }
        })
        .then(data => {
        $("#monthAndYear").html(data.monthNameAndYear);
        let monthLength=0;
        let y = data.year; let n = data.month;
        let monthName="";
    if (n!="02") {
    	switch(n){
    		case "01":monthLength=31; monthName="January"; break;
    		case "03":monthLength=31; monthName="March"; break;
    		case "04":monthLength=30; monthName="April"; break;
    		case "05":monthLength=31; monthName="May"; break;
    		case "06":monthLength=30; monthName="June"; break;
    		case "07":monthLength=31; monthName="July"; break;
    		case "08":monthLength=31; monthName="August"; break;
    		case "09":monthLength=30; monthName="September"; break;
    		case "10":monthLength=31; monthName="October"; break;
    		case "11":monthLength=30; monthName="November"; break;
    		case "12":monthLength=31; monthName="December"; break;
    	}
    }
    else{
    	monthLength=28; monthName="February";
    }
    let curWeek=1;
    let dayClass="";
    
    for (var i = 1; i <=monthLength; i++) {
      var dateAsString="";
      var toStr=i.toString();
      if (toStr.length!=2){ dateAsString="0"+toStr; }
      else{ dateAsString=toStr; }
      let dt=new Date(monthName+" "+dateAsString+", "+y.toString());
      switch(dt.getDay()+1){
        case 1:dayClass="sun";  if(i!=1){curWeek=curWeek+1;} break;
        case 2:dayClass="mon"; break;
        case 3:dayClass="tue"; break;
        case 4:dayClass="wed"; break;
        case 5:dayClass="thu"; break;
        case 6:dayClass="fri"; break;
        case 7:dayClass="sat"; break;
      }
      $("#week_"+curWeek+" ."+dayClass).append("<span class='day' style='line-height: 20px; display: block; color: #aaa; float:right'>"+dateAsString+"</span><span class='contents' style='position: relative; top: -5px;' id='day_"+dateAsString+"'></span>");
            var selectedYear="<?php echo date('Y'); ?>";
            var selectedMonth=(new Date().getMonth())+1;
            if ((i==(new Date().getDate()))&&(selectedYear==(new Date().getFullYear()))&&(data.month==addZeroForMonthNumber(selectedMonth))) {
              $("#week_"+curWeek+" ."+dayClass).css("background-color","yellow");
          }
    }          
        })
        .catch((e) => {
          console.log(e);
          alert("Exception; check console!");
        });
  }

  function deriveAppointments(){
    fetch("http://localhost/aravin/backend.php?lookupMonth="+<?php echo $chosenMonth; ?>+"&lookupYear="+<?php echo $chosenYear; ?>+"&employeeID=3",{
          method:'GET',
          mode: 'no-cors',
          cache: 'no-cache'})
        .then(response => {
          if (response.status == 200) {
            return response.json();            
          }
          else {
            alert('Backend Error..!');
            console.log(response);
          }
        })
        .then(data => {
          data.forEach(function(a){
            var j=a.appDate;
            var dateAsString=j.substring(8,j.length);
            $("#day_"+dateAsString).append("<button class='btn btn-sm border-dark' style='margin:0.5%; font-size:12px !important' data-toggle='tooltip' title='"+a.customerName+"'>"+a.customerName+"<br><strong>"+a.StartTime+"-"+a.EndTime+"</strong><br></button><br>");
          });
        })
        .catch((e) => {
          console.log(e);
          alert("Exception; check console!");
        });
  }

  $(document).ready(function(){
    showCalender();
    deriveAppointments();
  });
</script>
</body>
</html>