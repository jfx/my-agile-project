Feature: User.Security.ACL
  In order to secure the application 
  As a user
  I need to have access only to granted pages

Scenario: Profile
  Given I check the following ACL table:
  | URL            |  super-admin | manager | user+ | user | guest | none | Prerequisite |
  | /user/profile  |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   |              |
  | /user/password |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   |              |
  | /user/role     |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   |              |

Scenario: User
  Given I check the following ACL table:
  | URL          |  super-admin | manager | user+ | user | guest | none | Prerequisite |
  | /user/       |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   |              |
  | /user/add    |       Y      |    N    |   N   |  N   |   N   |  N   |              |
  | /user/1      |       Y      |    N    |   N   |  N   |   N   |  N   |              |
  | /user/edit/1 |       Y      |    N    |   N   |  N   |   N   |  N   |              |
  | /user/del/1  |       Y      |    N    |   N   |  N   |   N   |  N   |              |
  | /user/role/1 |       Y      |    N    |   N   |  N   |   N   |  N   |              |
