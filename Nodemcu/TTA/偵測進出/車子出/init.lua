m = nil
sign = 0
trigger = 12
device1 = dofile("hcsr04.lua")
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
wifi.sta.config("AndroidAP6012","stormraven")
wifi.sta.connect()
tmr.alarm(1, 2500, tmr.ALARM_AUTO, wifi_wait_ip)
end
function mqtt_register()
    m:subscribe("SmartParking/#",0,function(conn)
    m:publish("SmartParking/SensorState","TTA_OT".."start",2,0)   
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
    m = mqtt.Client("TTA_OT", 120)
	m:lwt("SmartParking/SensorState", "TTA_OT".."offline", 2, 0)
	m:connect("iot.eclipse.org", 1883, 0, 1,  function(conn) 
	mqtt_register()
	mqtt_message() 
    detect_car()  
	end)
end
function detect_car()
     tmr.delay(10000)
     tmr.alarm(0, 1000, tmr.ALARM_AUTO, function()
	 value = device1.measure_avg()	 
	 if (value >= 0 and value <= trigger) then
	   if(sign == 0) then
	      m:publish("SmartParking/Sensor","#0TTA_OT",2,0)  
		  sign = 1	  
	   end	  
	 else
	   sign = 0	 
	 end     
	end)    
end
wifi_start()
