resource "aws_appsync_resolver" "delete_note" {
  api_id      = aws_appsync_graphql_api.main.id
  field       = "deleteNote"
  type        = "Mutation"
  kind        = "UNIT"
  data_source = aws_appsync_datasource.dynamodb.name

  code = <<EOF
import { util } from '@aws-appsync/utils';

export function request(ctx) {
  return {
    operation: 'DeleteItem',
    key: util.dynamodb.toMapValues({
      id: ctx.args.id,
    }),
  };
}

export function response(ctx) {
  if (ctx.error) {
    util.error(ctx.error.message, ctx.error.type);
  }
  return true;
}
EOF

  runtime {
    name            = "APPSYNC_JS"
    runtime_version = "1.0.0"
  }
}
