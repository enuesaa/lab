resource "aws_dynamodb_table" "main" {
  name = var.identifier

  billing_mode = "PAY_PER_REQUEST"

  hash_key  = "channel"
  range_key = "id"

  attribute {
    name = "channel"
    type = "S"
  }

  attribute {
    name = "id"
    type = "S"
  }
}
