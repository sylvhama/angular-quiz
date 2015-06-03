'use strict'

angular.module('quizApp')
.controller 'ThankyouController', ['$scope', '$location', '$cacheFactory',  ($scope, $location, $cacheFactory) ->

  $scope.score = -1
  $scope.total = 0
  $scope.name = ''
  $scope.result = ''

  cache = $cacheFactory.get('score')
  if typeof cache == "undefined"
    $location.path '/'
  else
    $scope.score = parseInt(cache.get('score'))
    if $scope.score == -1
      $location.path '/'
    else
      $scope.total = parseInt(cache.get('total'))
      $scope.name = cache.get('name')
      $scope.result = switch
        when $scope.score == $scope.total
          'Excellent! You are an expert!'
        when $scope.score < $scope.total and $scope.score >= $scope.total-2
          'Very Good! Almost perfect!'
        when $scope.score < $scope.total-2 and $scope.score >= $scope.total/2
          'Good! You got it!'
        else
          'Keep revising the training!'
]