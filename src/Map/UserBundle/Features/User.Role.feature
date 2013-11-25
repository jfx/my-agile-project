Feature: User.User.Role User
  In order to manage user
  As a super-admin user profile
  I need to view user's roles. 

Scenario: View a user roles list
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #2"
  And I follow "Roles"
  Then I should be on "/user/role/2"
  And I should see 2 rows in the table
  And the data not ordered of the table should match:
  | Domain     | Role  |
  | Domain One | User  |
  | Domain Two | User+ |

Scenario: View a user role list with no role
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #1"
  And I follow "Roles"
  Then I should be on "/user/role/1"
  And I should see 1 rows in the table
  And the table should contain "No role"

Scenario: Impossible to view user's role with wrong id
  Given I am a super-admin
  When I go to "/user/role/999"
  Then I should see "404 Not Found"

Scenario Outline: Links to see
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #2"
  And I follow "Roles"
  When I follow "<link>"
  Then I should be on "<page>"

 Examples:
  | link | page    |
  | Main | /user/2 |