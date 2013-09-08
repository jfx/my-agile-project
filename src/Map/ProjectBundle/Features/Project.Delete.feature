Feature: Project.Project.Delete Project
  In order to manage a project
  As a user with a manager role
  I need to delete a project. 

@javascript
Scenario: Delete a project
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Delete project #2"
  When I press "Remove"
  And I follow "OK"
  Then I should be on "/dm-project/"
  And I should see "Project removed successfully"
  And I should not see "Domain Two"

@javascript
Scenario: Cancel to delete a domain
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Delete project #2"
  When I press "Remove"
  And I follow "Cancel"
  Then I should be on "/project/del/2"

@javascript
Scenario: Impossible to delete a domain
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Delete project #1"
  When I press "Remove"
  And I follow "OK"
  And The next steps are failed
  Then I should be on "/project/del/1"
  And I should see "Impossible to remove this item - Integrity constraint violation !"

@javascript
Scenario Outline: Links to see
  Given I am logged in as "userd1-manager" with the password "d1-manager"
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I follow "Projects"
  And I follow "Delete project #1"
  When I follow "<link>"
  Then I should be on "<page>"

 Examples:
  | link             | page            |
  | Domain One       | /dm-project/    |
  | Return to domain | /dm-project/    |