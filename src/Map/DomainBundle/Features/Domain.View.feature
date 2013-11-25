Feature: Domain.Domain.View Domain
  In order to see details about a specific domain
  As a connected user
  I need to view domain details. 

Scenario: View a domain details
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  Then I should be on "/domain/1"
  And I should see the following view form:
  | Name        | Domain One         |
  | Details     | Details 4 domain 1 |

Scenario: Wrong domain Id
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  When I go to "/domain/999"
  Then I should see "404 Not Found"

Scenario: Return to list button
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Return to list"
  Then I should be on "/domain/"

Scenario: Edit button for super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Edit"
  Then I should be on "/domain/edit/1"

Scenario: Edit button not displayed for non super-admin profile
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  When I follow "View domain #1"
  Then I should not see "Edit" action button
