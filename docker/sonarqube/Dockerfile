# Build sonarqube-community-branch-plugin
FROM alpine:latest AS builder
WORKDIR /tmp/sonarqube-community-branch-plugin
RUN apk --update add git openjdk8 && \
    rm -rf /var/lib/apt/lists/* && \
    rm /var/cache/apk/*
RUN git clone https://github.com/mc1arke/sonarqube-community-branch-plugin.git . && \
    git checkout -b feature/version-1.2.0 1.2.0
RUN ./gradlew clean build

# Copy plugin into sonarqube:lts
FROM sonarqube:lts
COPY --from=builder /tmp/sonarqube-community-branch-plugin/build/libs/*.jar "$SONARQUBE_HOME/extensions/plugins"
COPY --from=builder /tmp/sonarqube-community-branch-plugin/build/libs/*.jar "$SONARQUBE_HOME/lib/common"
