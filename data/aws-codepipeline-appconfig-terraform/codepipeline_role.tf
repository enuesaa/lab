resource "aws_iam_role" "codepipeline" {
  name = "${var.identifier}-codepipeline"

  assume_role_policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Effect = "Allow"
        Principal = {
          Service = "codepipeline.amazonaws.com"
        }
        Action = "sts:AssumeRole"
      }
    ]
  })
}

resource "aws_iam_role_policy" "codepipeline_s3" {
  name = "s3"

  role = aws_iam_role.codepipeline.id

  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action   = [
          "s3:GetObject",
          "s3:PutObject",
        ]
        Effect   = "Allow"
        Resource = "arn:aws:s3:::${aws_s3_bucket.codepipeline_artifact.bucket}/*"
      },
    ]
  })
}

resource "aws_iam_role_policy" "codepipeline_codeconnection" {
  name = "codeconnection"

  role = aws_iam_role.codepipeline.id

  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action   = [
          "codeconnections:UseConnection",
          "codestar-connections:UseConnection",
        ]
        Effect   = "Allow"
        Resource = var.connection_arn
      },
    ]
  })
}

resource "aws_iam_role_policy" "codepipeline_codebuild" {
  name = "codebuild"

  role = aws_iam_role.codepipeline.id

  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action   = [
          "codebuild:BatchGetBuilds",
          "codebuild:StartBuild",
          "codebuild:BatchGetBuildBatches",
          "codebuild:StartBuildBatch",
        ]
        Effect   = "Allow"
        Resource = aws_codebuild_project.main.arn
      },
    ]
  })
}

resource "aws_iam_role_policy" "codepipeline_appconfig" {
  name = "appconfig"

  role = aws_iam_role.codepipeline.id

  policy = jsonencode({
    Version = "2012-10-17"
    Statement = [
      {
        Action   = [
          "appconfig:StartDeployment",
          "appconfig:StopDeployment",
          "appconfig:ListApplications",
          "appconfig:ListConfigurationProfiles",
          "appconfig:GetConfiguration",
          "appconfig:GetDeployment",
        ]
        Effect   = "Allow"
        Resource = "*"
      },
    ]
  })
}
