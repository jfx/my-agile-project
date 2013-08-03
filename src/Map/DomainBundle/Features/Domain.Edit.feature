Feature: Domain.Domain.Edit Domain
  In order to manage domain
  As a super-admin user profile
  I need to edit a domain. 

@javascript
Scenario: Edit a domain
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
  And the table should contain "Modified"

@javascript
Scenario: Impossible to edit a domain with a name too short
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  When I fill in "Name" with "x"
  And I press "Save"
  Then I should see "This value is too short. It should have 2 characters or more."

@javascript
Scenario: Impossible to edit a domain with a duplicate name
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  When I fill in "Name" with "Domain Two"
  And I press "Save"
  Then I should see "A domain with this name already exists."

@javascript
Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Edit domain #1"
  When I follow "Return to list"
  Then I should be on "/domain/"