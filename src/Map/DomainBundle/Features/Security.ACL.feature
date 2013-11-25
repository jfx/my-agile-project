Feature: Domain.Security.ACL
  In order to secure the application 
  As a user
  I need to have access only to granted pages

Scenario: Domain
  Given I check the following ACL table:
  | URL            |  super-admin | manager | user+ | user | guest | none | Prerequisite |
  | /domain/       |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   |              |
  | /domain/add    |       Y      |    N    |   N   |  N   |   N   |  N   |              |
  | /domain/1      |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   |              |
  | /domain/edit/1 |       Y      |    Y    |   N   |  N   |   N   |  N   |              |
  | /domain/del/1  |       Y      |    N    |   N   |  N   |   N   |  N   |              |

Scenario: Resource
  Given I check the following ACL table:
  | URL                 |  super-admin | manager | user+ | user | guest | none | Prerequisite |
  | /dm-resource/       |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   | /domain/1    |
  | /dm-resource/add    |       Y      |    Y    |   N   |  N   |   N   |  N   | /domain/1    |
  | /dm-resource/edit/2 |       Y      |    Y    |   N   |  N   |   N   |  N   | /domain/1    |
  | /dm-resource/del/2  |       Y      |    Y    |   N   |  N   |   N   |  N   | /domain/1    |
