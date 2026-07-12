resource "aws_appsync_graphql_api" "main" {
  name = var.identifier

  schema               = file("${path.module}/appsync_schema.graphql")
  introspection_config = "ENABLED"
  authentication_type  = "API_KEY"

  log_config {
    cloudwatch_logs_role_arn = aws_iam_role.appsync_logging.arn
    field_log_level          = "ALL"
  }
}
