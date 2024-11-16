resource "aws_cloudfront_origin_access_control" "lambda" {
  name             = "${var.identifier}-lambda"

  description      = "OAC for Lambda Function URL"
  signing_behavior = "always"
  signing_protocol = "sigv4"
  origin_access_control_origin_type = "lambda"
}
