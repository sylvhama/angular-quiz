'use strict'

angular.module('quizApp').directive 'foundationGo', [ () ->
  restrict: 'C'
  link: (scope, element, attrs) ->
    $(document).foundation()

    ###timeoutId =  $timeout( ->
      $(document).foundation('equalizer','reflow')
      $timeout.cancel(timeoutId)
    ,1000)

    scope.$on '$destroy', () ->
      $timeout.cancel(timeoutId)###
]