Feature: Domain.Security.ACL
  In order to secure the application 
  As a user
  I need to have access only to granted pages

Scenario: Project
  Given I check the following ACL table:
  | URL             |  super-admin | manager | user+ | user | guest | none | Prerequisite |
  | /dm-project/    |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   | /domain/1    |
  | /project/1      |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   | /domain/1    |
  | /project/add    |       N      |    Y    |   N   |  N   |   N   |  N   | /domain/1    |
  | /project/edit/1 |       N      |    Y    |   N   |  N   |   N   |  N   | /domain/1    |
  | /project/del/1  |       N      |    Y    |   N   |  N   |   N   |  N   | /domain/1    |
  | /project/add    |       N      |    N    |   N   |  N   |   N   |  N   | /domain/2    |
  | /project/edit/4 |       N      |    N    |   N   |  N   |   N   |  N   | /domain/2    |
  | /project/del/4  |       N      |    N    |   N   |  N   |   N   |  N   | /domain/2    |
