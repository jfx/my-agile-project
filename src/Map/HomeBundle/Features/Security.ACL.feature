Feature: Home.Security.ACL
  In order to secure the application 
  As a user
  I need to have access only to granted pages

Scenario: Profile
  Given I check the following ACL table:
  | URL |  super-admin | manager | user+ | user | guest | none | Prerequisite |
  | /   |       Y      |    Y    |   Y   |  Y   |   Y   |  Y   |              |
