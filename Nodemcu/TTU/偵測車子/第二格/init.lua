m = nil
State = 0
SendGetSign = 0
SendNotGetSign = 0
trigger = 12
device = dofile("hcsr04.lua")
device= hcsr04.init(4, 3, 3)
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
wifi.sta.config("4Clab-asus-2.4G","socad3284")
wifi.sta.connect()
tmr.alarm(1, 2500, tmr.ALARM_AUTO, wifi_wait_ip)
end
function mqtt_register()
    --m:subscribe("SmartParking/#",0,function(conn)
    m:publish("SmartParking/SensorState","TTU002".."start",2,0)   
    --end)
end
function mqtt_message()
  m:on("message", function(conn, topic, data)
    if data ~= nil then
	  print(topic .. ": " .. data)
	end
  end)
end
function mqtt_start()
    m = mqtt.Client("TTU002", 120)
	m:lwt("SmartParking/SensorState", "TTU002".."offline", 2, 0)
	m:connect("iot.eclipse.org", 1883, 0, 1,  function(conn) 
	mqtt_register()	
    detect_car()  
	end)
end
function detect_car()
   tmr.delay(10000)
   tmr.alarm(0, 3000, tmr.ALARM_AUTO, function()   
     if(State == 0) then 
       if (device.measure_avg() <= trigger) then           
            State = 1
       elseif (device.measure_avg() > trigger) or (device.measure_avg() == -1) then           
            State = 0            
       end
     elseif (State == 1) then         
       tmr.delay(3000)
       if(device.measure_avg() <= trigger) then  
            if(SendGetSign == 0) then			    
                m:publish("SmartParking/Sensor","#2".."TTU002",2,0)                 
                SendGetSign = 1
                SendNotGetSign = 0				
            end     
       elseif(device.measure_avg() > trigger) or (device.measure_avg() == -1) then 
            if (SendNotGetSign == 0 and SendGetSign == 1) then			   
                m:publish("SmartParking/Sensor","#3".."TTU002",2,0)               
                SendGetSign = 0
                SendNotGetSign = 1				
           end     
           State = 0    
       end      
     end   
   end) 
end
wifi_start()
