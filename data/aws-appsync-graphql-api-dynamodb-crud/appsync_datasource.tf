resource "aws_appsync_datasource" "dynamodb" {
  api_id           = aws_appsync_graphql_api.main.id
  name             = "dynamodb"
  type             = "AMAZON_DYNAMODB"
  description      = "dynamodb"
  service_role_arn = aws_iam_role.appsync_datasource_dynamodb.arn

  dynamodb_config {
    table_name = aws_dynamodb_table.main.name
  }
}

resource "aws_appsync_datasource" "none" {
  api_id = aws_appsync_graphql_api.main.id

  name = "none"
  type = "NONE"
}
