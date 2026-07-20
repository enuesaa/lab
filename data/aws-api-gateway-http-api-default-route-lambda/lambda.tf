resource "aws_lambda_function" "main" {
  function_name    = "${var.identifier}-control"

  s3_bucket        = var.lambda_function_bucket
  s3_key           = var.lambda_function_s3key

  role             = aws_iam_role.lambda.arn
  runtime          = "python3.13"
  handler          = "app.main.handler"
  timeout          = 30
  memory_size      = 128
}

resource "aws_cloudwatch_log_group" "lambda" {
  name              = "/aws/lambda/${aws_lambda_function.main.function_name}"
  retention_in_days = 14
}

resource "aws_lambda_permission" "apigateway" {
  statement_id  = "apigateway"
  action        = "lambda:InvokeFunction"
  function_name = aws_lambda_function.main.function_name
  principal     = "apigateway.amazonaws.com"
  source_arn = "${aws_apigatewayv2_api.main.execution_arn}/*/*"
}
