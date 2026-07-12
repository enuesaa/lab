resource "aws_appsync_resolver" "note" {
  api_id      = aws_appsync_graphql_api.main.id
  field       = "note"
  type        = "Query"
  kind        = "UNIT"
  data_source = aws_appsync_datasource.dynamodb.name

  code = <<EOF
import { util } from '@aws-appsync/utils';

export function request(ctx) {
  return {
    operation: 'GetItem',
    key: util.dynamodb.toMapValues({
      id: ctx.args.id,
    }),
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
