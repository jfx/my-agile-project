Feature: User.Profile.Profile password
  In order to change my password
  As a connected user
  I need to submit my old password and the new one. 

@javascript
Scenario: Wrong current password
  Given I am a user
  And I follow "Admin"
  And I follow "Profile"
  And I follow "Password"
  When I fill in the following:
  | Current password | wrongPass    |
  | New password     | passChanged  |
  | Verification     | passChanged  |
  And I press "Save"
  Then I should see "This value should be the user current password"
  And I logout
  And I am logged in as "useruser" with the password "user"

@javascript
Scenario: New passwords don't match
  Given I am a user
  And I follow "Admin"
  And I follow "Profile"
  And I follow "Password"
  When I fill in the following:
  | Current password | user         |
  | New password     | passChanged  |
  | Verification     | donotmatch   |
  And I press "Save"
  Then I should see "The entered passwords don't match "
  And I logout
  And I am logged in as "useruser" with the password "user"

@javascript
Scenario: Change password
  Given I am a user
  And I follow "Admin"
  And I follow "Profile"
  And I follow "Password"
  When I fill in the following:
  | Current password | user         |
  | New password     | passChanged  |
  | Verification     | passChanged  |
  And I press "Save"
  Then I should see "Password modified"
  And I logout
  And I go to "/login"
  And I am logged in as "useruser" with the password "passChanged"
  And I should see "Hello Firstuser User !"
