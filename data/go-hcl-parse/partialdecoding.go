package main

import (
	"fmt"

	"github.com/hashicorp/hcl/v2"
	"github.com/hashicorp/hcl/v2/gohcl"
	"github.com/hashicorp/hcl/v2/hclparse"
	"github.com/zclconf/go-cty/cty"
)

var mainhcl = `
  const "apikey" {
    value = "aaa"
  }

  service {
    apikey = const.apikey
  }
`

type Const struct {
	Name  string `hcl:"name,label"`
	Value string `hcl:"value"`
}

type Service struct {
	Apikey string `hcl:"apikey"`
}

func Parse() {
	parser := hclparse.NewParser()

	file, diags := parser.ParseHCL([]byte(mainhcl), "main.hcl")
	if diags.HasErrors() {
		panic(diags)
	}

	// 先に const だけデコードする
	type PartialConfig struct {
		Consts []Const  `hcl:"const,block"`
		Remain hcl.Body `hcl:",remain"` // see https://hcl.readthedocs.io/en/latest/go_decoding_gohcl.html#partial-decoding
	}
	var partial PartialConfig

	if diags := gohcl.DecodeBody(file.Body, nil, &partial); diags.HasErrors() {
		panic(diags)
	}

	// デコードした値を hcl.EvalContext にマッピング
	constmap := make(map[string]cty.Value)
	for _, c := range partial.Consts {
		constmap[c.Name] = cty.StringVal(c.Value)
	}
	evar := &hcl.EvalContext{
		Variables: map[string]cty.Value{
			"const": cty.ObjectVal(constmap),
		},
	}

	type Config struct {
		Service Service `hcl:"service,block"`
		Consts  []Const `hcl:"const,block"`
	}
	var config Config

	// 第2引数で hcl.EvalContext を渡す
	if diags := gohcl.DecodeBody(file.Body, evar, &config); diags.HasErrors() {
		panic(diags)
	}

	fmt.Println(config.Service.Apikey) // aaa
}
