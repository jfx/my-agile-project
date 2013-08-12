Feature: User.Security.Log out
  In order to quit the application
  As a connected user
  I need to disconnect. 

@javascript
Scenario: A user logs out
  Given I am a user
  And I am on "/"
  When I follow "Log out"
  Then I should be on "/login"
  And I am disconnected