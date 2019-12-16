FROM jenkins/jenkins:lts-alpine

# Install Docker CE
USER root
RUN apk --update add docker

# Run as `jenkins`
USER ${user}
