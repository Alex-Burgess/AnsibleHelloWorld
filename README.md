# AnsibleHelloWorld
Demonstration of an Ansible project structure focusing on best practices for protection and control of a highly critical production environment.

The secondary objective is to investigate the use of AnsibleTower for further control of Ansible usage.

For reasons of speed and ease, AWS was used to create environments to test the structure.  Initially inventory scripts were populated as static lists, but would like to replace this with a dynamic inventory lookup (https://docs.ansible.com/ansible/latest/user_guide/intro_dynamic_inventory.html).


## Useful commands
scp -r AnsibleHelloWorld/ ec2-user@ec2-52-18-140-127.eu-west-1.compute.amazonaws.com:~/
ansible webservers -m ping --private-key ~/.ssh/ansible_key
