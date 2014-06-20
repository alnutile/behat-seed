
  @javascript
  Feature: Example of Carousel
    Scenario: Make it move
      Given I am on "http://127.0.0.1:8080/"
      Then I should see "First Thumbnail label"
      And I should not see "Second Thumbnail label"
      And I follow "next-slide"
      And I wait
      Then I should see "Second Thumbnail label"
      And I fill in "exampleInputEmail1" with "some@email.com"
      And I wait for "10" seconds
      Then I should see "Third Thumbnail label"