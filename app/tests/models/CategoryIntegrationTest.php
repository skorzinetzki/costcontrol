<?php

use Way\Tests\Should;
use Way\Tests\Assert;

class CategoryIntegrationTest extends TestCase {

    public function setUp() {
        parent::setUp();

        Artisan::call('migrate:refresh');
    }

    private function createCategory($superiorCategory_id = null) {
        $subordinateCategory = new Category;
        if (isset($superiorCategory_id)) {
            $subordinateCategory->category_id = $superiorCategory_id;
        }
        $subordinateCategory->save();
        return $subordinateCategory;
    }

    public function testCategoryCanHaveASuperiorCategory() {
        // Arrange
        $superiorCategory = $this->createCategory();
        $subordinateCategory = $this->createCategory($superiorCategory->id);

        // Act
        $superiorCategoryHasSuperiorCategory = $superiorCategory->hasSuperiorCategory();
        $subordinateCategoryHasSuperiorCategory = $subordinateCategory->hasSuperiorCategory();

        // Assert
        Should::beFalse($superiorCategoryHasSuperiorCategory, 'superior category should not have a superior category for itself');
        Should::beTrue($subordinateCategoryHasSuperiorCategory, 'subordinate category should have a superior category');
    }

    public function testCategoryReturnsTwoSubordinateCategoriesWhenItHasTwoSubordinateCategories() {
        // Arrange
        $superiorCategory = $this->createCategory();
        $subordinateCategorie1 = $this->createCategory($superiorCategory->id);
        $subordinateCategorie2 = $this->createCategory($superiorCategory->id);

        // Act
        $subordinateCategories = $superiorCategory->subordinateCategories;

        // Assert
        foreach ($subordinateCategories as $category) {
            Assert::instance('Category', $category, 'the subordinateCategories query method does not return instances of Category');
            Should::equal(1, $category->category_id, 'the subordinate category has not the specified superior category');
        }

        Should::haveCount(2, $subordinateCategories, 'the count of the superior categories does not match as expected');
    }

    public function testCategoryReturnsSuperiorCategoryWhenItHasASuperiorCategory() {
        // Arrange
        $expectedCategory = $this->createCategory();
        $subordinateCategory = $this->createCategory($expectedCategory->id);

        // Act
        $superiorCategory = $subordinateCategory->superiorCategory;

        // Assert
        Assert::instance('Category', $superiorCategory, 'the superiorCategory query method does not return instance of Category');
        Should::equal($expectedCategory->id, $superiorCategory->id, 'the subordinate category has not the specified superior category');
    }

    public function testCanCollectCorrectCountBaseCategories() {
        // Arrange
        $baseCategory1 = $this->createCategory();
        $superiorButNotBaseCategory1 = $this->createCategory($baseCategory1->id);
        $subordinateCategory1 = $this->createCategory($superiorButNotBaseCategory1->id);
        $baseCategory2 = $this->createCategory();
        $subordinateCategory2 = $this->createCategory($baseCategory2->id);

        // Act
        $baseCategories = Category::baseCategories();

        // Assert
        Should::haveCount(2, $baseCategories, 'there were not the expected count of base categories');
    }

    public function testCreatesOptionsForSelectListWithAnEmptyOptionInFront() {
        // Arrange
        $category1 = $this->createCategory();
        $category2 = $this->createCategory();
        $expectedOptions = [
            '' => '',
            $category1->id => $category1->name,
            $category2->id => $category2->name
        ];

        // Act
        $options = $category1->optionsForSelectList(false);

        // Assert
        Should::equal($expectedOptions, $options);
    }
    
    public function testCreatesOptionsForSelectListWithoutCategoryItself() {
        // Arrange
        $category1 = $this->createCategory(1);
        $category2 = $this->createCategory(2);
        $expectedOptions = [
            '' => '',
            $category2->id => $category2->name
        ];

        // Act
        $options = $category1->optionsForSelectList(true);

        // Assert
        Should::equal($expectedOptions, $options);
    }
}