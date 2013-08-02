Feature: User.User.Edit User
  In order to manage user
  As a super-admin user profile
  I need to edit user's details. 

@javascript
Scenario: Edit a user with non super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #2"
  When I fill in the following:
  | Firstname          | Firstmodified        |
  | Name               | Modified             |
  | Displayname        | displayModified      |
  | Username           | usermodified         |
  | Password           | passModified         |
  | Email              | modified@example.com |
  | Details (optional) | User modified        |
  And I press "Save"
  Then I should see "User edited successfully"
  And I should see the following view form:
  | Firstname   | Firstmodified        |
  | Name        | Modified             |
  | Displayname | displayModified      |
  | Username    | usermodified         |
  | Email       | modified@example.com |
  | Details     | User modified        |
  And the view checkbox "Superadmin" should not be checked
  And the view checkbox "Locked" should not be checked
  And I follow "Log out"
  And I am logged in as "usermodified" with the password "passModified"

@javascript
Scenario: Edit a user without changing password with non super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #2"
  When I fill in the following:
  | Firstname          | Firstmodified        |
  | Name               | Modified             |
  | Displayname        | displayModified      |
  | Username           | usermodified         |
  | Email              | modified@example.com |
  | Details (optional) | User modified        |
  And I press "Save"
  Then I should see "User edited successfully"
  And I should see the following view form:
  | Firstname   | Firstmodified        |
  | Name        | Modified             |
  | Displayname | displayModified      |
  | Username    | usermodified         |
  | Email       | modified@example.com |
  | Details     | User modified        |
  And the view checkbox "Superadmin" should not be checked
  And the view checkbox "Locked" should not be checked
  And I follow "Log out"
  And I am logged in as "usermodified" with the password "user"

@javascript
Scenario: Change a password of a user
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #2"
  When I fill in "Password" with "passModified"
  And I press "Save"
  Then I should see "User edited successfully"
  And I should see the following view form:
  | Firstname   | Firstuser             |
  | Name        | User                  |
  | Displayname | displayUser           |
  | Username    | useruser              |
  | Email       | user@example.com      |
  | Details     | user role on domain 1 |
  And the view checkbox "Superadmin" should not be checked
  And the view checkbox "Locked" should not be checked
  And I follow "Log out"
  And I am logged in as "useruser" with the password "passModified"

@javascript
Scenario: Change a user to super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #2"
  When I check "Super admin"
  And I press "Save"
  Then I should see "User edited successfully"
  And the view checkbox "Superadmin" should be checked

@javascript
Scenario: Change a super-admin profile to a non super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #1"
  When I uncheck "Super admin"
  And I press "Save"
  Then I should see "User edited successfully"
  And the view checkbox "Superadmin" should not be checked

@javascript
Scenario: Unlock a user
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #3"
  When I uncheck "Locked"
  And I press "Save"
  Then I should see "User edited successfully"
  And the view checkbox "Locked" should not be checked
  And I follow "Log out"
  And I am logged in as "userlock" with the password "lock"

@javascript
Scenario: Lock a user
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #2"
  When I check "Locked"
  And I press "Save"
  Then I should see "User edited successfully"
  And the view checkbox "Locked" should be checked
  And I follow "Log out"
  And I go to "/login"
  And I fill in "Username:" with "useruser"
  And I fill in "Password:" with "user"
  And I press "Login"
  And I should be on "/login"
  And I should see "User account is locked"

@javascript
Scenario Outline: Impossible to modify a user with data too short
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #2"
  When I fill in "<field>" with "x"
  And I press "Save"
  Then I should see "This value is too short. It should have 2 characters or more."

  Examples:
  | field       |
  | Firstname   |
  | Name        |
  | Displayname |
  | Username    |

@javascript
Scenario: Impossible to modify a user with wrong mail
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #2"
  When I fill in "Email" with "wrongMail"
  And I press "Save"
  Then I should be on "/user/edit/2"

@javascript
Scenario Outline: Impossible to add a user with duplicate data
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Edit user #1"
  When I fill in "<field>" with "<value>"
  And I press "Save"
  Then I should see "A user with this <message> already exists."

  Examples:
  | field       | value            | message     |
  | Displayname | displayuser      | displayname |
  | Username    | useruser         | username    |
  | Email       | user@example.com | email       |
