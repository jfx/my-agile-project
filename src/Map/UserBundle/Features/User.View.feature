Feature: User.User.View User
  In order to manage user
  As a super-admin user profile
  I need to view user's details. 

@javascript
Scenario: View a user profile with non super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #2"
  Then I should be on "/user/2"
  And I should see the following view form:
  | Firstname   | Firstuser             |
  | Name        | User                  |
  | Displayname | displayuser           |
  | Username    | useruser              |
  | Email       | user@example.com      |
  | Details     | user role on domain 1 |
  And the view checkbox "Superadmin" should not be checked
  And the view checkbox "Locked" should not be checked

@javascript
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

@javascript
Scenario: View a user profile with super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #1"
  Then I should be on "/user/1"
  And I should see the following view form:
  | Firstname   | Firstadmin        |
  | Name        | Admin             |
  | Displayname | displayadmin      |
  | Username    | useradmin         |
  | Email       | admin@example.com |
  | Details     | Admin user        |
  And the view checkbox "Superadmin" should be checked
  And the view checkbox "Locked" should not be checked

@javascript
Scenario: View a user role list with no role
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #1"
  And I follow "Roles"
  Then I should be on "/user/role/1"
  And I should see 1 rows in the table
  And the table should contain "No role"

@javascript
Scenario: View a locked user profile with non super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #3"
  Then I should be on "/user/3"
  And I should see the following view form:
  | Firstname   | Firstlock        |
  | Name        | Lock             |
  | Displayname | displaylock      |
  | Username    | userlock         |
  | Email       | lock@example.com |
  | Details     | locked user      |
  And the view checkbox "Superadmin" should not be checked
  And the view checkbox "Locked" should be checked

@javascript
Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #2"
  When I follow "Return to list"
  Then I should be on "/user/"

@javascript
Scenario: Edit button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #2"
  When I follow "Edit"
  Then I should be on "/user/edit/2"
