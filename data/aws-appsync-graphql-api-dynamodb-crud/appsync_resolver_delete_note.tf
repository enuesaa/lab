resource "aws_appsync_resolver" "delete_note" {
  api_id      = aws_appsync_graphql_api.main.id
  field       = "deleteNote"
  type        = "Mutation"
  kind        = "UNIT"
  data_source = aws_appsync_datasource.dynamodb.name

  code = <<EOF
export function request(ctx) {
  return {
    operation: 'DeleteItem',
    key: {
      id: { S: ctx.args.id },
    },
  };
}

export function response(ctx) {
  return true;
}
EOF

  runtime {
    name            = "APPSYNC_JS"
    runtime_version = "1.0.0"
  }
}
