'use strict'

angular.module('quizApp')
  .controller 'QuizController', ['$rootScope', '$scope', '$location', '$cacheFactory', 'QuizMGMT',  ($rootScope, $scope, $location, $cacheFactory, QuizMGMT) ->

    $scope.title = ''
    $scope.questions = []
    $scope.alreadyPlayed = false
    $scope.checkForm = false

    cache = $cacheFactory.get('score')
    if typeof cache == "undefined"
      cache = $cacheFactory('score')
    cache.put("score", -1)

    $scope.submit = ($event) ->
      $event.preventDefault()
      $scope.checkForm = true
      user = {}
      game = {}
      user.name = $scope.myForm.inputName.$modelValue
      allAnswered = true
      for question in $scope.questions
        if typeof question.myanswer == 'undefined'
          allAnswered = false
      if user.name != '' and typeof user.name != 'undefined' and allAnswered
        game.answers = ''
        game.score = 0
        game.title = $scope.title
        l = 1
        for question in $scope.questions
          if l == $scope.questions.length
            game.answers = game.answers + question.myanswer
          else
            game.answers = game.answers + question.myanswer + ';'
          if parseInt(question.isCorrect) == parseInt(question.myanswer)
            game.score++
          l++
        $.cookie('game', game.score, { expires: 1, path: '/' })
        cache.put("score", game.score)
        cache.put("total", $scope.questions.length)
        cache.put("name", user.name)
        QuizMGMT.addUser(user, game)

    $scope.$on 'questions', (event, response) ->
      $scope.title = response.title
      $scope.questions = response.questions

    $scope.$on 'addUser', (event, response) ->
      $location.path('thankyou')

    language = 'en'
    if $rootScope.lang != 'en'
      language = $rootScope.lang.toLowerCase()
    QuizMGMT.getQuiz(language)

  ]