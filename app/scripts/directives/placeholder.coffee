'use strict'

angular.module('quizApp').directive 'placeholder', () ->
  restrict: 'A'

  link: (scope, element, attrs) ->

    $(element).placeholder()