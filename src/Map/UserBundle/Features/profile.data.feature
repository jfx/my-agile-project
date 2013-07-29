Feature: Profile
  In order to see my personal data
  As a connected user
  I need to see my profile page. 

@javascript
Scenario: Display user data
  Given I am a user
  When I follow "Admin"
  And I follow "Profile"
  Then I should be on "/user/profile"
  And I should see the following view form:
  | Firstname   | Firstuser             |
  | Name        | User                  |
  | Displayname | displayuser           |
  | Username    | useruser              |
  | Email       | user@example.com      |
  | Details     | user role on domain 1 |
  And the view checkbox "Superadmin" should not be checked

@javascript
Scenario: Display super-admin data
  Given I am a super-admin
  When I follow "Admin"
  And I follow "Profile"
  Then I should be on "/user/profile"
  And I should see the following view form:
  | Firstname   | Firstadmin        |
  | Name        | Admin             |
  | Displayname | displayadmin      |
  | Username    | useradmin         |
  | Email       | admin@example.com |
  | Details     | Admin user        |
  And the view checkbox "Superadmin" should be checked