
#include <WiFi.h>
#include <WiFiClient.h>
#include <WiFiGeneric.h>
#include <WiFiMulti.h>
#include <WiFiScan.h>
#include <WiFiServer.h>
#include <WiFiSTA.h>
#include <WiFiType.h>
#include <WiFiUdp.h>
#include <ETH.h>
#include <WiFi.h>
#include <WiFiAP.h>
#include <WiFiClient.h>
#include <WiFiGeneric.h>
#include <WiFiMulti.h>
#include <WiFiScan.h>
#include <WiFiServer.h>
#include <WiFiSTA.h>
#include <WiFiType.h>
#include <WiFiUdp.h>
#include <HTTPClient.h>
#include <WiFiClient.h>

const char* ssid ="PROYETECH";
const char* password ="Proyetech2021";

float t;
float tempC;

#include "DHT.h"
#define ADC_VREF_mV    3300.0 // in millivolt
#define ADC_RESOLUTION 4096.0
#define DHTPIN      34 // ESP32 pin GIOP34 (ADC0) connected to LM35
WiFiClient client; 

void setup() {
  pinMode(34,OUTPUT);
  Serial.begin(115200);
  Serial.println(F("DHT 11 prueba de conexión con el servidor"));
 
  WiFi.begin(ssid, password);
  Serial.print("Conectando...");
  while (WiFi.status()!= WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  Serial.println("Conexión OK!");
  Serial.print("IP Local: ");
  Serial.println(WiFi.localIP());
}

void loop() {
  LecturaTH();
  EnvioDatos();
}

// funcion de lectura de temperatura 
void LecturaTH(){
  int adcVal = analogRead(DHTPIN);
  float milliVolt = adcVal * (ADC_VREF_mV / ADC_RESOLUTION);
  tempC = milliVolt / 10;
  float tempF = tempC * 9 / 5 + 32;
   
  char bufferTemp[8]; //Crear buffer temporal para convertir float a string
  String temperatura = dtostrf(t, 8, 3, bufferTemp); //Convertir de float a String 8 = longitud de String, 3 = numero de decimales. (e.g. 1234.567)
  
  Serial.print("Temperature: ");
  Serial.print(tempC);   // print the temperature in °C
  Serial.print("°C");
  Serial.print("  ~  "); // separator between °C and °F
  Serial.print(tempF);   // print the temperature in °F
  Serial.println("°F");
}

 // rutina de envio de datos por POST
void EnvioDatos(){
  
  if (WiFi.status() == WL_CONNECTED){ 
     HTTPClient http;  // creo el objeto http
     http.begin("https://url.base.com/api/v1/service/iot");
     http.addHeader("Content-Type", "application/json"); // defino texto plano..
     Serial.println("temperatura***:" + String(tempC));
    
   
    String dataSensor = "{\"trama\" : \"S:SENSOR001;T:"+ String(tempC) + ";H:0" + "\" }";
    int codigo_respuesta = http.POST(dataSensor);
    if (codigo_respuesta>0) {
      Serial.println("Código+ HTTP: "+ String(codigo_respuesta));
      if (codigo_respuesta == 200) {
        String cuerpo_respuesta = http.getString();
        Serial.println("El servidor respondió: ");
        Serial.println(cuerpo_respuesta);
      }
     } else {
        Serial.print("Error enviado POST, código: ");
        Serial.println(codigo_respuesta);
     }
     http.end();  // libero recursos
  } else {
     Serial.println("Error en la conexion WIFI");
  }
  delay(60000);
}
