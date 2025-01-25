import urllib.request
import os

def lambda_handler(event, context):
    application = os.environ['APPCONFIG_APPLICATION']
    environment = os.environ['APPCONFIG_ENVIRONMENT']
    configurations = os.environ['APPCONFIG_CONFIGURATION']

    # AWS公式ドキュメントより
    # see https://docs.aws.amazon.com/ja_jp/appconfig/latest/userguide/appconfig-integration-lambda-extensions-add.html

    url = f'http://localhost:2772/applications/{application}/environments/{environment}/configurations/{configurations}'
    config = urllib.request.urlopen(url).read()

    return config
