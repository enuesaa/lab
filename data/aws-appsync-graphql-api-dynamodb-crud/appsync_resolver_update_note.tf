resource "aws_appsync_resolver" "update_note" {
  api_id      = aws_appsync_graphql_api.main.id
  field       = "updateNote"
  type        = "Mutation"
  kind        = "UNIT"
  data_source = aws_appsync_datasource.dynamodb.name

  code = <<EOF
import { util } from '@aws-appsync/utils';

export function request(ctx) {
  return {
    operation: 'UpdateItem',
    key: util.dynamodb.toMapValues({
      id: ctx.args.id,
    }),
    update: {
      expression: 'SET title = :title, message = :message',
      expressionValues: util.dynamodb.toMapValues({
        ':title': ctx.args.input.title,
        ':message': ctx.args.input.message,
      }),
    },
  };
}

export function response(ctx) {
  return ctx.result;
}
EOF

  runtime {
    name            = "APPSYNC_JS"
    runtime_version = "1.0.0"
  }
}
