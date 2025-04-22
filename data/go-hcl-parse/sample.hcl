server {
  host = "0.0.0.0"
  port = 3000

  route {
    path   = "/"
    status = 200
  }

  route {
    path   = "/aaa"
    status = 404
  }
}
