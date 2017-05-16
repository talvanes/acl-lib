  Feature: User Authorization

    Background:
      Given there are users:
         | username |
         | admin    |
         | talba    |
      And there are roles:
         | name    |
         | ADMIN   |
         | MANAGER |
         | USER    |
      And there are permissions:
         | label           |
         | view_permission |
         | edit_permission |

    @admin
    Scenario: the administrator (admin user) must have overall access
      Given I am user "admin"
      When I check if I belong to role "MANAGER"
      Then I should be granted access as "MANAGER"

    @admin
    Scenario: a user who belongs to ADMIN role must have overall access
      Given I am user "talba"
        And I belong to role "ADMIN"
      When I check if I belong to role "MANAGER"
      Then I should be granted access as "MANAGER"

    @role
    Scenario: non-existing users should be denied access since they do not belong to any role
      Given I am user "foo"
      When I check if I belong to role "USER"
      Then I should be denied access as "USER"

    @role
    Scenario: a user who does not belong to some role should not be allowed access to its features
      Given I am user "talba"
        And I belong to role "USER"
      When I check if I belong to role "MANAGER"
      Then I should be denied access as "MANAGER"

    @role
    Scenario: a user who belongs to some role should be allowed access to its features
      Given I am user "talba"
        And I belong to role "MANAGER"
      When I check if I belong to role "MANAGER"
      Then I should be granted access as "MANAGER"

    @permission
    Scenario: non-existing users should be denied access since they do not have any permissions
      Given I am user "foo"
      When I check if I have "view_permission" permission
      Then I should not perform "view_permission" feature

    @permission
    Scenario: a user who does not have some permission should not be allowed access to its feature
      Given I am user "talba"
        And I have "view_permission" permission
      When I check if I have "edit_permission" permission
      Then I should not perform "edit_permission" feature

    @permission
    Scenario: a user who has some permission should be allowed access to its feature
      Given I am user "talba"
      And I have "edit_permission" permission
      When I check if I have "edit_permission" permission
      Then I should perform "edit_permission" feature

    @permission @role
    Scenario: a permission that is part of some role should grant access to the user who belongs to it
      Given I am user "talba"
      And I belong to role "MANAGER"
      And role "MANAGER" has "edit_permission" feature
      When I check if I have "edit_permission" permission
      Then I should perform "edit_permission" feature

    @permission @role
    Scenario: a permission that is not part of some role should deny access to the user who belongs to it
      Given I am user "talba"
      And I belong to role "USER"
      And role "USER" has "view_permission" feature
      When I check if I have "edit_permission" permission
      Then I should not perform "edit_permission" feature
