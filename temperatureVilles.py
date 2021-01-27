# coding: UTF-8
"""
Script: pythonProject/temperatureVilles
Création: arevol, le 15/01/2021
"""


# Imports
import requests
import mysql.connector
import time


# Fonctions
def get_temperature(ville):
    url="http://api.openweathermap.org/data/2.5/weather?q="+ville+",fr&units=metric&lang=fr&appid=0a73790ec47f53b9e1f2e33088a0f7d0"
    return float(requests.get(url).json()['main']['temp'])


def get_pression(ville):
    url="http://api.openweathermap.org/data/2.5/weather?q="+ville+",fr&units=metric&lang=fr&appid=0a73790ec47f53b9e1f2e33088a0f7d0"
    return float(requests.get(url).json()['main']['pressure'])


def set_bdd(temperature,pression, ville):
    cnx = mysql.connector.connect(user='root', password='', host='127.0.0.1',database='bdd_temperaturevilles')
    cursor = cnx.cursor()
    update_val = ("UPDATE temperaturevilles SET temperature = (%s), pression = (%s) WHERE ville = (%s)")
    data = (temperature,pression, ville)
    cursor.execute(update_val, data)
    cnx.commit()
    cursor.close()
    cnx.close()


def set_temperature_bdd(temperature, pression , ville):
    set_bdd(temperature, pression, ville)



# Programme principal
def main():
   liste_ville=["grenoble","meylan","lyon","paris"]
   #mettre à jour toutes les 5 min
   while True:
       for ville in liste_ville:
           set_temperature_bdd(get_temperature(ville),get_pression(ville), ville)
       print("a été mis à jour !")
       time.sleep(300)






if __name__ == '__main__':
    main()
# Fin
