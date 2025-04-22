package main

import (
	"fmt"

	"github.com/hashicorp/hcl/v2/gohcl"
	"github.com/hashicorp/hcl/v2/hclparse"
)

type Config struct {
	Server Server `hcl:"server,block"`
}

type Server struct {
	Host   string  `hcl:"host"`
	Port   *int    `hcl:"port,optional"`
	Routes []Route `hcl:"route,block"`
}

type Route struct {
	Path   string `hcl:"path"`
	Status int    `hcl:"status"`
}

func main() {
	parser := hclparse.NewParser()

	file, diags := parser.ParseHCLFile("sample.hcl")
	if diags.HasErrors() {
		panic(diags)
	}

	var config Config

	if diags := gohcl.DecodeBody(file.Body, nil, &config); diags.HasErrors() {
		panic(diags)
	}

	fmt.Println(config.Server.Host) // 0.0.0.0

	if config.Server.Port != nil {
		fmt.Println(*config.Server.Port) // 3000
	}
}
