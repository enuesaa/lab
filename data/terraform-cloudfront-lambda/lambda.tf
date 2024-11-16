resource "aws_lambda_function" "main" {
  function_name = var.identifier

  s3_bucket     = var.lambda_s3_bucket
  s3_key        = var.lambda_s3_key

  handler       = "bootstrap"
  architectures = ["arm64"]
  runtime       = "provided.al2"
  role          = aws_iam_role.lambda.arn
  memory_size   = 128
  timeout       = 10

  layers = [
    // aws managed lambda layer for lambda web adapter here
  ]
}
