resource "aws_codepipeline" "main" {
  name = var.identifier

  pipeline_type = "V2"
  role_arn = aws_iam_role.codepipeline.arn

  artifact_store {
    type     = "S3"
    location = aws_s3_bucket.codepipeline_artifact.bucket
  }

  stage {
    name = "Source"

    action {
      name            = "Source"
      category        = "Source"
      owner           = "AWS"
      provider        = "CodeStarSourceConnection"
      version         = "1"
      output_artifacts = ["SourceOutput"]

      configuration = {
        ConnectionArn = var.connection_arn
        FullRepositoryId = var.repository
        BranchName = var.branch
      }
    }
  }

  stage {
    name = "Build"

    action {
      name            = "Build"
      category        = "Build"
      owner           = "AWS"
      provider        = "CodeBuild"
      version         = "1"
      input_artifacts  = ["SourceOutput"]
      output_artifacts = ["BuildOutput"]

      configuration = {
        ProjectName = aws_codebuild_project.main.name
      }
    }
  }

  stage {
    name = "Deploy"

    action {
      name            = "Deploy"
      category        = "Deploy"
      owner           = "AWS"
      provider        = "AppConfig"
      version         = "1"
      input_artifacts  = ["BuildOutput"]

      configuration = {
        Application = aws_appconfig_application.main.id
        DeploymentStrategy = "AppConfig.Linear50PercentEvery30Seconds"
        Environment = aws_appconfig_environment.main.environment_id
        ConfigurationProfile = aws_appconfig_configuration_profile.main.configuration_profile_id
        InputArtifactConfigurationPath = "config.json"
      }
    }
  }
}
