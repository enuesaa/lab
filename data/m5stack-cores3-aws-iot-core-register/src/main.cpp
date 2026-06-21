#include <M5Unified.h>
#include <WiFi.h>
#include <WiFiClientSecure.h>
#include <PubSubClient.h>
#include "vars.hpp"

WiFiUDP ntpUDP;
WiFiClientSecure net;
PubSubClient mqtt(net);

void setup() {
  M5.begin();
  M5.Lcd.setTextSize(6);

  // WiFi へ接続
  WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
  while (WiFi.status() != WL_CONNECTED) {
    M5.delay(1000);
  }
  M5.Display.println("wifi ok");

  // AWS IoT Core のエンドポイントへ接続
  net.setCACert(AWSIOT_ROOT_CA);
  net.setCertificate(AWSIOT_CERTIFICATE);
  net.setPrivateKey(AWSIOT_PRIVATE_KEY);
  mqtt.setServer(AWSIOT_ENDPOINT, 8883);

  while (!mqtt.connected()) {
    if (!mqtt.connect(AWSIOT_CLIENT_ID)) {
      M5.delay(1000);
    }
  }
  M5.Display.println("mqtt ok");

  // MQTT 通信を試みる
  mqtt.publish("sdk/test/js", "hello");
  M5.Display.println("mqtt publish");
}

void loop() {
  M5.update();
}
