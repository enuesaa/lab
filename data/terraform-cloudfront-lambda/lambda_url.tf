resource "aws_lambda_function_url" "main" {
  function_name      = aws_lambda_function.main.function_name

  authorization_type = "AWS_IAM"
}

resource "aws_lambda_permission" "main" {
  statement_id  = "cloudfront"

  function_name = aws_lambda_function.main.function_name
  action        = "lambda:InvokeFunctionUrl"
  principal     = "cloudfront.amazonaws.com"
  source_arn    = "arn:aws:cloudfront::${data.aws_caller_identity.main.account_id}:distribution/${aws_cloudfront_distribution.main.id}"
}
