Feature: Test Local
  Scenario: Test Hello World
    Given I am on "/"
    And I wait
    And I fill in the "email box" field with "foo@foo.com"
    And I should see "foobaz" on the page
    And I wait
    And I wait
    And I wait
    And I wait
    And I wait