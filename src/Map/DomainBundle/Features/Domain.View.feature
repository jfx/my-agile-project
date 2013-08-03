Feature: Domain.Domain.View Domain
  In order to see details about a specific domain
  As a connected user
  I need to view domain details. 

@javascript
Scenario: View a domain details
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  Then I should be on "/domain/1"
  And I should see the following view form:
  | Name        | Domain One         |
  | Details     | Details 4 domain 1 |

@javascript
Scenario: Return to list button
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Return to list"
  Then I should be on "/domain/"

@javascript
Scenario: Edit button for super-admin profile
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Edit"
  Then I should be on "/domain/edit/1"

@javascript
Scenario: Edit button not displayed for non super-admin profile
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  And I should not see "Edit" action button
