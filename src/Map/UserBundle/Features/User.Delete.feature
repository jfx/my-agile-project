Feature: User.User.Delete User
  In order to manage user
  As a super-admin user profile
  I need to delete a user. 

Scenario: Delete a user
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I should see "lock@example.com"
  And I follow "Delete user #3"
  When I press "Remove"
  And I follow "OK"
  Then I should be on "/user/"
  And I should see "User removed successfully"
  And I should not see "lock@example.com"

Scenario: Cancel to delete a user
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Delete user #3"
  When I press "Remove"
  And I follow "Cancel"
  Then I should be on "/user/del/3"

Scenario: Impossible to delete a user
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Delete user #2"
  When I press "Remove"
  And I follow "OK"
  Then I should be on "/user/del/2"
  And I should see "Impossible to remove this item - Integrity constraint violation !"

Scenario: Impossible to delete a user with wrong id
  Given I am a super-admin
  When I go to "/user/del/999"
  Then I should see "404 Not Found"

Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Delete user #3"
  When I follow "Return to list"
  Then I should be on "/user/"