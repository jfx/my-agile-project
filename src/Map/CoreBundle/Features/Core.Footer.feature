Feature: Core.Footer.MAP footer
  In order to see copyright data
  As a connected user
  I need to see footer information 

Scenario: A user see footer information
  Given I am a user
  When I go to "/"
  Then I should see "My Agile Project v"