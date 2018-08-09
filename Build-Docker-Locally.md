1. Build
      ```
      $ cd ~/DockerWebExample/docker-web-hello-world
      $ docker build .
      ...etc...
      Successfully built d27c913fc693
      ```
1. Tag
      ```
      $ docker tag d27c913fc693 docker-web-hello-world
      $ docker images
      REPOSITORY               TAG                 IMAGE ID            CREATED             SIZE
      docker-web-hello-world   latest              d27c913fc693        4 minutes ago       179MB
      ```
1. Run/test
      ```
      $ docker run -p 80:80 --name hello-world docker-web-hello-world
      ```
      Browse to http://localhost
1. Cleanup
Find the running/stopped container:
      ```
      $ docker ps -a
      CONTAINER ID        IMAGE                    COMMAND                  CREATED             STATUS                     PORTS               NAMES
      50813de995ff        docker-web-hello-world   "/usr/sbin/apache2 -…"   10 seconds ago      Exited (0) 3 seconds ago                       hello-world
      ```
Remove the container:
      ```
      $ docker rm hello-world
      ```
