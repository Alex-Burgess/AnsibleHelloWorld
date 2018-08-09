## Preparation
1. Check that the necessary IAM role exists:
      ```
      $ aws iam get-role --role-name AWSServiceRoleForECS
      {
          "Role": {
              "Path": "/aws-service-role/ecs.amazonaws.com/",
              "RoleName": "AWSServiceRoleForECS",
              "RoleId": "AROAIXAB6I7A56EI23DBY",
              "Arn": "arn:aws:iam::369331073513:role/aws-service-role/ecs.amazonaws.com/AWSServiceRoleForECS",
              "CreateDate": "2018-07-30T16:45:37Z",
              "AssumeRolePolicyDocument": {
                  "Version": "2012-10-17",
                  "Statement": [
                      {
                          "Effect": "Allow",
                          "Principal": {
                              "Service": "ecs.amazonaws.com"
                          },
                          "Action": "sts:AssumeRole"
                      }
                  ]
              }
          }
      }
      ```
1. Create task execution role
1. Create VPC network...


## Push Image to Repository
Notes:
* This is demonstrated with ECR, but DockerHub is also an option.
* You can run this locally, but it makes sense to run this from an EC2 instance to improve upload time when pushing image to repository.


1. Create ECR repository:
      ```
      $ aws ecr create-repository --repository-name web-hello-world
      ```
1. Tag the image: (Note, repositoryUri is taken from the create-repository step above)
      ```
      $ docker tag <imageid> <redacted>.dkr.ecr.eu-west-1.amazonaws.com/web-hello-world
      ```
1. Get the docker authentication login command string, then run the login command
      ```
      $ aws ecr get-login --no-include-email
      $ docker login -u AWS -p xxxxxxx https://<redacted>.dkr.ecr.eu-west-1.amazonaws.com
      ```
1. Push the image to ECR
      ```
      $ docker push <redacted>.dkr.ecr.eu-west-1.amazonaws.com/web-hello-world
      ```
1. Check the image in ERC
      ```
      $ aws ecr list-images --repository-name web-hello-world
      ```

## Launch container on ECS

1. Create task definition
      It is possible to generate an empty skeleton of a task-definition:
      ```
      aws ecs register-task-definition --generate-cli-skeleton
      ```

      Create a file with the task definition: task-def.json
      ```
      {
          "family": "web-hello-world-td",
          "executionRoleArn": "arn:aws:iam::369331073513:role/ecsTaskExecutionRole",
          "networkMode": "awsvpc",
          "containerDefinitions": [
              {
                  "name": "web-hello-world-cd",
                  "image": "369331073513.dkr.ecr.eu-west-1.amazonaws.com/web-hello-world:latest",
                  "cpu": 0,
                  "memoryReservation": 300,
                  "portMappings": [
                      {
                          "containerPort": 80,
                          "hostPort": 80,
                          "protocol": "tcp"
                      }
                  ],
                  "essential": true,
              }
          ],
          "requiresCompatibilities": [
              "FARGATE"
          ],
          "cpu": "256",
          "memory": "512"
      }
      ```

1. Register the task definition:
      ```
      $ aws ecs register-task-definition --cli-input-json file://task-def.json
      ```


Create Cluster
Create Service
Test Service
