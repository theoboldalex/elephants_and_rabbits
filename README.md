hello from master
# Elephants & Rabbits <img src="https://cdn.worldvectorlogo.com/logos/php-1.svg" width="50" height="25"> <img src="https://cdn.worldvectorlogo.com/logos/rabbitmq.svg" width="25" height="25">

A simple example of a publisher and consumer written in PHP that interact via a RabbitMQ server.

### Prerequisites

In order to run the project locally you must have the following installed;

 - PHP v5.4 or greater
 - Docker
 - Docker Compose
 - Curl or another HTTP client of your choice.

### Getting started

Clone the repo and bring up the containers using the start script. 

```bash
$ ./start.sh
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

If the request was successful, you should see the message output in the consumer's terminal. Furthermore, you can check for activity in the RabbitMQ management dashboard by navigating to
`http://localhost:15672` and logging in with the `RABBIT_USER` and `RABBIT_PASSWORD` credentials set in our `docker-compose.base.yml` file.

In order to clean up after running the application, stop your local PHP development server and run 

```bash
$ docker-compose down
```

All containers should now be stopped and removed.
