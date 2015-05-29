function  chooseType () {
   
	var name;

 	if(confirm("are you sure"))
    	{
	  name=prompt("input your name");
          location.href="add_user.php";
    	}
    	else
   	{
	  alert('think again');
	  exit();
	}
	
	if (name) {
	  alert('welcome'+name);
	}


}

function clickButton() 
{

var inputs = document.getElementsByTagName("INPUT");

 var arrival, departure;

 for (var i=0; i < inputs.length; i++) {
		
  if (inputs[i].name == 'arrival') {
	arrival = inputs[i].value;	
  }

  if (inputs[i].name == 'departure') {
	departure = inputs[i].value;
  }

 }

 var duration = calc_duration(arrival, departure);
    
    if (duration > 28) {
    
        alert('Your stay (' + duration + ') is longger than 28 days, you need to pay extra for lodge!');
    } else {
        alert('Your stay is ' + duration + ' days');
    }

}


function calc_duration(arrival, departure) {
	var arr = arrival.split('-');
	var dep = departure.split('-');
		
	var months = [31,28, 31,30,31,30,31,31,30,31,30,31];
    
   var year_a = parseInt(arr[0]);
   var year_d = parseInt(dep[0]);
   var month_a = parseInt(arr[1]);
   var month_d = parseInt(dep[1]);
   var day_a = parseInt(arr[2]);
   var day_d = parseInt(dep[2]);
  
  var sum = year_a + year_d + month_a + month_d + day_a + day_d;


	var duration;	
	duration  = (year_d-year_a)*365 + (month_d - month_a)*30 + day_d - day_a;
  
	if (month_a != month_d) {
		duration = duration +  months[month_a-1] - 30;
	}

	return duration;
}


function showHint(str) {

	//alert("str="+str);	

   if (str.length == 0) { 
        document.getElementById("txtHint").innerHTML = "s";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "gethint.php?q=" + str, true);
        xmlhttp.send();
    }
}



function jumpto(x) {
	if (document.form1.jumpmenu.value != "null") {
		document.location.href = x;
	}
}



function addCode(id) {
	
	$.get("areaCodeAjax.php",
			{id:id},
			function(data) {
				$("div#type").html(data);
			},
			"html");

}


function alert_msg(id) {
    alert("msg="+id);

}
