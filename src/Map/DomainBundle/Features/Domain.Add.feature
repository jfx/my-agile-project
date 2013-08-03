Feature: Domain.Domain.Add Domain
  In order to manage domain
  As a super-admin user profile
  I need to add a domain. 

@javascript
Scenario: Add a domain
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domain"
  And I follow "Add"
  When I fill in the following:
  | Name               | Added        |
  | Details (optional) | Domain added |
  And I press "Save"
  Then I should see "Domain added successfully"
  And I should see the following view form:
  | Name        | Added        |
  | Details     | Domain added |
  And I follow "Return to list"
  And I should see 6 rows in the table
  And the table should contain "Added"

@javascript
Scenario: Impossible to add a domain with a name too short
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Add"
  And I fill in "Name" with "x"
  And I press "Save"
  Then I should see "This value is too short. It should have 2 characters or more."

@javascript
Scenario: Impossible to add a domain with a duplicate name
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Add"
  And I fill in "Name" with "Domain One"
  And I press "Save"
  Then I should see "A domain with this name already exists."

@javascript
Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Add"
  When I follow "Return to list"
  Then I should be on "/domain/"