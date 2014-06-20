Feature: Testing WikiPedia

  Scenario: Lets go and look at the page
    Given I am on "http://en.wikipedia.org/wiki/Main_Page"
    Then I should see "Wiki"
  Scenario: Test the Featured Page
    Given I am on "http://en.wikipedia.org/wiki/Portal:Featured_content"
    Then I should see "Portal:Featured content"
  Scenario: Test Search
    Given I am on "http://en.wikipedia.org/wiki/Main_Page"
    Then I fill in "search" with "BDD"
    When I press "go"
    Then I should see "Behavior-driven development"