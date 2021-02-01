#include <SigFox.h>
#include "DHT.h"

#define DHTPIN 2     // Digital pin connected to the DHT sensor
#define DHTTYPE DHT11   // DHT 11
DHT dht(DHTPIN, DHTTYPE);

typedef struct __attribute__ ((packed)) sigfox_message { // see http://www.catb.org/esr/structure-packing/#_structure_alignment_and_padding
  float moduleTemperature;
  float moduleHumidity;
} SigfoxMessage;

// stub for message which will be sent
SigfoxMessage msg;

// =================== UTILITIES ===================
void reboot() {
  NVIC_SystemReset();
  while (1);
}
// =================================================


void setup() {
  dht.begin();
  Serial.begin(115200);
  while (!Serial);

  if (!SigFox.begin()) {
    Serial.println("SigFox error, rebooting");
    reboot();
  }

  delay(100); // Wait at least 30ms after first configuration

  float h = dht.readHumidity();
  // Read temperature as Celsius (the default)
  float t = dht.readTemperature();

  Serial.print(F("Humidity: "));
  Serial.print(h);
  Serial.print(F("%  Temperature: "));
  Serial.print(t);
  Serial.print(F("°C "));


  // Enable debug prints and LED indication
  SigFox.debug();

  // Read and convert the module temperature
  //msg.moduleTemperature = (int32_t) (SigFox.internalTemperature() * 100.0); // température 1/100th of degrees
  msg.moduleTemperature = (float) (t); // température 1/100th of degrees
  msg.moduleHumidity = (float) (h); // température 1/100th of degrees



  Serial.print("Temperature : ");
  Serial.print(msg.moduleTemperature); // display what we will send in Hexadecimal
  Serial.print(" | ");
  Serial.print(msg.moduleHumidity); // display what we will send in Decimal

  // Clears all pending interrupts
  SigFox.status();
  delay(1);

  // Send the data
  SigFox.beginPacket();
  SigFox.write((uint8_t*)&msg, sizeof(SigfoxMessage));;

  SigFox.end();
}

void loop() {}
