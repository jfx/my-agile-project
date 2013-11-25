Feature: Domain.Domain.Edit Domain
  In order to manage domain
  As a super-admin user profile
  I need to edit a domain. 

Scenario: A super-admin edits a domain
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  When I fill in the following:
  | Name               | Modified        |
  | Details (optional) | Domain modified |
  And I press "Save"
  Then I should see "Domain edited successfully"
  And I should see the following view form:
  | Name        | Modified        |
  | Details     | Domain modified |
  And I follow "Return to list"
  And I should see 5 rows in the table
  And the table should contain the row:
  | Name     | Details         |
  | Modified | Domain modified | 

Scenario: A manager edits a domain
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Edit"
  When I fill in the following:
  | Name               | Modified        |
  | Details (optional) | Domain modified |
  And I press "Save"
  Then I should see "Domain edited successfully"
  And I should see the following view form:
  | Name        | Modified        |
  | Details     | Domain modified |
  And I follow "Return to list"
  And I should see 5 rows in the table
  And the table should contain the row:
  | Name     | Details         |
  | Modified | Domain modified |

Scenario: Impossible to edit a domain with a name too short
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  When I fill in "Name" with "x"
  And I press "Save"
  Then I should see "This value is too short. It should have 2 characters or more."

Scenario: Impossible to edit a domain with a duplicate name
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  When I fill in "Name" with "Domain Two"
  And I press "Save"
  Then I should see "A domain with this name already exists."

Scenario: Wrong domain Id
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  When I go to "/domain/edit/999"
  Then I should see "404 Not Found"

Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  When I follow "Return to list"
  Then I should be on "/domain/"