#!/usr/bin/env python
# -*- coding: utf-8 -*-

import sys
reload(sys)
sys.setdefaultencoding("utf-8")
from bs4 import BeautifulSoup
import requests
import pymysql

conn = pymysql.connect(host='localhost',user='sql_Weather',
                        passwd='hellojosie',db='sql_Weather',port=3306,
                        charset='utf8')
cursor = conn.cursor()
sql = "TRUNCATE TABLE Weather"
try:
    cursor.execute(sql)
    conn.commit()
except:
    print "Error:unable to delete"
    
def get_temperature(url):
    headers={
            'User-Agent':'Mozilla/5.0(Windows NT 10.0; Win64;x64)AppleWebkit/537.36(KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36'}
    response = requests.get(url,headers=headers).content
    soup = BeautifulSoup(response,"html.parser")
    conmid = soup.find('div',class_='conMidtab')
    conmid2 = conmid.findAll('div',class_='conMidtab2')
    
    for info in conmid2:
        tr_list = info.find_all('tr')[2:]
        for index,tr in enumerate(tr_list):
            td_list=tr.find_all('td')
            if index == 0:
                province_name = td_list[0].text.replace('\n','')
                city_name = td_list[1].text.replace('\n','')
                weather = td_list[5].text.replace('\n','')
                wind = td_list[6].text.replace('\n','')
                max = td_list[4].text.replace('\n','')
                min = td_list[7].text.replace('\n','')
                print(province_name)
            else:
                city_name = td_list[0].text.replace('\n','')
                weather = td_list[4].text.replace('\n','')
                wind = td_list[5].text.replace('\n','')
                max = td_list[3].text.replace('\n','')
                min = td_list[6].text.replace('\n','')
            cursor.execute('insert into Weather(city,weather,wind,max,min) values(%s,%s,%s,%s,%s)',
                           (city_name,weather,wind,max,min))
            
if __name__ == '__main__':
    urls = ['http://www.weather.com.cn/textFC/hb.shtml',
            'http://www.weather.com.cn/textFC/db.shtml',
            'http://www.weather.com.cn/textFC/hd.shtml',
            'http://www.weather.com.cn/textFC/hz.shtml',
            'http://www.weather.com.cn/textFC/hn.shtml',
            'http://www.weather.com.cn/textFC/xb.shtml',
            'http://www.weather.com.cn/textFC/xn.shtml']
    for url in urls:
        get_temperature(url)
    conn.commit()