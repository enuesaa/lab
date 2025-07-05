FROM golang:1.24 AS dev

WORKDIR /app
COPY . .
RUN go install github.com/air-verse/air@latest

CMD ["air"]


FROM golang:1.24 AS builder

WORKDIR /app
COPY . .
RUN go build -o main


FROM debian:stable-slim

WORKDIR /app
COPY --from=builder /app/main .

CMD ["/app/main"]
