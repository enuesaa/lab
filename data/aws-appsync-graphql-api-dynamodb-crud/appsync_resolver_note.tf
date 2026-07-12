# resource "aws_appsync_resolver" "note" {
#   api_id      = aws_appsync_graphql_api.main.id
#   field       = "note"
#   type        = "Query"
#   kind        = "UNIT"
#   data_source = aws_appsync_datasource.dynamodb.name

#   code = <<EOF
# import { util } from '@aws-appsync/utils'

# export function request(ctx) {
#   return {
#     operation: 'Query',
#     query: {
#       expression: 'id = :id',
#       expressionValues: util.dynamodb.toMapValues({
#         ':id': ctx.args.id,
#       }),
#     },
#     scanIndexForward: false, // timestamp DESC
#     limit: 1,
#   }
# }

# export function response(ctx) {
#   return ctx.result.items?.[0] ?? null
# }
# EOF

#   runtime {
#     name            = "APPSYNC_JS"
#     runtime_version = "1.0.0"
#   }
# }
