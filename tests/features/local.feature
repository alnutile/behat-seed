Feature: Test Local
  Scenario: Test Hello World
    Given I am on "/"
    And I wait
    Then I should see "First Thumbnail label"
    And I should not see "Second Thumbnail label"
    And I follow "next-slide"
    Then I should see "Second Thumbnail label"