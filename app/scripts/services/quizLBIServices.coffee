'use strict'

angular.module('quizApp')
.factory 'QuizMGMT', ['$rootScope', '$http', ($rootScope, $http) ->

    fact = {}

    fact.getQuiz = (lang) ->
      $http.get("./data/quiz.json"
      ).success((data, status) ->
        if !data.error
          $rootScope.$broadcast('questions', data)
        else
          console.log "[Error][GetQuiz] " + data.error
          ga('send', 'event', 'QuizMgmt Error', 'getQuiz SQL ', data.error)
          $rootScope.$broadcast('error')
      ).error (data, status) ->
        console.log "[Error][GetQuiz] " + status
        ga('send', 'event', 'QuizMgmt Error', 'getQuiz AJAX ', status)
        $rootScope.$broadcast('error')

    fact.addUser = (user, game) ->
      $http.post("./php/do.php?r=addUser"
        data: {
          user: user,
          game: game,
          hash: 'AuqiDOu0C6DnzbWGFEr0KUWX0zsJoI2qsel5zOqJ'
        }
      ).success((data, status) ->
        if !data.error
          $rootScope.$broadcast('addUser')
        else
          console.log "[Error][addUser] " + data.error
          ga('send', 'event', 'QuizMgmt Error', 'addUser SQL ', data.error)
          $rootScope.$broadcast('error')
      ).error (data, status) ->
        console.log "[Error][addUser] " + status
        ga('send', 'event', 'QuizMgmt Error', 'addUser AJAX ', status)
        $rootScope.$broadcast('error')

    return fact
  ]