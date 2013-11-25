Feature: Project.Project.Edit Project
  In order to manage a project
  As a user with a manager role
  I need to edit a project. 

Scenario: Edit a project
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Edit project #1"
  When I fill in the following with dynamic date:
  | Name        | Project Edited           |
  | Start date  | @date("+ 2 days")        |
  | Finish date | @date("+ 4 months")      |
  | Details     | Details 4 project edited |
  And I press "Save"
  Then I should see "Project edited successfully"
  And I should see the following view form with dynamic date:
  | Name        | Project Edited           |
  | Start date  | @date("+ 2 days")        |
  | Finish date | @date("+ 4 months")      |
  | Details     | Details 4 project edited |
  And the view checkbox "Closed" should not be checked
  And I follow "Return to domain"
  And I should see 3 rows in the table
  And the table should contain the row:
  | Name           | Details                  |
  | Project Edited | Details 4 project edited | 

Scenario: Close a project
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Edit project #1"
  When I fill in the following with dynamic date:
  | Name        | Project Added       |
  | Finish date | @date("")           |
  And I check "Closed"
  And I press "Save"
  Then I should see "Project edited successfully"
  And I should see the following view form with dynamic date:
  | Finish date | @date("")           |
  And the view checkbox "Closed" should be checked

Scenario: Open a closed project
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Edit project #3"
  When I uncheck "Closed"
  And I press "Save"
  Then I should see "Project edited successfully"
  And the view checkbox "Closed" should not be checked

Scenario: Impossible to edit a project with a name too short
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Edit project #1"
  When I fill in "Name" with "X"
  And I press "Save"
  Then I should see "This value is too short. It should have 2 characters or more."

Scenario Outline: Impossible to modify a project with wrong date
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Edit project #1"
  When I fill in "<field>" with "13/1x/1901"
  And I press "Save"
  Then I should see "This value is not valid."

  Examples:
  | field       |
  | Start date  |
  | Finish date |

Scenario: Impossible to modify a project with a finish date before a start date
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Edit project #1"
  When I fill in the following with dynamic date:
  | Name        | X                   |
  | Start date  | @date("+ 3 months") |
  | Finish date | @date("+ 1 days")   |
  And I press "Save"
  Then I should see "The finish date must be after the start date."

Scenario: Wrong project Id for a domain
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I go to "/project/edit/4"
  Then I should see "404 Not Found"

Scenario: Wrong project Id
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I go to "/project/edit/999"
  Then I should see "404 Not Found"

Scenario: Impossible to edit a project without selecting a domain before
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  When I go to "/project/edit/1"
  Then I should see "403 Forbidden"

Scenario Outline: Links to see
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Edit project #1"
  When I follow "<link>"
  Then I should be on "<page>"

 Examples:
  | link             | page             |
  | Domain One       | /dm-project/     |
  | Objectives       | /project/edit/1# |
  | Milestones       | /project/edit/1# |
  | Risks            | /project/edit/1# |
  | Return to domain | /dm-project/     |