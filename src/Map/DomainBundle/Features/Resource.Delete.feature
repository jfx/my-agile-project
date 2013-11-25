Feature: Domain.Resource.Delete Resource
  In order to manage resource for a domain
  As a super-admin user profile or a user with a manager role
  I need to remove a resource from a domain. 

Scenario: A super-admin remove a resource
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  And I follow "Resources"
  And I follow "Delete resource #5"
  When I press "Remove"
  And I follow "OK"
  Then I should be on "/dm-resource/"
  And I should see "Resource removed successfully"
  And I should not see "D1-guest Firstd1-guest"

Scenario: A manager remove a resource
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Resources"
  And I follow "Delete resource #5"
  When I press "Remove"
  And I follow "OK"
  Then I should be on "/dm-resource/"
  And I should see "Resource removed successfully"
  And I should not see "D1-guest Firstd1-guest"

Scenario: Cancel to delete a resource
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  And I follow "Resources"
  And I follow "Delete resource #5"
  When I press "Remove"
  And I follow "Cancel"
  Then I should be on "/dm-resource/del/5"

Scenario: Impossible to delete a resource

Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  And I follow "Resources"
  And I follow "Delete resource #5"
  When I follow "Return to list"
  Then I should be on "/dm-resource/"