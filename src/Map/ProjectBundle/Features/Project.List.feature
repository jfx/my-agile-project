Feature: Domain.Project.Projects list
  In order to see projects for a domain
  As a connected user
  I need to see projects list. 

@javascript
Scenario: Display projects list on a domain for a connected user
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Projects"
  Then the columns of the table should match:
  | Action | Name | Start date | Finish date | Closed | Details |
  And I should see 3 rows in the table
  And the data of the table with dynamic date should match:
  | Name           | Start date          | Finish date         | Closed | Details                  |
  | Project Closed | 02/05/2013          | 31/07/2013          |        | Details 4 project closed |
  | Project One    | @date("- 2 months") | @date("+ 1 months") | -      | Details 4 project 1      |
  | Project Two    | @date("- 1 months") | @date("+ 2 months") | -      | Details 4 project 2      |

@javascript
Scenario: List with no project on a domain for a connected user
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #3"
  When I follow "Projects"
  Then the columns of the table should match:
  | Action | Name | Start date | Finish date | Closed | Details |
  And I should see 1 rows in the table
  And the table should contain "No project"

@javascript
Scenario: No action buttons Add/Edit/Delete for a non-manager
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Projects"
  Then I should see 3 rows in the table
  And I should see "View" action button
  And I should not see "Add" action button
  And I should not see "Edit" action button
  And I should not see "Delete" action button

@javascript
Scenario: Action buttons Add/Edit/Delete for a manager
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Projects"
  Then I should see 3 rows in the table
  And I should see "View" action button
  And I should see "Add" action button
  And I should see "Edit" action button
  And I should see "Delete" action button

@javascript
Scenario Outline: Links to see
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  When I follow "<link>"
  Then I should be on "<page>"

 Examples:
  | link      | page          |
  | Main      | /domain/1     |
  | Resources | /dm-resource/ |
