Feature: Domain.Resource.Resources list
  In order to see resources data for a domain
  As a connected user
  I need to see resources list. 

@javascript
Scenario: Display resources list for a connected user
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #1"
  When I follow "Resources"
  Then the columns of the table should match:
  | Name | Displayname | Role |
  And I should see 5 rows in the table
  And the data of the table should match:
  | Name                       | Displayname       | Role    |
  | D1-guest Firstd1-guest     | displayd1-guest   | Guest   |
  | D1-manager Firstd1-manager | displayd1-manager | Manager |
  | D1-none Firstd1-none       | displayd1-none    | None    |
  | D1-user+ Firstd1-user+     | displayd1-user+   | User+   |
  | User Firstuser             | displayuser       | User    |

@javascript
Scenario: List with no resource for a connected user
  Given I am a user
  And I follow "Admin"
  And I follow "Domains"
  And I follow "View domain #5"
  When I follow "Resources"
  Then the columns of the table should match:
  | Name | Displayname | Role |
  And I should see 1 rows in the table
  And the table should contain "No resource"
