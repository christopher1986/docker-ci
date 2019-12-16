# Continious Integration

A containerized environment which can be used for projects developed and maintained on a single machine. 

## Requirements

| Tool           | Version  |
|----------------|:--------:|
| Docker Engine  | 18.06.0+ |
| Docker Compose | 1.10.0+  |

## Installation

Start the containers declared in the docker-compose.yml with the following command:

```sh
  docker-compose up -d
```

This command must be run from the directory containing the docker-compose file. See the offical [Docker documentation](https://docs.docker.com/install/linux/linux-postinstall/) if you have permissions errors while executing docker commands from the terminal.

After starting the containers be sure to add `ci.local` to your hosts file. This host entry will allow you to communicate with the following applications:

| Application | URL                         |
|-------------|-----------------------------|
| Jenkins     | http://ci.local/jenkins     |
| SonarQube   | http://ci.local/sonarqube   |
| Nexus       | http://ci.local/nexus       |

### Jenkins

When Jenkins is first started you will be prompted for an administator password. You can find this password in the logs or in `/var/jenkins_home/secrets/initialAdminPassword`. You can tail the Jenkins log using the following command:

```sh
  docker-compose logs -f jenkins
```

Alternatively you can use `cat` to display the password stored in initialAdminPassword file which can be done through the following command:

```sh
  docker exec $(docker ps -q -l --filter="name=jenkins") cat /var/jenkins_home/secrets/initialAdminPassword
```

Use this password to unlock Jenkins and install the suggested plugins which the community finds most useful.





