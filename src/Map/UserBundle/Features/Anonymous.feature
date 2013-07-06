Feature: Anonymous access to login page
  In order to be able to connect 
  As a anonymous user
  I need to see the login form

Scenario: An anonymous see the login form
  Given I am an anonymous user
  When I go to "/login"
  Then I should see "username:"
  And I should see "password:"