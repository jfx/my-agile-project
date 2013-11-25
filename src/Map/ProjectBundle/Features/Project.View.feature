Feature: Project.Project.View Project
  In order to see details about a specific project
  As a connected user
  I need to view project details. 

Scenario: View a project details
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I follow "View project #1"
  Then I should be on "/project/1"
  And I should see the following view form with dynamic date:
  | Name        | Project One         |
  | Start date  | @date("- 2 months") |
  | Finish date | @date("+ 1 months") |
  | Details     | Details 4 project 1 |
  And the view checkbox "Closed" should not be checked

Scenario: View a closed project details
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I follow "View project #3"
  Then I should be on "/project/3"
  And I should see the following view form with dynamic date:
  | Name        | Project Closed           | 
  | Start date  | 02/05/2013               |
  | Finish date | 31/07/2013               |
  | Details     | Details 4 project closed |
  And the view checkbox "Closed" should be checked

Scenario: Wrong project Id for a domain
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I go to "/project/4"
  Then I should see "404 Not Found"

Scenario: Wrong project Id
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I go to "/project/999"
  Then I should see "404 Not Found"

Scenario: Impossible to view a project without selecting a domain before
  Given I am a user
  When I go to "/project/1"
  Then I should be on "/domain/"

Scenario: Edit button for a manager role on domain
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "View project #1"
  When I follow "Edit"
  Then I should be on "/project/edit/1"

Scenario: Edit button not displayed for a non manager role
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I follow "View project #1"
  Then I should not see "Edit" action button

Scenario Outline: Links to see
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "View project #1"
  When I follow "<link>"
  Then I should be on "<page>"

 Examples:
  | link             | page         |
  | Domain One       | /dm-project/ |
  | Objectives       | /project/1#  |
  | Milestones       | /project/1#  |
  | Risks            | /project/1#  |
  | Return to domain | /dm-project/ |
