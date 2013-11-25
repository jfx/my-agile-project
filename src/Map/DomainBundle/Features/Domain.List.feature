Feature: Domain.Domain.Domains list
  In order to manage domains data
  As a connected user
  I need to see domains list. 

Scenario: Display domains list for connected user
  Given I am a user
  When I follow "Admin"
  And I follow "Domains"
  Then I should be on "/domain/"
  And the columns of the table should match:
  | Action | # | Name | Details |
  And I should see 5 rows in the table
  And the data of the table should match:
  | Name         | Details            |
  | Domain Five  | Details 4 domain 5 | 
  | Domain Four  | Details 4 domain 4 | 
  | Domain One   | Details 4 domain 1 | 
  | Domain Three | Details 4 domain 3 | 
  | Domain Two   | Details 4 domain 2 | 

Scenario: View action button for a user
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  Then I should see 5 rows in the table
  And I should see "View" action button

Scenario Outline: No modify actions buttons in domains list for a non super-admin profile
  Given I am a user
  When I follow "Admin"
  And I follow "Domains"
  Then I should see 5 rows in the table
  And I should not see "<action>" action button

  Examples:
  | action |
  | Add    |
  | Edit   |
  | Delete |

Scenario Outline: Action buttons Add/View/Edit/Delete for a super-admin
  Given I am a super-admin
  And I follow "Admin"
  And I follow "Domains"
  Then I should see 5 rows in the table
  And I should see "<action>" action button

  Examples:
  | action |
  | Add    |
  | View   |
  | Edit   |
  | Delete |
