resource "aws_appsync_resolver" "create_note" {
  api_id      = aws_appsync_graphql_api.main.id
  field       = "createNote"
  type        = "Mutation"
  kind        = "UNIT"
  data_source = aws_appsync_datasource.dynamodb.name

  // see https://docs.aws.amazon.com/ja_jp/appsync/latest/devguide/js-aws-appsync-resolver-reference-dynamodb-putitem.html
  code = <<EOF
import { util } from '@aws-appsync/utils';

export function request(ctx) {
  return {
    operation: 'PutItem',
    key: util.dynamodb.toMapValues({
      id: util.autoUlid(),
    }),
    attributeValues: util.dynamodb.toMapValues({
      title: ctx.args.input.title,
      message: ctx.args.input.message,
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
