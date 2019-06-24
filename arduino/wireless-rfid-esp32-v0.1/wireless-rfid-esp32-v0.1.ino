#include <WiFi.h>
#include <WiFiMulti.h>
#include <HTTPClient.h>
#include <MFRC522.h>
#include <SPI.h>
#define SS_PIN    21
#define RST_PIN   22
#define buzzerPin 14
#define ON HIGH
#define OFF LOW

MFRC522::MIFARE_Key key;
MFRC522::StatusCode status;
MFRC522 mfrc522(SS_PIN, RST_PIN);

WiFiMulti wifiMulti;

unsigned long cardKey;

char httpLink[100];
char httpAPI[] = "http://192.168.254.9/system-rfid/api/record.php";

void setup() {
  Serial.begin(9600);
  
  pinMode(buzzerPin, OUTPUT);
  
  SPI.begin();
  mfrc522.PCD_Init();

  wifiMulti.addAP("SSID", "PASSWORD");

  if((wifiMulti.run() == WL_CONNECTED)) {
    beep(1, 50);
  }else{
    beep(5, 50);  
  }
}

void loop() {
  if((wifiMulti.run() == WL_CONNECTED)) {
    if(readCard()){
      sendData();
    }
  }
}

void sendData(){
  HTTPClient http;
  sprintf(httpLink, "%s?uid=%lu", httpAPI, cardKey);
  Serial.println(httpLink);
  http.begin(httpLink);
  int httpCode = http.GET();
  if(httpCode > 0) {
      if(httpCode == 201) {
          String payload = http.getString();
          Serial.println(payload);
          beep(3, 50);
      }else{
        beep(5, 50);
      }
  } else {
      Serial.printf("ERROR: %s\n", http.errorToString(httpCode).c_str());
      beep(5, 50);
  }

  http.end();
}

bool readCard(){
  if ( ! mfrc522.PICC_IsNewCardPresent()) {
    return false;
  }
  if ( ! mfrc522.PICC_ReadCardSerial()) {
    return false;
  }

  cardKey =  mfrc522.uid.uidByte[0] << 24;
  cardKey += mfrc522.uid.uidByte[1] << 16;
  cardKey += mfrc522.uid.uidByte[2] <<  8;
  cardKey += mfrc522.uid.uidByte[3];

  //Serial.println(cardKey);

  mfrc522.PICC_HaltA(); 
  mfrc522.PCD_StopCrypto1();

  return true;
}

void beep(int t, int d){
  for(int i = 0; i < t; i++){
    digitalWrite(buzzerPin, ON);
    delay(d);
    digitalWrite(buzzerPin, OFF);
    delay(d);
  }
}
