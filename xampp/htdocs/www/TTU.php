<html>
    <script>
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
         xmlHTTP1.open("GET","TTU_total.php",true);
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
    xmlHTTP2.open("GET","TTU_remainder.php",true);
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
    xmlHTTP3.open("GET","TTU_block1.php",true);
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
    xmlHTTP4.open("GET","TTU_block2.php",true);
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
    xmlHTTP5.open("GET","TTU_block3.php",true);
        xmlHTTP5.onreadystatechange=function check_user()
        {
            if(xmlHTTP5.readyState == 4)
            {
                if(xmlHTTP5.status == 200)
                {
                    var str=xmlHTTP5.responseText;
                    document.getElementById("ttu3").innerHTML=str;
                }
            }
        }
        xmlHTTP5.send(null);
    }	
	</script>
	<head>
		<title>TTU</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" href="css/main.css" />
	</head>
	<body>
		<div id="wrapper">
		<!-- Header -->
					<header id="header">						
						<h1><a href="index.php">TTU</a></h1>
						<ul class="icons">
							<li><a href="index.php" class="icon style2 fa-home">Home</a></li>	
						</ul>
					</header>				
		<!-- One -->
		<section id = "main">
		<table class="mistab" width="90%" align="center">
		<tr>
		  <th width="15%">總人數: <div id="Total_amount"></div></th>	 
	      <th width="15%">剩餘空間: <div id="Remainder_space"></div></th>
		</tr>		
		</table>
		<table border="0" width="90%" align="center" cellspacing="0" cellpadding="2">
		 <tr>
		 <td>
		 <div>
		   <img src = "parking/TTU001BG.jpg" alt=""  style="position:absolute;left:70px;">
		   <span id="ttu1"></span>
		   <span id="ttu2"></span>
		   <span id="ttu3"></span>		  
		 </div>
		 </td>
		 </tr>		 
		</table>		  
		</section>		   
		<!-- Footer -->
			<footer id="footer">
						<p>Created by TTU I102 Smartparking</p>
					</footer>
	    </div>
		<!-- Scripts -->
			<script src="js/jquery.min.js"></script>
			<script src="js/jquery.poptrox.min.js"></script>
			<script src="js/skel.min.js"></script>
			<script src="js/main.js"></script>

	</body>
</html>