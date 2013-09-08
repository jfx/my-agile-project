Feature: Project.Project.View Project
  In order to see details about a specific project
  As a connected user
  I need to view project details. 

@javascript
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

@javascript
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

@javascript
Scenario: Edit button for a manager role on domain
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "View project #1"
  When I follow "Edit"
  Then I should be on "/project/edit/1"

@javascript
Scenario: Edit button not displayed for a non manager role
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I follow "View project #1"
  Then I should not see "Edit" action button

@javascript
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
