pipeline {
    agent any

    environment {
        SONAR_HOST_URL = 'http://sonarqube:9000'
        SONAR_TOKEN = 'sqp_22dcb6b94877cbc526711b6a5836880ba6e7c83d'
    }

    stages {
        stage('Checkout Code') {
            steps {
                git branch: 'main',
                    url: 'https://github.com/Mohamed2001Rabie/devops-php-app.git'
            }
        }

        stage('Build PHP App') {
            steps {
                echo 'Building PHP application using Docker...'
                sh 'docker build -t php-app .'
            }
        }

        stage('Run MySQL and PHP Containers') {
            steps {
                echo 'Starting MySQL and PHP containers...'
                sh '''
                docker run -d --name mysql-db --network devops-php-app_default -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=php_app mysql:5.7
                docker run -d --name php-app --network devops-php-app_default -p 8080:80 php-app
                '''
            }
        }

        stage('SonarQube Analysis') {
            steps {
                echo 'Running SonarQube analysis...'
                sh '''
                docker run --rm --network sonar-net \
                  -e SONAR_HOST_URL=$SONAR_HOST_URL \
                  -e SONAR_TOKEN=$SONAR_TOKEN \
                  -v "$(pwd):/usr/src" \
                  sonarsource/sonar-scanner-cli \
                  -Dsonar.projectKey=php-app \
                  -Dsonar.sources=/usr/src
                '''
            }
        }

        stage('Deploy') {
            steps {
                echo 'Deployment complete! PHP app is running on port 8080'
            }
        }
    }

    post {
        always {
            echo 'Cleaning up containers...'
            sh 'docker rm -f php-app mysql-db || true'
        }
        success {
            echo 'Pipeline executed successfully!'
        }
        failure {
            echo 'Pipeline failed!'
        }
    }
}
