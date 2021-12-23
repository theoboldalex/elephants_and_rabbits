# Elephants & Rabbits <img src="https://cdn.worldvectorlogo.com/logos/php-1.svg" width="50" height="25"> <img src="https://cdn.worldvectorlogo.com/logos/rabbitmq.svg" width="25" height="25">

A simple example of a publisher and consumer written in PHP.

In order to run the project locally; first, clone the repo and bring up the rabbitmq container

```bash
$ docker-compose up -d
```

### Consumer

The consumer is built as a Symfony console application. To start this service, open up a terminal and navigate to the consumer directory before running

```bash
$ ./console queue:consume
```

### Publisher

The publisher is a Slim PHP application with one endpoint at `/sendMessage`.
To start the service, you can simply start the built-in PHP webserver on a port of your choosing. Navigate to the publisher directory and run

```bash
$ php -S localhost:8000
```

### Publishing a message to the queue

To test that the application is running as expected, you can make a request to the publisher's endpoint with a JSON object in the request body.

```bash
$ curl --request POST \
  --url http://localhost:8000/sendMessage \
  --header 'Content-Type: application/json' \
  --data '{
	"message": "Hello, World!"
}'
```
