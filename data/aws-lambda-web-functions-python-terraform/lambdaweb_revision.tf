resource "aws_lambdaweb_function_revision" "main" {
  function_name = aws_lambdaweb_function.main.function_name

  build_config {
    code_config {
      s3_object {
        bucket     = aws_s3_object.code.bucket
        key        = aws_s3_object.code.key
        version_id = aws_s3_object.code.version_id
      }
    }
    runtime_config {
      runtime = "python3.15"
    }
  }

  service_config {
    execution_role_arn = aws_iam_role.lambdaweb_execution.arn
    environment_variables = {
      AWS_LAMBDA_PYTHON_ENTRYPOINT = "app.main:app"
    }
  }

  lifecycle {
    create_before_destroy = true
  }
}

resource "aws_s3_object" "code" {
  bucket = aws_s3_bucket_versioning.lambdaweb_code.bucket
  key    = "lambdaweb/package.zip"
  source = "lambdaweb/package.zip"
  etag   = filemd5("lambdaweb/package.zip")
}
