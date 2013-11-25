Feature: User.User.View User
  In order to manage user
  As a super-admin user profile
  I need to view user's details. 

Scenario: View a user profile with super-admin profile
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
  And the view checkbox "Super-admin" should not be checked
  And the view checkbox "Locked" should not be checked

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
  And the view checkbox "Super-admin" should be checked
  And the view checkbox "Locked" should not be checked

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
  And the view checkbox "Super-admin" should not be checked
  And the view checkbox "Locked" should be checked

Scenario: Impossible to view a user with wrong id
  Given I am a super-admin
  When I go to "/user/999"
  Then I should see "404 Not Found"

Scenario Outline: Links to see
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "View user #2"
  When I follow "<link>"
  Then I should be on "<page>"

 Examples:
  | link           | page         |
  | Return to list | /user/       |
  | Edit           | /user/edit/2 |
  | Roles          | /user/role/2 |
