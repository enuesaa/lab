package cmdfx

import (
	"flag"
	"fmt"

	"github.com/enuesaa/lab/data/go-fx-di-httpcall-cli/clientfx"
)

func New(client clientfx.IClient) ICmd {
	cmd := Cmd{
		client: client,
	}
	return &cmd
}

type ICmd interface {
	Parse() error
	Run() error
}

type Cmd struct {
	client clientfx.IClient

	url    string
	method string
}

func (c *Cmd) Parse() error {
	flag.StringVar(&c.method, "X", "GET", "HTTP Method. Example: GET, POST, PUT, DELETE")
	flag.Parse()

	args := flag.Args()
	if len(args) < 1 {
		return fmt.Errorf("missing required argument: <url>")
	}
	c.url = args[0]

	return nil
}

func (c *Cmd) Run() error {
	// http リクエスト
	body, err := c.client.Do(c.method, c.url)
	if err != nil {
		return err
	}
	fmt.Printf("%s", body)

	return nil
}
