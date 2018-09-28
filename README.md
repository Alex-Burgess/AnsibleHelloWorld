# AnsibleHelloWorld
For an overview of this project and other helpful snippets see the [Wiki](https://github.com/Alex-Burgess/AnsibleHelloWorld/wiki).

Build procedure
1. [Build AMIs]()
1. Update cloudformation/main_params.json and build stack
1. Update AnsibleHelloWorld inventory hosts files with AWS stack ips
1. Copy Ansible and Application files to Ansible controllers
1. Test ansible and execute playbook to build environment

## Configure Ansible Tool Environment
1. Update inventory file(s), e.g. IT_hosts, STAGING_hosts, etc.
1. Copy Anisble files to Ansible controller:
      ```
      $ cd AnsibleHelloWorld
      $ scp -r ansible/AnsibleHelloWorld ansible@xx.xxx.xx.xxx:/app/ansible/
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
      $ scp -r helloworld.com ansible@xx.xxx.xx.xxx:/app/applications/
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
