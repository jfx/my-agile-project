Feature: Domain.Domain.Delete Domain
  In order to manage domain
  As a super-admin user profile
  I need to delete a domain. 

Scenario: Delete a domain
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I should see "Domain Five"
  And I follow "Delete domain #5"
  When I press "Remove"
  And I follow "OK"
  Then I should be on "/domain/"
  And I should see "Domain removed successfully"
  And I should not see "Domain Five"

Scenario: Wrong domain Id
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  When I go to "/domain/del/999"
  Then I should see "404 Not Found"

Scenario: Cancel to delete a domain
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Delete domain #5"
  When I press "Remove"
  And I follow "Cancel"
  Then I should be on "/domain/del/5"

Scenario: Impossible to delete a domain
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Delete domain #1"
  When I press "Remove"
  And I follow "OK"
  Then I should be on "/domain/del/1"
  And I should see "Impossible to remove this item - Integrity constraint violation !"

Scenario: Return to list button
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  And I follow "Delete domain #5"
  When I follow "Return to list"
  Then I should be on "/domain/"