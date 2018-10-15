# -*- coding: UTF-8 -*-

import time
import datetime
import calendar

# 时间戳
time_stamp = time.time()
print('time.time() = %s' % time_stamp)

# 时间戳转struct_time类型的本地时间
local_time = time.localtime(time_stamp)
print('time.localtime(%f) = %s' % (time_stamp, local_time))
utc_time = time.gmtime(time_stamp)

# 时间戳转struct_time类型的utc时间
print('time.gmtime(%.2f) = %s' % (time_stamp, utc_time))

# struct_time类型的本地时间转时间戳
time_mktime = time.mktime(local_time)
print('time.mktime(time.localtime(time.time())) = %s' % time_mktime)

# struct_time类型的utc时间转时间戳
time_timegm = calendar.timegm(utc_time)
print('calendar.timegm(time.gmtime(time.time())) = %s' % time_timegm)

# 时间戳转字符串(本地时间字符串)
print('time.ctime(%f) = %s' % (time_stamp, time.ctime(time_stamp)))

# struct_time类型的本地时间转字符串
print('time.asctime(time.localtime(time.time())) = %s' % time.asctime(local_time))

# struct_time类型的utc时间转字符串
print(time.asctime(utc_time))

# struct_time类型的本地时间转字符串：自定义格式
print('time.strftime(local_time): %s' % time.strftime("%Y-%m-%d, %H:%M:%S, %w %z", local_time))

# struct_time类型的utc时间转字符串：自定义格式
print('time.strftime(utc_time):   %s' % time.strftime("%Y-%m-%d, %H:%M:%S, %w %z", utc_time))

# 字符串转struct_time类型
struct_time = time.strptime("2016-11-15, 15:32:12, 2", "%Y-%m-%d, %H:%M:%S, %w")
print('struct_time: %s' % struct_time)

i = datetime.datetime.now()
print('datetime.datetime.now() = %s' % i)
print("ISO格式的日期和时间是 %s" % i.isoformat() )
print("dd/mm/yyyy HH:mm:ss 格式是  %s/%s/%s %s:%s:%s" % (i.day, i.month, i.year, i.hour, i.minute, i.second))

# 获取datetime.datetime类型的本地时间
a_datetime_local = datetime.datetime.now()
# datetime.datetime类型转字符串
print(a_datetime_local.strftime("%Y-%m-%d, %H:%M:%S, %w"))

# 获取datetime.datetime类型的utc时间
a_datetime_utc = datetime.datetime.utcnow()
# datetime.datetime类型转字符串
print(a_datetime_utc.strftime("%Y-%m-%d, %H:%M:%S, %w"))
