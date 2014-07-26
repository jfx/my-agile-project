My Agile Project 2
==============
[![Build Status](https://travis-ci.org/jfx/my-agile-project.svg?branch=develop)](https://travis-ci.org/jfx/my-agile-project)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/jfx/my-agile-project/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/jfx/my-agile-project/?branch=develop)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/16faa3bb-fc5c-4bdb-b185-c7867a7480a7/mini.png)](https://insight.sensiolabs.com/projects/16faa3bb-fc5c-4bdb-b185-c7867a7480a7)

My Agile Project is an open source software to manage projects in general and 
more specifically Agile projects with those following features :

* Projects status and milestones,
* Management of requirements with tree and tabular view,
* Agile concepts : definition of iteration and burn-down charts.

- - -
### 0.6.0 ()
Features:

  - Add travis CI for multiple php version,
  - Add badges to readme page,
  - Add test name in code coverage report,
  - Migration to twitter bootstrap v3,
  - Bootstrap modal confirm box,
  - Bootstrap breadcrumb,

Bugfixes:

  - Remove specific location for log and cache dir,
  - Replace AccessDeniedHttpException by AccessDeniedException,
  - Refactoring of controller delete methods,
  - Remove config.php file,
  - Fix Phpunit tests issue,


### 0.5.0 (08 June 2014)
Features:

  - New Robot Framework tests for resources,
  - Resetting password feature and robot framework tests,
  - Login with email,
  - Badge for projects and resources on domain view,
  - Role check is initiated by project,
  - Breadcrumb improvement,
  - Migration to Symfony 2.4, 
  - Add Ladybug bundle,
  - View project for all connected users,
  - Select box by project,
  - Minimum length of password in change password form. 

Bugfixes:

  - Add a default password when adding a user without password,
  - Replacement of 403 error message by variable,
  - Remove unused methods,
  - Change conditional statements with null value,
  - Fix use statements,
  - Same 404 error pages checks between dev and prod env,
  - Fix Robot Framework test with Gmail.


### 0.4.0 (30 March 2014)
Features:

  - Robot framework tests automation,
  - Remove Behat/Mink features,
  - Code coverage listener.

Bugfixes:

  - Add missing title to buttons,
  - Fix API documentation error.


### 0.3.0 (25 November 2013)
Features:

  - Projects management,
  - Form validation evolution. Constraints in entity,
  - Behat/Mink features improvements.

Bugfixes:

  - 


### 0.2.0 (15 August 2013)
Features:

  - Migration to symfony 2.3,
  - Behat/Mink/PHPUnit integration,
  - Security features (login, logout),
  - Profile behat features,
  - User management behat features,
  - Domain management behat features,
  - Resource management behat features,
  - Home, header, footer behat features,
  - ACL behat features,
  - Order users list by name/firstname,
  - Change label to super-admin for administrator,
  - Update jquery to version 1.9.1.

Bugfixes:

  - <tr> tag missing in users light list,
  - Add title to buttons,
  - Entity manager closed after rollback on deleting domain,
  - Refresh role after domain change,
  - Fix API documentation errors.


### 0.1.0 (22 June 2013)
Features:

  - Migration to symfony framework,
  - Twitter bootstrap theme,
  - Users management,
  - Domains management,
  - Roles management.

Bugfixes:

  - 