# Continuous Integration

A containerized environment which can be used for projects developed and maintained on a single machine. 

## Requirements

| Tool           | Version  |
|----------------|----------|
| Docker Engine  | 18.06.0+ |
| Docker Compose | 1.10.0+  |

## Installation

Start the containers declared in the docker-compose.yml with the following command:

```shell script
  docker-compose up -d
```

This command must be run with administrator privileges from the directory containing the docker-compose file or 
as an alternative you can add the current users to the `docker` group.

After starting the containers be sure to add `ci.local` to your hosts file. This host entry will allow you to 
communicate with the following applications:

| Application | URL                         |
|-------------|-----------------------------|
| Jenkins     | http://ci.local/jenkins     |
| SonarQube   | http://ci.local/sonarqube   |
| Nexus       | http://ci.local/nexus       |

### Jenkins

When Jenkins is first started you will be prompted for an administator password. You can find this password in the logs 
or in `/var/jenkins_home/secrets/initialAdminPassword`. You can tail the Jenkins log using the following command:

```shell script
  docker-compose logs -f jenkins
```

Alternatively you can use `cat` to display the password stored in initialAdminPassword file which can be done through 
the following command:

```shell script
  docker exec $(docker ps -q -l --filter="name=jenkins") cat /var/jenkins_home/secrets/initialAdminPassword
```

The command above actually runs a second command inside a sub shell and returns the output of that command.
On a Windows OS you will therefore need to run the commands separately:

```shell script
  docker ps -q -l --filter="name=jenkins"  // output: c049d8d5ed96
  docker exec c049d8d5ed96 cat /var/jenkins_home/secrets/initialAdminPassword
```

Use this password to unlock Jenkins and install the suggested plugins which the community finds most useful.
Some additional plugins can be downloaded from **Beheer Plugins** which is accessible from the **Beheer 
Jenkins** menu. On the plugin manager page be sure to activate the **Beschikbaar** tab and install the 
following plugins:

| Plugin             | Version | URL
|--------------------|---------|-------------------------------------------------------------------------------------------------------|
| Locale             | 1.4+    | [Locale plugin](https://wiki.jenkins.io/display/JENKINS/Locale+Plugin)                                |
| SonarQube Scanner  | 2.10+   | [SonarScanner for Jenkins](https://docs.sonarqube.org/latest/analysis/scan/sonarscanner-for-jenkins/) |

Be sure to click the **Nu downloaden en installeren tijdens herstart** button. While installing the plugins you can 
check the checkbox that will automatically restart Jenkins for you. The following sections are based on Jenkins whose 
locale has been set to English.



