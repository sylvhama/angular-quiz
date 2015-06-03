'use strict'

angular.module('quizApp').directive 'showError', [ () ->
  restrict: 'C'
  link: (scope, element, attrs) ->
    scope.$on 'error', (event, response) ->
      $('#myModal').foundation('reveal', 'open')
]