Feature: Category
  In order to structure my costs
  As the user
  I want to be able to categorize costs hierarchically

Scenario: User fills out create category form
  Given I am on "categories/create"
  When I fill in "name" with "Car"
  And I press "Submit"
  Then I should see "Car"
  And I should see "Category successfully created!"

Scenario: User fills out create category form with a parent category
  Given a category "Living" exists
  And I am on "categories/create"
  When I fill in "name" with "Supermarket"
  And I select "Living" from "category_id"
  And I press "Submit"
  Then I should see "Supermarket"
  And I should see "(in Living)"

Scenario: User fills out create category form with empty data
  Given I am on "categories/create"
  When I press "Submit"
  Then I should see "The name field is required."

Scenario: User fills out create category form with invalid data
  Given I am on "categories/create"
  When I fill in "name" with "C"
  And I press "Submit"
  Then I should see "The name must be at least 2 characters."

Scenario: User navigates to edit form of category
  Given a category "Living" exists
  And I am on "categories"
  When I follow "Edit Living"
  Then the "name" field should contain "Living"
  And I should see "Submit"

Scenario: User edits a category to set a new name
  Given a category "Living" exists
  And I am on "categories"
  When I follow "Edit Living"
  And I fill in "name" with "Supermarket"
  And I press "Submit"
  Then I should see "Supermarket"
  And I should not see "Living"

Scenario: User deletes a category
  Given a category "Living" exists
  And I am on "categories"
  When I follow "Delete Living"
  Then I should see "Category successfully deleted!"
  And I should not see "Living"
  