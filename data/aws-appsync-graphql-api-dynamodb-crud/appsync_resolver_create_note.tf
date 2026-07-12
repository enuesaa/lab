resource "aws_appsync_resolver" "create_note" {
  api_id      = aws_appsync_graphql_api.main.id
  field       = "createNote"
  type        = "Mutation"
  kind        = "UNIT"
  data_source = aws_appsync_datasource.dynamodb.name

  code = <<EOF
import { util } from '@aws-appsync/utils';

export function request(ctx) {
  const note = {
    channel: ctx.args.channel,
    id: util.autoUlid(),
    message: ctx.args.message,
  };

  ctx.stash.note = note;

  return {
    operation: 'PutItem',
    key: util.dynamodb.toMapValues({
      channel: note.channel,
      id: note.id,
    }),
    attributeValues: util.dynamodb.toMapValues({
      message: note.message,
    }),
  };
}

export function response(ctx) {
  return ctx.stash.note;
}
EOF

  runtime {
    name            = "APPSYNC_JS"
    runtime_version = "1.0.0"
  }
}
