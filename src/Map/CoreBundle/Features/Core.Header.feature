Feature: Core.Header.MAP header
  In order to make navigation ease in use
  As a connected user
  I need to see header information 

Scenario: Title
  Given I am a user
  When I follow "My Agile Project"
  Then I should be on "/"

Scenario: Select box to change domain for a user not manager
  Given I am a user
  When I select "Domain One" from "map_menu_select_search"
  Then I should be on "/domain/1"
  And I should see "Useruser (user)"
  When I select "Domain Two" from "map_menu_select_search"
  Then I should be on "/domain/2"
  And I should see "Useruser (user+)"

Scenario: Select box to change domain for a user manager
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #2"
  And I follow "Resources"
  And I should not see "Add" action button
  When I select "Domain One" from "map_menu_select_search"
  Then I should be on "/domain/1"
  And I should see "userd1-manager (manager)"
  And I follow "Resources"
  And I should see "Add" action button

Scenario: Super-admin username displayed with a star
  When I am a super-admin
  Then I should see "Useradmin*"

Scenario: Non super-admin username
  When I am a user
  Then I should see "Useruser"

Scenario: Link to profile page
  Given I am a user
  When I follow "Useruser"
  Then I should be on "/user/profile"