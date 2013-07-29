Feature: Role profile
  In order to see my role on domains
  As a connected user
  I need to see my different role on each domain. 

@javascript
Scenario: Multiple roles
  Given I am a user
  When I follow "Admin"
  And I follow "Profile"
  And I follow "Role"
  Then I should be on "/user/role"
  And I should see 2 rows in the table
  And the data not ordered of the table should match:
  | Domain     | Role  |
  | Domain One | User  |
  | Domain Two | User+ |


@javascript
Scenario: No role
  Given I am a super-admin
  When I follow "Admin"
  And I follow "Profile"
  And I follow "Role"
  Then I should be on "/user/role"
  And I should see 1 rows in the table
  And the table should contain "No role"
