
dofile("hcsr04.lua")
device = hcsr04.init(4, 3, 3)
tmr.alarm(0, 1000, 1, function() print(device.measure_avg()) end)
