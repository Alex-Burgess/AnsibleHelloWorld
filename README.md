# AnsibleHelloWorld
Demonstration of an Ansible project structure focusing on best practices for protection and control of a highly critical production environment.

The secondary objective is to investigate the use of AnsibleTower for further control of Ansible usage.

For reasons of speed and ease, AWS was used to create environments to test the structure.  Initially inventory scripts were populated as static lists, but would like to replace this with a dynamic inventory lookup (https://docs.ansible.com/ansible/latest/user_guide/intro_dynamic_inventory.html).


## Cloudformation Stack
1. Upload CloudCormation template to repo bucket (replace bucket with own bucket):
      ```
      $ cd AnsibleHelloWorld/cloudformation
      $ aws s3 cp . s3://alex-demo-files/cf-templates/ansible-hello-world/ --recursive --include “*.template”
      ```
1. Create stack:
      ```
      $ aws cloudformation create-stack \
       --stack-name ansiblehelloworld \
       --template-url https://s3.amazonaws.com/alex-demo-files/cf-templates/ansible-hello-world/main.template \
       --parameters file://main_params.json
      ```
1. Update stack:
      ```
      $ aws cloudformation update-stack \
       --stack-name ansiblehelloworld \
       --template-url https://s3.amazonaws.com/alex-demo-files/cf-templates/ansible-hello-world/main.template \
       --parameters file://main_params.json
      ```      

## Configure Ansible Tool Environment
1. Update inventory file(s), e.g. IT_hosts, STAGING_hosts, etc.
1. Copy Anisble files to Ansible controller:
      ```
      $ cd AnsibleHelloWorld
      $ scp -r ansible/AnsibleHelloWorld ansible@34.248.61.181:/app/ansible/
      ```
1. Basic test of configured servers: (Note put key in ansible user on AC, so can ssh and scp as ansible user.)
      ```
      $ ssh ansible@<ip>
      $ sudo su - ansible
      $ ssh-agent bash
      $ ssh-add ~/.ssh/ansible
      $ cd /app/ansible/AnsibleHelloWorld
      $ ansible webservers -m ping
      ```
1. Copy the webserver content to AC:
      ```
      $ scp -r helloworld.com ansible@34.248.61.181:/app/applications/
      ```
1. Build webserver environment:
      ```
      $ ansible-playbook -i inventories/testing/IT_hosts main.yml
      ```
1. Test the httpd installation:
http://<ip>/ansiblehelloworld.com/test_page2.html
or
http://ec2-<ip>.eu-west-1.compute.amazonaws.com


## How to run ansible command as another user:  (Useful for later)
$ cd /app/ansible/AnsibleHelloWorld
$ sudo -u ansible /home/ansible/.local/bin/ansible-playbook -i inventories/testing/IT_hosts main.yml

## Helpful commands for creating an AMI:
Useful link: https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/creating-an-ami-ebs.html

1. Launch an instance using CLI:
      ```
      ```
1. SSH to instance. Update packages and make customisations
      ```
      ssh ec2-user@<ip>
      sudo yum install
      ```
1. Find the instance if necessary:
      ```
      $ aws ec2 describe-instances --query 'Reservations[*].Instances[*].{InstanceID:InstanceId,ImageId:ImageId,Tags:Tags}' --filter "Name=tag:Name,Values=AMI Work"
      ```
1. Stop instance:
      ```
      aws ec2 stop-instances --instance-ids i-0fbada89239ed874c
      ```
1. Check state:
      ```
      $ aws ec2 describe-instances --query 'Reservations[*].Instances[*].{InstanceID:InstanceId,ImageId:ImageId,Tags:Tags,State:State}' --filter "Name=tag:Name,Values=AMI Work"
      ```
1. Create instance (For Ansible Controller):
      ```
      $ aws ec2 create-image --instance-id i-0fbada89239ed874c --name "ansiblecontroller-1.0.1" --description "Control instance AMI for Ansible Hello World application"
      $ aws ec2 create-tags --resources ami-0b64f24ce9389ca00 --tags Key=Name,Value=AnsibleController Key=Application,Value=AnsibleHelloWorld Key=Version,Value=1.0.1      
      ```
1. Create instance (For Webserver):
      ```
      $ aws ec2 create-image --instance-id i-0fbada89239ed874c --name "helloworldwebserver-1.0.1" --description "Webserver instance AMI for Ansible Hello World application"
      $ aws ec2 create-tags --resources ami-08d996d906e9ad81a --tags Key=Name,Value=HelloWorldWebserver Key=Application,Value=AnsibleHelloWorld Key=Version,Value=1.0.1      
      ```
