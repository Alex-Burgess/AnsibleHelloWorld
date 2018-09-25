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
Update inventory file(s), e.g. IT_hosts, STAGING_hosts, etc.

Copy ansible files from local machine to controller:
1. Log onto Ansible controller:
      ```
      ssh ec2-user@<ip>

      ```
1. Switch to root:
      ```
      sudo su
      ```
1. Create Ansible app directory (Note file permissions are to allow ec2-user and ansible to both read and write to same directory.  better solution required.  This also causes problems down the line for cfg files not being used.):
      ```
      mkdir /app
      mkdir /app/ansible
      mkdir /app/ansible/AnsibleHelloWorld
      chown -R ansible:ansible /app/ansible
      chmod -R 777 /app/ansible
      ```
1. Copy files to Ansible controller:
      ```
      $ cd AnsibleHelloWorld
      $ scp -r ansible/[!.]* ec2-user@<ip>:/app/ansible/AnsibleHelloWorld/
      ```
1. Make files available to Ansible user:
      ```
      chown -R ansible:ansible /app/ansible
      chmod -R 777 /app/ansible
      ```
1. Basic test of configured servers:
      ```
      $ sudo su - ansible
      $ ssh-agent bash
      $ ssh-add ~/.ssh/ansible
      $ chmod 775 /app/ansible/AnsibleHelloWorld
      $ cd /app/ansible/AnsibleHelloWorld
      $ ansible webservers -m ping
      ```
1. Build webserver environment:
      ```
      $ ansible-playbook -i inventories/testing/IT_hosts main.yml
      ```
1. Test the httpd installation: http://ec2-<ip>.eu-west-1.compute.amazonaws.com

## First draft of content deployment via playbook:
1. Create directory on Ansible Controller:
      ```
      $ mkdir /app/applications
      $ mkdir /app/applications/ApplicationA
      $ mkdir /app/applications/ApplicationA/httpContent
      ```
1. On local host:
      ```
      cd AnsibleHelloWorld
      scp -r applicationA/httpContent/* ec2-user@34.242.114.179:/app/applications/ApplicationA/httpContent
      ```
1. Run playbook on Ansible Controller:
      ```
      $ sudo su - ansible
      $ ssh-agent bash
      $ ssh-add ~/.ssh/ansible
      $ ansible-playbook -i inventories/testing/IT_hosts main.yml
      ```


cd /Users/alexburgess/Development/AnsibleHelloWorld
$ scp -r ansible/AnsibleHelloWorld ansible@34.248.61.181:/app/ansible/
$ scp -r helloworld.com ansible@34.248.61.181:/app/applications/
$ ansible-playbook -i inventories/testing/IT_hosts main.yml

http://54.194.91.130/ansiblehelloworld.com/test_page2.html


## How to run ansible command as another user:
$ cd /app/ansible/AnsibleHelloWorld
$ sudo -u ansible /home/ansible/.local/bin/ansible-playbook -i inventories/testing/IT_hosts main.yml
