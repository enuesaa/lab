resource "aws_appsync_resolver" "notes" {
  api_id      = aws_appsync_graphql_api.main.id
  field       = "notes"
  type        = "Query"
  kind        = "UNIT"
  data_source = aws_appsync_datasource.dynamodb.name

  code = <<EOF
import { util } from '@aws-appsync/utils'

export function request(ctx) {
  return {
    operation: 'Query',
    query: {
      expression: 'channel = :channel',
      expressionValues: util.dynamodb.toMapValues({
        ':channel': ctx.args.channel,
      }),
    },
    scanIndexForward: false,
    limit: 100,
  }
}

export function response(ctx) {
  return ctx.result.items
}
EOF

  runtime {
    name            = "APPSYNC_JS"
    runtime_version = "1.0.0"
  }
}
