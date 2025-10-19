pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/Mohamed2001Rabie/devops-php-app.git'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t php-app .'
            }
        }

        stage('Run SonarQube Analysis') {
            steps {
                sh '''
                docker run --rm --network sonar-net \
                  -e SONAR_HOST_URL="http://sonarqube:9000" \
                  -e SONAR_TOKEN="sqp_22dcb6b94877cbc526711b6a5836880ba6e7c83d" \
                  -v "$(pwd):/usr/src" \
                  sonarsource/sonar-scanner-cli \
                  -Dsonar.projectKey=php-app \
                  -Dsonar.sources=/usr/src
                '''
            }
        }

        stage('Run PHP App Container') {
            steps {
                sh '''
                docker run -d --name php-app --network devops-php-app_default -p 8080:80 php-app || true
                '''
            }
        }
    }
}

