Feature: Click enter on form with not buttons

  Scenario: Page with form
    Given I am on "http://127.0.0.1:8080/"
    And I fill in "exampleInputEmail1" with "foo@foo.com"
    And I submit the form with an id of "email-form"
    And I wait
    Then I should see "You have submitted"
    And I wait
