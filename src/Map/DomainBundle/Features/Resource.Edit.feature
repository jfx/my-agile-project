Feature: Domain.Resource.Edit Resource
  In order to manage resource for a domain
  As a super-admin user profile or a user with a manager role
  I need to change a resource's role. 

@javascript
Scenario: A super-admin edits a resource role
  Given I am a user
  And I follow "Admin"
  And I follow "Domain"
  And I follow "View domain #1"
  And I follow "Resources"
  And I should not see "Add" action button
  And I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  And I follow "Resources"
  And I follow "Edit resource #2"
  And I select "Manager" from "Role"
  And I press "Save"
  Then I should see "Resource edited successfully"
  And the table should contain the row:
  | Name           | Displayname | Role    |
  | User Firstuser | displayuser | Manager |
  And I am a user
  And I follow "Admin"
  And I follow "Domain"
  And I follow "View domain #1"
  And I follow "Resources"
  And I should see "Add" action button
  And I follow "Admin"
  And I follow "Domain"
  And I follow "View domain #2"
  And I follow "Resources"
  And I should not see "Add" action button


@javascript
Scenario: A manager edits a resource role
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Resources"
  And I follow "Edit resource #2"
  And I select "User+" from "Role"
  And I press "Save"
  Then I should see "Resource edited successfully"
  And the table should contain the row:
  | Name           | Displayname | Role  |
  | User Firstuser | displayuser | User+ |

@javascript
Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  And I follow "Resources"
  And I follow "Edit resource #2"
  When I follow "Return to list"
  Then I should be on "/dm-resource/"