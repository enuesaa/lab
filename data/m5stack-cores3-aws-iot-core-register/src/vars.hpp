// wifi
static const char *WIFI_SSID = "";
static const char *WIFI_PASSWORD = "";

// https://www.amazontrust.com/repository/AmazonRootCA1.pem より。
static const char *AWSIOT_ROOT_CA = R"(-----BEGIN CERTIFICATE-----
-----END CERTIFICATE-----
)";

// 接続キットより。ファイル名は <name>.cert.pem
static const char *AWSIOT_CERTIFICATE = R"(-----BEGIN CERTIFICATE-----
-----END CERTIFICATE-----
)";

// 接続キットより。ファイル名は <name>.private.key
static const char *AWSIOT_PRIVATE_KEY = R"(-----BEGIN RSA PRIVATE KEY-----
-----END RSA PRIVATE KEY-----
)";

// IoT Core のエンドポイント。AWSコンソールに記載
static const char *AWSIOT_ENDPOINT = "xx.amazonaws.com";
static const char *AWSIOT_THING_ID = "";
