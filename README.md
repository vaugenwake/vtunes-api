# vTunes API Demo

This a simple small microservice application written as an example of using DynamoDB in a move complicated application with multiple relationships and entities.

## Components and Packages
- AWS SDK
- [Streetlamp Router](https://github.com/willitscale/streetlamp)
- KSUID

## Installing and running

Start the application using docker
```BASH
docker-compose up -d
```

This will start 3 containers for you:
| Container | Port | Description |
|---|---|---|
| web | 8080 | Nginx web container |
| php | 9000 | PHP Container running fpm |
| dynamodb | 8025 | DynamoDB local instance |
| dynamodb-admin | 8001 | GUI to view and interact with DynamoDB |

Accessing the API:
```BASH
http://localhost:8080
```

Accessing the Dynamodb GUI:
```BASH
http://localhost:8001
```

Connecting to DynamoDB local instance using AWS CLI
```BASH
aws --endpoint-url=http://localhost:8025 dynamodb list-tables
```

## Seeding table with sample data
Please fetch and follow the guide [here](https://github.com/vaugenwake/vtunes-data-processing)

## Endpoint Insomnia Collection
Import the collection in file: `vtunes-insomnia-collection.yaml`