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

### SonarQube

When SonarQube is launched you will need to login with the necessary credentials. You can use the following credentials
when SonarQube is started for the first time:

| Username | Password |
|----------|----------|
| admin    | admin    |

I highly recommend that you change the default password if you are going to use SonarQube in production or if this 
particular SonarQube instance will be made accessible to other developers.

After you have signed into SonarQube go to **My Account** > **Security** > **Generate Tokens**. Enter a new token name
and hit the generate button. Be sure to copy the token because you won't be able to see it again! 

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
On a Windows machine you will therefore need to run the two commands separately:

```shell script
  docker ps -q -l --filter="name=jenkins"  // output: c049d8d5ed96
  docker exec c049d8d5ed96 cat /var/jenkins_home/secrets/initialAdminPassword
```

Use this password to unlock Jenkins and install the suggested plugins which the community finds most useful.
Some additional plugins can be downloaded from **Manage Jenkins** > **Manage Plugins**. On the plugin page be
sure to activate the **Available** tab and install the following plugins:

| Plugin             | Version | URL
|--------------------|---------|-------------------------------------------------------------------------------------------------------|
| Locale             | 1.4+    | [Locale plugin](https://wiki.jenkins.io/display/JENKINS/Locale+Plugin)                                |
| SonarQube Scanner  | 2.10+   | [SonarScanner for Jenkins](https://docs.sonarqube.org/latest/analysis/scan/sonarscanner-for-jenkins/) |

Simply click on the **Download now and install after restart** button. While the plugins are being installed you can 
also check the checkbox that will automatically restart Jenkins once the plugins have been downloaded. Changing the
Jenkins locale to English will help you to setup the SonarQube Scanner without constantly translating this guide to
your own language.

After installing both plugins head back to the Jenkins dashboard and go to **Manage Jenkins** > **Configure System** >
**SonarQube servers**. The following information can be used to properly setup SonarQube and Jenkins:

| Field      | Value                     |
|------------|---------------------------|
| Name       | SonarQube                 |
| Server URL | http://ci.local/sonarqube |

If you are unable to add **Server authentication token** during this process simply click the **Apply** and **Save** 
button. After that you should be able to able to add a new token to Jenkins using the **Add** button. Use the following 
information to add the SonarQube token to Jenkins:

| Field       | Value                                                |
|-------------|------------------------------------------------------|
| Domain      | Global credentials (unrestricted)                    |
| Kind        | Secret Text                                          |
| Scope       | Global (Jenkins, nodes, items, all child items, etc) |
| Secret      | Your SonarQube token                                 |
| ID          | SonarQube                                            |
| Description | SonarQube token                                      |
 
Be Sure to select the SonarQube token from the **Server authentication token** field and once again click the **Apply** 
and **Save** button.