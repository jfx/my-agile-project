Feature: Domain.Resource.Add Resource
  In order to manage resource for a domain
  As a super-admin user profile or a user with a manager role
  I need to add a resource. 

Scenario Outline: A super-admin or a manager adds a resource
  Given I am logged in as "<username>" with the password "<password>"
  And I follow "Admin"
  And I follow "Domain"
  And I follow "View domain #1"
  And I follow "Resources"
  And I follow "Add"
  When I select "No-domain Firstno-domain" from "Resource"
  And I select "User+" from "Role"
  And I press "Save"
  Then I should see "Resource added successfully"
  And I should see 6 rows in the table
  And the table should contain the row:
  | Name                     | Displayname      | Role  |
  | No-domain Firstno-domain | displayno-domain | User+ |

  Examples:
  | username       | password   |
  | userd1-manager | d1-manager |
  | useradmin      | admin      |

Scenario: A super-admin adds a manager
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domain"
  And I follow "View domain #3"
  And I follow "Resources"
  And I follow "Add"
  When I select "No-domain Firstno-domain" from "Resource"
  And I select "Manager" from "Role"
  And I press "Save"
  Then I should see "Resource added successfully"
  And I should see 1 rows in the table
  And the table should contain the row:
  | Name                     | Displayname      | Role    |
  | No-domain Firstno-domain | displayno-domain | Manager |
  And I logout
  And I am logged in as "userno-domain" with the password "no-domain"
  And I follow "Admin"
  And I follow "Domain"
  And I follow "View domain #3"
  And I follow "Resources"
  And I should see "Add" action button

Scenario: Impossible to add a resource without selecting a domain before
  Given I am a super-admin
  When I go to "/dm-resource/add"
  Then I should be on "/domain/"

Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domain"
  And I follow "Edit domain #1"
  And I follow "Resources"
  And I follow "Add"
  When I follow "Return to list"
  Then I should be on "/dm-resource/"
  And I should see "Domain One"