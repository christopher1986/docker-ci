pipeline {
  agent {
    dockerfile {
      args '--network isolated_nw'
    }
  }
  environment {
    CI = 'true'
  }
  parameters {
    string(name: 'version', description: 'The version number', defaultValue: '')
  }
  stages {
    stage('Build') {
      steps {
        sh 'composer install'
      }
    }
    stage('Test') {
      when {
        allOf{
          expression { fileExists('./vendor/bin/phpunit') }
          expression { fileExists('./tests') }
        }
      }
      steps {
        sh './vendor/bin/phpunit --bootstrap vendor/autoload.php --whitelist src/ --log-junit reports/phpunit.report.xml --coverage-clover reports/phpunit.coverage.xml tests/'
      }
    }
    stage('Sonarqube') {
      when {
        allOf {
          expression { fileExists('./reports') }
          expression { fileExists('./tests') }
        }
      }
      environment {
        scannerHome = tool 'SonarScanner 4.0'
      }
      steps {
        withSonarQubeEnv('SonarQube Server') {
          sh "${scannerHome}/bin/sonar-scanner"
        }
        timeout(time: 5, unit: 'MINUTES') {
            waitForQualityGate abortPipeline: true
        }
      }
    }
    stage('Release') {
      when {
        expression { params.version != '' }
      }
      environment {
        NEXUS_CREDS = credentials('nexus-creds')
      }
      steps {
        sh "composer require elendev/nexus-composer-push"
        sh "composer nexus-push --username=${NEXUS_CREDS_USR} --password=${NEXUS_CREDS_PSW} --url=http://ci.local/nexus/repository/composer/ --ignore=reports/ --ignore=Dockerfile --ignore=sonar-project.properties ${params.version}"
      }
    }
  }
  post { 
    always { 
      dir('reports') {
        deleteDir()
      }
    }
  }
}
