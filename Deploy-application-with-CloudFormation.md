1. Clone the git project:
      ```
      $ git clone git@github.com:Alex-Burgess/DockerWebExample.git
      ```
1. Build the Docker image:
      ```
      $ cd ~/DockerWebExample/docker-web-hello-world
      $ docker build .
      ...etc...
      Successfully built d27c913fc693
      ```
1. Create an ECR repository:
      ```
      $ aws ecr create-repository --repository-name docker-hello-world
      ```
1. Tag and then push the image to ECR (push may take a couple of minutes):
      ```
      $ docker tag d27c913fc693 <redacted>.dkr.ecr.eu-west-1.amazonaws.com/docker-hello-world
      $ aws ecr get-login --no-include-email
      $ docker login -u AWS -p xxxxxxx https://<redacted>.dkr.ecr.eu-west-1.amazonaws.com
      $ docker push <redacted>.dkr.ecr.eu-west-1.amazonaws.com/docker-hello-world
      ```
1. Upload CloudCormation templates to repo bucket (replace bucket with own bucket):
      ```
      $ cd DockerWebExample/cloudformation-templates/
      $ aws s3 cp . s3://alex-demo-files/cf-templates --recursive --include “*.template”
      ```
1. Create CloudFormation stack:
      ```
      $ aws cloudformation create-stack \
        --stack-name "Docker-Web-Example" \
        --template-url https://s3-eu-west-1.amazonaws.com/alex-demo-files/cf-templates/web_example_main.template \
        --capabilities CAPABILITY_NAMED_IAM \
        --tags Key=Application,Value=Docker-Hello-World \
        --parameters ParameterKey=AppName,ParameterValue="docker-hello-world" \
        ParameterKey=Environment,ParameterValue=test \
        ParameterKey=TaskDesiredCount,ParameterValue=1 \
        ParameterKey=RepositoryUri,ParameterValue=<redacted>.dkr.ecr.eu-west-1.amazonaws.com/docker-hello-world:latest
      ```
1. Check the progress of the stack update:
      ```
      $ aws cloudformation describe-stack-events --stack-name "Docker-Hello-World"
      ```
1. Check the status of the ECS cluster and get Public IP address:
      ```
      $ cd DockerWebExample/scripts
      $ ./get_ip.sh Docker-Web-Example
      Stackname: Docker-Web-Example
      Cluster Name: docker-hello-world-test-cluster
      Task ID: 0126a92e-e6b8-449a-bcb1-a044acb3a473
      Task Status: RUNNING
      Test URL: http://52.209.45.12
      ```
