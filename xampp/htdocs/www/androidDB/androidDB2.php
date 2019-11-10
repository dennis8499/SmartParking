<html>
<script type="text/javascript">
var xmlHTTP1;
var xmlHTTP2;
var xmlHTTP3;
var xmlHTTP4;
var xmlHTTP5;
setInterval(remainder_space, 5000);
setInterval(total_amount, 5000);
setInterval(block1, 5000);		
setInterval(block2, 5000);	
setInterval(block3, 5000);	


function total_amount()
{    	
	if(window.ActiveXObject)
	{
		xmlHTTP1=new ActiveXObject("Microsoft.XMLHTTP");
		
	}
	else if(window.XMLHttpRequest)
	{
		xmlHTTP1=new XMLHttpRequest();			
	}
	 xmlHTTP1.open("GET","http://192.168.43.108:80/www/androidDB/androidDB2_total.php",true);
	  
	xmlHTTP1.onreadystatechange=function check_user()
	{
		if(xmlHTTP1.readyState == 4)
		{
			if(xmlHTTP1.status == 200)
			{
				var str=xmlHTTP1.responseText;
				 document.getElementById("Total_amount").innerHTML=str;
			}
		}
	}
	xmlHTTP1.send(null);
}


function remainder_space()
{    	
if(window.ActiveXObject)
	{
		xmlHTTP2=new ActiveXObject("Microsoft.XMLHTTP");
		
	}
	else if(window.XMLHttpRequest)
	{
		xmlHTTP2=new XMLHttpRequest();			
	}
xmlHTTP2.open("GET","http://192.168.43.108:80/www/androidDB/androidDB2_remainder.php",true);
	
	xmlHTTP2.onreadystatechange=function check_user()
	{
		if(xmlHTTP2.readyState == 4)
		{
			if(xmlHTTP2.status == 200)
			{
				var str=xmlHTTP2.responseText;
				document.getElementById("Remainder_space").innerHTML=str;
			}
		}
	}
	xmlHTTP2.send(null);
}


function block1()
{    	
if(window.ActiveXObject)
	{
		xmlHTTP3=new ActiveXObject("Microsoft.XMLHTTP");
		
	}
	else if(window.XMLHttpRequest)
	{
		xmlHTTP3=new XMLHttpRequest();			
	}
xmlHTTP3.open("GET","http://192.168.43.108:80/www/androidDB/androidDB2_block1.php",true);

	xmlHTTP3.onreadystatechange=function check_user()
	{
		if(xmlHTTP3.readyState == 4)
		{
			if(xmlHTTP3.status == 200)
			{
				var str=xmlHTTP3.responseText;
				document.getElementById("ttu1").innerHTML=str;
			}
		}
	}
	xmlHTTP3.send(null);
}	

function block2()
{    	
if(window.ActiveXObject)
	{
		xmlHTTP4=new ActiveXObject("Microsoft.XMLHTTP");
		
	}
	else if(window.XMLHttpRequest)
	{
		xmlHTTP4=new XMLHttpRequest();			
	}
xmlHTTP4.open("GET","http://192.168.43.108:80/www/androidDB/androidDB2_block2.php",true);
    
	xmlHTTP4.onreadystatechange=function check_user()
	{
		if(xmlHTTP4.readyState == 4)
		{
			if(xmlHTTP4.status == 200)
			{
				var str=xmlHTTP4.responseText;
				document.getElementById("ttu2").innerHTML=str;
			}
		}
	}
	xmlHTTP4.send(null);
}	

function block3()
{    	
if(window.ActiveXObject)
	{
		xmlHTTP5=new ActiveXObject("Microsoft.XMLHTTP");
		
	}
	else if(window.XMLHttpRequest)
	{
		xmlHTTP5=new XMLHttpRequest();			
	}
xmlHTTP5.open("GET","http://192.168.43.108:80/www/androidDB/androidDB2_block3.php",true);
	
	xmlHTTP5.onreadystatechange=function check_user()
	{
		if(xmlHTTP5.readyState == 4)
		{
			if(xmlHTTP5.status == 200)
			{
				var str=xmlHTTP5.responseText;				
				document.getElementById("ttu3").innerHTML = str;				
			}
		}
	}
	xmlHTTP5.send(null);
}	
</script>
<body style="background-color:black;">

<table style="color:white">
<tr>
<th>名稱:</th>
<th>狀態:</th>
</tr>
<tr>
<td>總車輛數:</td>
<td><span id="Total_amount" style="color:white"></span></td>
</tr>
<tr>
<td>剩餘空間:</td>
<td><span id="Remainder_space" style="color:white"></span></td>
</tr>
<tr>
<td>第一格:</td>
<td><span id="ttu1" style="color:white"></span></td>
</tr>
<tr>
<td>第二格:</td>
<td><span id="ttu2" style="color:white"></span></td>
</tr>
<tr>
<td>第三格:</td>
<td><span id="ttu3" style="color:white"></span>	</td>
</tr>
</table>
</body>





</html>
