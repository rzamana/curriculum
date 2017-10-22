#! /bin/bash
# Push only if it's not a pull request
if [ -z "$TRAVIS_PULL_REQUEST" ] || [ "$TRAVIS_PULL_REQUEST" == "false" ]; then
  # Push only if we're testing the master branch
  if [ "$TRAVIS_BRANCH" == "master" ]; then
    APP_VERSION=$(cat composer.json | grep -Po 'version\"\:[ ]*\"\K[0-9.]+')

    # Build and push
    echo "Pushing docker image"
    docker tag rzamana/curriculum ${DOCKER_ECR_REPO}:${APP_VERSION}.${TRAVIS_BUILD_NUMBER}
    docker push ${DOCKER_ECR_REPO}:${APP_VERSION}.${TRAVIS_BUILD_NUMBER}
    docker tag rzamana/curriculum ${DOCKER_ECR_REPO}:latest
    docker push ${DOCKER_ECR_REPO}:latest
    echo "Pushed ${DOCKER_ECR_REPO}:${APP_VERSION}.${TRAVIS_BUILD_NUMBER}"
  else
    echo "Skipping deploy because branch is not 'master'"
  fi
else
  echo "Skipping deploy because it's a pull request"
fi