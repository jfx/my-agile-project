Feature: Home.Home 
  In order to see summary information 
  As a connected user
  I need to see the dashboard page 

Scenario: Title
  Given I am a user
  When I follow "Home"
  Then I should be on "/"