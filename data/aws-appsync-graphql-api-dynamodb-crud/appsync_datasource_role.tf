resource "aws_iam_role" "appsync_datasource_dynamodb" {
  name = "${var.identifier}-appsync-datasource-dynamodb"

  assume_role_policy = jsonencode({
    Version = "2012-10-17",
    Statement = [{
      Effect = "Allow",
      Principal = {
        Service = "appsync.amazonaws.com"
      },
      Action = "sts:AssumeRole"
    }]
  })
}

resource "aws_iam_role_policy" "appsync_datasource_dynamodb_dynamodb" {
  name = "dynamodb"
  role = aws_iam_role.appsync_datasource_dynamodb.id

  policy = jsonencode({
    Version = "2012-10-17",
    Statement = [
      {
        Effect   = "Allow",
        Action   = "dynamodb:*"
        Resource = [aws_dynamodb_table.main.arn]
      }
    ]
  })
}
