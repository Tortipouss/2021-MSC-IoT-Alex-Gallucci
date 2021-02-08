#include <SigFox.h>
#include "DHT.h"

#define DHTPIN 2     // Digital pin connected to the DHT sensor
#define DHTTYPE DHT11   // DHT 11
DHT dht(DHTPIN, DHTTYPE);

typedef struct __attribute__ ((packed)) sigfox_message {
  float moduleTemperature;
  int moduleHumidity;
} SigfoxMessage;

// stub for message which will be sent
SigfoxMessage msg;

void setup() {
  dht.begin();  
  delay(100); // Wait at least 30ms after first configuration
}

void loop() {
  int h = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float t = dht.readTemperature();


  // Read and convert the module temperature
  msg.moduleTemperature = t; // température 1/100th of degrees
  msg.moduleHumidity = h; // température 1/100th of degrees

  // Clears all pending interrupts
  SigFox.begin();
  SigFox.status();
  delay(100);

  // Send the data
  SigFox.beginPacket();
  SigFox.write((uint8_t*)&msg, sizeof(SigfoxMessage));
  SigFox.endPacket();
  SigFox.end();
  
  delay(60000 * 10);
}
