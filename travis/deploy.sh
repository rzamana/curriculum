#!/bin/nash
$(aws ecr get-login --no-include-email)
docker tag rzamana/curriculum ${DOCKER_ECR_REPO}:${APP_VERSION}.${TRAVIS_BUILD_NUMBER}
docker push ${DOCKER_ECR_REPO}:${APP_VERSION}.${TRAVIS_BUILD_NUMBER}
docker tag rzamana/curriculum ${DOCKER_ECR_REPO}:latest
docker push ${DOCKER_ECR_REPO}:latest