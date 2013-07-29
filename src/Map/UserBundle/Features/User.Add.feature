Feature: Add User
  In order to manage
  As a super-admin user profile
  I need to add a user. 

@javascript
Scenario: Add a user with non super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Add"
  When I fill in the following:
  | Firstname          | Firstadded         |
  | Name               | Added              |
  | Displayname        | displayAdded       |
  | Username           | useradded          |
  | Password           | passAdded          |
  | Email              | added@example.com  |
  | Details (optional) | User added         |
  And I press "Save"
  Then I should see "User added successfully"
  And I should see the following view form:
  | Firstname   | Firstadded        |
  | Name        | Added             |
  | Displayname | displayAdded      |
  | Username    | useradded         |
  | Email       | added@example.com |
  | Details     | User added        |
  And the view checkbox "Superadmin" should not be checked
  And the view checkbox "Locked" should not be checked
  And I follow "Log out"
  And I am logged in as "useradded" with the password "passAdded"

@javascript
Scenario: Add a user with super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Add"
  When I fill in the following:
  | Firstname          | Firstadded         |
  | Name               | Added              |
  | Displayname        | displayAdded       |
  | Username           | useradded          |
  | Password           | passAdded          |
  | Email              | added@example.com  |
  | Details (optional) | User added         |
  And I check "Super admin"
  And I press "Save"
  Then I should see "User added successfully"
  And I should see the following view form:
  | Firstname   | Firstadded        |
  | Name        | Added             |
  | Displayname | displayAdded      |
  | Username    | useradded         |
  | Email       | added@example.com |
  | Details     | User added        |
  And the view checkbox "Superadmin" should be checked
  And the view checkbox "Locked" should not be checked

@javascript
Scenario: Add a locked user
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Add"
  When I fill in the following:
  | Firstname          | Firstadded         |
  | Name               | Added              |
  | Displayname        | displayAdded       |
  | Username           | useradded          |
  | Password           | passAdded          |
  | Email              | added@example.com  |
  | Details (optional) | User added         |
  And I check "Locked"
  And I press "Save"
  Then I should see "User added successfully"
  And the view checkbox "Superadmin" should not be checked
  And the view checkbox "Locked" should be checked

@javascript
Scenario Outline: Impossible to add a user with data too short
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Add"
  When I fill in the following:
  | Firstname   | Firstadded        |
  | Name        | Added             |
  | Displayname | displayAdded      |
  | Username    | useradded         |
  | Password    | passAdded         |
  | Email       | added@example.com |
  And I fill in "<field>" with "x"
  And I press "Save"
  Then I should see "This value is too short. It should have 2 characters or more."

  Examples:
  | field       |
  | Firstname   |
  | Name        |
  | Displayname |
  | Username    |

@javascript
Scenario: Impossible to add a user with wrong mail
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Add"
  When I fill in the following:
  | Firstname   | Firstadded   |
  | Name        | Added        |
  | Displayname | displayAdded |
  | Username    | useradded    |
  | Password    | passAdded    |
  | Email       | wrongMail    |
  And I press "Save"
  Then I should be on "/user/add"


@javascript
Scenario: Impossible to add a user with no password
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Add"
  When I fill in the following:
  | Firstname   | Firstadded        |
  | Name        | Added             |
  | Displayname | displayAdded      |
  | Username    | useradded         |
  | Email       | added@example.com |
  And I press "Save"
  Then I should be on "/user/add"

@javascript
Scenario Outline: Impossible to add a user with duplicate data
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Users"
  And I follow "Add"
  When I fill in the following:
  | Firstname   | Firstadded        |
  | Name        | Added             |
  | Displayname | displayAdded      |
  | Username    | useradded         |
  | Password    | passAdded         |
  | Email       | added@example.com |
  And I fill in "<field>" with "<value>"
  And I press "Save"
  Then I should see "A user with this <message> already exists."

  Examples:
  | field       | value            | message     |
  | Displayname | displayuser      | displayname |
  | Username    | useruser         | username    |
  | Email       | user@example.com | email       |
