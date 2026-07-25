# GET Health
resource "aws_apigatewayv2_route" "get_health" {
  api_id    = aws_apigatewayv2_api.main.id
  route_key = "GET /health"
  target    = "integrations/${aws_apigatewayv2_integration.lambda.id}"
}

# # デフォルトルート
# resource "aws_apigatewayv2_route" "post_hooks" {
#   api_id    = aws_apigatewayv2_api.main.id
#   route_key = "POST /hooks"
#   target    = "integrations/${aws_apigatewayv2_integration.lambda.id}"
# }

# Integration (Lambda)
resource "aws_apigatewayv2_integration" "lambda" {
  api_id                 = aws_apigatewayv2_api.main.id
  integration_type       = "AWS_PROXY"
  integration_uri        = aws_lambda_function.main.invoke_arn
  payload_format_version = "2.0"
}

resource "aws_lambda_permission" "apigateway" {
  statement_id  = "apigateway"
  action        = "lambda:InvokeFunction"
  function_name = aws_lambda_function.main.function_name
  principal     = "apigateway.amazonaws.com"
  source_arn = "${aws_apigatewayv2_api.main.execution_arn}/*/*"
}
