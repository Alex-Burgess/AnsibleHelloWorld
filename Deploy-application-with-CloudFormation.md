Preparation steps:
Checkout project
Build image
create ECR repository
push image to ECR

1. Validate templates locally:
      ```
      $ cd cloudformation-templates/
      $ aws cloudformation validate-template --template-body file://web_example_main.template
      $ aws cloudformation validate-template --template-body file://vpc-setup.template
      $ aws cloudformation validate-template --template-body file://ecs-setup.template
      ```
1. Upload CloudCormation templates to repo bucket (replace bucket with own bucket):
      ```
      $ aws s3 cp . s3://alex-demo-files/cf-templates --recursive --include “*.template”
      ```
1. Create CloudFormation stack:
      ```
      $ aws cloudformation create-stack \
       --stack-name "Docker-Web-Example" \
       --template-url https://s3-eu-west-1.amazonaws.com/alex-demo-files/cf-templates/web_example_main.template \
       --capabilities CAPABILITY_NAMED_IAM \
       --tags Key=Application,Value=Docker-Web-Examples \
       --parameters ParameterKey=AppName,ParameterValue="docker-web-examples" \
       ParameterKey=Environment,ParameterValue=test
      ```
1. Check the progress of the stack update:
      ```
      $ aws cloudformation describe-stack-events --stack-name "Docker-Web-Example"
      ```
