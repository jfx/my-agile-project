Feature: Project.Project.Add Project
  In order to manage a project
  As a user with a manager role
  I need to add a project. 

Scenario: Add a project
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Add"
  When I fill in the following with dynamic date:
  | Name        | Project Added           |
  | Start date  | @date("+ 1 days")       |
  | Finish date | @date("+ 3 months")     |
  | Details     | Details 4 project added |
  And I press "Save"
  Then I should see "Project added successfully"
  And I should see the following view form with dynamic date:
  | Name        | Project Added           |
  | Start date  | @date("+ 1 days")       |
  | Finish date | @date("+ 3 months")     |
  | Details     | Details 4 project added |
  And the view checkbox "Closed" should not be checked
  And I follow "Return to domain"
  And I should see 4 rows in the table
  And the table should contain the row:
  | Name          | Details                 |
  | Project Added | Details 4 project added | 

Scenario: Add a closed project with no details
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Add"
  When I fill in the following with dynamic date:
  | Name        | Project Added           |
  | Start date  | @date("+ 1 days")       |
  | Finish date | @date("+ 3 months")     |
  And I check "Closed"
  And I press "Save"
  Then I should see "Project added successfully"
  And I should see the following view form with dynamic date:
  | Name        | Project Added       |
  | Start date  | @date("+ 1 days")   |
  | Finish date | @date("+ 3 months") |
  | Details     |                     |
  And the view checkbox "Closed" should be checked

Scenario: Impossible to add a project with a name too short
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Add"
  When I fill in the following with dynamic date:
  | Name        | X                       |
  | Start date  | @date("+ 1 days")       |
  | Finish date | @date("+ 3 months")     |
  And I press "Save"
  Then I should see "This value is too short. It should have 2 characters or more."

Scenario Outline: Impossible to add a project with wrong date
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Add"
  When I fill in the following with dynamic date:
  | Name        | Project Added       |
  | Start date  | @date("+ 1 days")   |
  | Finish date | @date("+ 3 months") |
  And I fill in "<field>" with "13/1x/1901"
  And I press "Save"
  Then I should see "This value is not valid."

  Examples:
  | field       |
  | Start date  |
  | Finish date |

Scenario: Impossible to add a project with a finish date before a start date
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Add"
  When I fill in the following with dynamic date:
  | Name        | Project Added       |
  | Start date  | @date("+ 3 months") |
  | Finish date | @date("+ 1 days")   |
  And I press "Save"
  Then I should see "The finish date must be after the start date."

Scenario: Impossible to add a project without selecting a domain before
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  When I go to "/project/add"
  Then I should see "403 Forbidden"

Scenario Outline: Links to see
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Add"
  When I follow "<link>"
  Then I should be on "<page>"

 Examples:
  | link             | page         |
  | Domain One       | /dm-project/ |
  | Return to domain | /dm-project/ |