resource "aws_lambda_function" "main" {
  function_name = var.identifier

  filename         = data.archive_file.lambda.output_path
  source_code_hash = data.archive_file.lambda.output_base64sha256

  handler       = "app.lambda_handler"
  architectures = ["arm64"]
  runtime       = "python3.12"
  role          = aws_iam_role.lambda.arn
  memory_size   = 128
  timeout       = 10

  environment {
    variables = {
      APPCONFIG_APPLICATION   = var.appconfig_application_name
      APPCONFIG_ENVIRONMENT   = var.appconfig_environment_name
      APPCONFIG_CONFIGURATION = var.appconfig_configuration_profile_name
    }
  }

  layers = [
    // ここに Lambda Layer の ARN をセット
    // see https://docs.aws.amazon.com/ja_jp/appconfig/latest/userguide/appconfig-integration-lambda-extensions-versions.html
  ]
}

data "archive_file" "lambda" {
  type        = "zip"
  output_path = "${path.module}/lambda.zip"

  source {
    filename = "app.py"
    content = file("${path.module}/lambda_app.py")
  }
}
