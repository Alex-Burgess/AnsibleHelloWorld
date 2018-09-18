# AnsibleHelloWorld
Demonstration of an Ansible project structure focusing on best practices for protection and control of a highly critical production environment.

The secondary objective is to investigate the use of AnsibleTower for further control of Ansible usage.

For reasons of speed and ease, AWS was used to create environments to test the structure.  Initially inventory scripts were populated as static lists, but would like to replace this with a dynamic inventory lookup (https://docs.ansible.com/ansible/latest/user_guide/intro_dynamic_inventory.html).


## Useful commands
Copy ansible files from local machine to controller:
$ scp -r AnsibleHelloWorld/[!.]* ec2-user@ec2-52-18-140-127.eu-west-1.compute.amazonaws.com:~/AnsibleHelloWorld/

Add key:
$ ssh-agent bash
$ ssh-add ~/.ssh/ansible_key

Basic test of configured servers:
$ cd AnsibleHelloWorld
$ ansible webservers -m ping

Run site.yml playbook to create apache instance:
$ ansible-playbook -i inventories/testing/IT_hosts site.yml

Test the httpd installation:
http://ec2-34-249-100-148.eu-west-1.compute.amazonaws.com
