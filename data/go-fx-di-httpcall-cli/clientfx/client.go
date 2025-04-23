package clientfx

import (
	"io"
	"net/http"
)

func New() IClient {
	return &Client{}
}

type IClient interface {
	Do(method string, url string) (string, error)
}

type Client struct {}

func (c *Client) Do(method string, url string) (string, error) {
	client := http.Client{}

	req, err := http.NewRequest(method, url, nil)
	if err != nil {
		return "", err
	}

	resp, err := client.Do(req)
	if err != nil {
		return "", err
	}
	defer resp.Body.Close()

	bodybytes, err := io.ReadAll(resp.Body)
	if err != nil {
		return "", err
	}

	return string(bodybytes), nil
}
