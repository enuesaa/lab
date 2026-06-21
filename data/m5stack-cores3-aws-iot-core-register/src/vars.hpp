// wifi
static const char *WIFI_SSID = "";
static const char *WIFI_PASSWORD = "";

// 接続キットの start.sh を参照
// curl https://www.amazontrust.com/repository/AmazonRootCA1.pem する
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

// IoT Core のエンドポイント。接続キットの start.sh を参照。AWSコンソールにも記載がある
static const char *AWSIOT_ENDPOINT = "xx.amazonaws.com";

// クライアントID
static const char *AWSIOT_CLIENT_ID = "sdk-nodejs-test";
