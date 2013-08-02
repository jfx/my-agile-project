Feature: User.Security.Login
  In order to use the application 
  As a anonymous user
  I need to login to the application

@javascript
Scenario Outline: Successful login
  Given I go to "/login"
  When I am logged in as "<username>" with the password "<password>"
  And I should see "Hello <message> !"

  Examples:
  | username  | password | message          |
  | useruser  | user     | Firstuser User   |
  | useradmin | admin    | Firstadmin Admin |

@javascript
Scenario Outline: Wrong credentials
  Given I go to "/login"
  When I fill in "Username:" with "<username>"
  And I fill in "Password:" with "<password>"
  And I press "Login"
  Then I should be on "/login"
  And I should see "Invalid username or password"

  Examples:
  | username   | password   |
  | wrong_user | user       |
  | useruser   | wrong_pass |
  | userlock   | wrong_pass |

@javascript
Scenario: Locked user
  Given I go to "/login"
  When I fill in "Username:" with "userlock"
  And I fill in "Password:" with "lock"
  And I press "Login"
  Then I should be on "/login"
  And I should see "User account is locked"