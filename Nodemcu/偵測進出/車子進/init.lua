m = nil
sign = 0
dofile("hcsr04.lua")
device1 = hcsr04.init(4, 3, 3) 
function wifi_wait_ip()  
  if wifi.sta.getip()== nil then
    print("IP unavailable, Waiting...")
  else
    tmr.stop(1)
    print("\n====================================")
    print("ESP8266 mode is: " .. wifi.getmode())
    print("MAC address is: " .. wifi.ap.getmac())
    print("IP is "..wifi.sta.getip())
    print("====================================")
    mqtt_start()    
  end
end
function wifi_start()
wifi.setmode(wifi.STATION);
wifi.sta.config("AndroidAP","0988800711")
wifi.sta.connect()
tmr.alarm(1, 2500, tmr.ALARM_AUTO, wifi_wait_ip)
end
function mqtt_register()
    m:subscribe("SmartParking/Sensor",0,function(conn)
    m:publish("SmartParking/Sensor","Successfully subscribed to data endpoint",0,0)
    print("Successfully subscribed to data endpoint")
    end)
end
function mqtt_message()
  m:on("message", function(conn, topic, data)
    if data ~= nil then
	  print(topic .. ": " .. data)
	end
  end)
end
function mqtt_start()
    m = mqtt.Client("TTU_Input", 120)
	m:connect("iot.eclipse.org", 1883, 0, 0,  function(conn) 
	mqtt_register()
	mqtt_message() 
    detect_car()  
	end)
end
function detect_car()
     tmr.delay(10000)
     tmr.alarm(0, 1000, tmr.ALARM_AUTO, function()
	 value = device1.measure()	 
	 if (value >= 0 and value <= 12) then
	   if(sign == 0) then
	      m:publish("SmartParking/Sensor","#1TTU_Input",0,0)  
		  sign = 1	  
	   end	  
	 else
	   sign = 0	 
	 end     
	 end)    
end
wifi_start()
