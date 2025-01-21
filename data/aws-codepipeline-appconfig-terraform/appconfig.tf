resource "aws_appconfig_application" "main" {
  name = var.identifier
}

resource "aws_appconfig_environment" "main" {
  application_id = aws_appconfig_application.main.id
  name = "dev"
}

resource "aws_appconfig_configuration_profile" "main" {
  application_id = aws_appconfig_application.main.id
  name = "main"

  # see https://docs.aws.amazon.com/ja_jp/AWSCloudFormation/latest/UserGuide/aws-resource-appconfig-configurationprofile.html#cfn-appconfig-configurationprofile-locationuri
  location_uri = "codepipeline://${var.identifier}"
}
