Feature: Cost
  In order to track my costs
  As the user
  I want to be able to save information about costs

Scenario: User fills out create cost form
  Given I am on "cost/create"
  And I fill in "title" with "Car taxes"
  And I fill in "amount" with "245,30"
  And I fill in "date" with "18.12.2013"
  And I press "Submit"
  Then I should see "Car taxes"
  And I should see "245,30"
  And I should see "18.12.2013"