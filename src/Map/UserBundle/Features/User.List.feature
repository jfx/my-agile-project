Feature: User.User.Users list
  In order to see users data
  As a connected user
  I need to see a users list. 

@javascript
Scenario: Display users list for a non super-admin profile
  Given I am a user
  When I follow "Admin"
  And I follow "Users"
  Then I should be on "/user/"
  And the columns of the table should match:
  | Name | Firstname | Displayname | Super-admin | Details |
  And I should see 8 rows in the table
  And the data of the table should match:
  | Name       | Firstname       | Displayname       | Super-admin | Details                                   |
  | Admin      | Firstadmin      | displayadmin      |             | Admin user                                |
  | D1-guest   | Firstd1-guest   | displayd1-guest   | -           | guest role on domain 1                    |
  | D1-manager | Firstd1-manager | displayd1-manager | -           | manager role on domain 1                  |
  | D1-none    | Firstd1-none    | displayd1-none    | -           | none role on domain 1                     |
  | D1-user+   | Firstd1-user+   | displayd1-user+   | -           | user+ role on domain 1                    |
  | Lock       | Firstlock       | displaylock       | -           | Locked user                               |
  | No-domain  | Firstno-domain  | displayno-domain  | -           | user with no role on domain               |
  | User       | Firstuser       | displayuser       | -           | user role on domain 1 + user+ on domain 2 |

@javascript
Scenario: Display users list for a super-admin profile
  Given I am a super-admin
  When I follow "Admin"
  And I follow "Users"
  Then I should be on "/user/"
  And the columns of the table should match:
  | Action | # | Name | Firstname | Displayname | Username | Email | Super-admin | Locked | Details |
  And I should see 8 rows in the table
  And the data of the table should match:
  | Name       | Firstname       | Displayname       | Super-admin | Locked | Details                                   |
  | Admin      | Firstadmin      | displayadmin      |             | -      | Admin user                                |
  | D1-guest   | Firstd1-guest   | displayd1-guest   | -           | -      | guest role on domain 1                    |
  | D1-manager | Firstd1-manager | displayd1-manager | -           | -      | manager role on domain 1                  |
  | D1-none    | Firstd1-none    | displayd1-none    | -           | -      | none role on domain 1                     |
  | D1-user+   | Firstd1-user+   | displayd1-user+   | -           | -      | user+ role on domain 1                    |
  | Lock       | Firstlock       | displaylock       | -           |        | Locked user                               |
  | No-domain  | Firstno-domain  | displayno-domain  | -           | -      | user with no role on domain               |
  | User       | Firstuser       | displayuser       | -           | -      | user role on domain 1 + user+ on domain 2 |

@javascript
Scenario Outline: No actions buttons in users list for a non super-admin profile
  Given I am a user
  When I follow "Admin"
  And I follow "Users"
  Then I should be on "/user/"
  And I should not see "<action>" action button

  Examples:
  | action  |
  | Add     |
  | Edit    |
  | View    |
  | Delete  |