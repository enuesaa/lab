terraform {
  required_providers {
    coderd = {
      source = "coder/coderd"
    }
  }
}

variable "token" {
  description = "Coder token"
  type        = string
  sensitive   = true
}

provider "coderd" {
  url   = "http://127.0.0.1:3000"
  token = var.token
}

resource "coderd_template" "minimum" {
  name = "minimum"

  description = "minimum template"

  versions = [
    {
      name      = "v1"
      directory = "templates/minimum"
      active    = true
    },
  ]
}
