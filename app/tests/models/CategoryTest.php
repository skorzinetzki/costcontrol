<?php

class CategoryTest extends TestCase {
    use Way\Tests\ModelHelpers;

    public function testCategoryModelExists() {
        $category = new Category;
        $this->assertInstanceOf('Category', $category);
    }

    public function testIsInvalidWithoutName() {
        $category = new Category;

        $this->assertNotValid($category);
    }

    public function testIsInvalidWithTooShortName() {
        $category = new Category;
        $category->name = "A";

        $this->assertNotValid($category);
    }

    public function testIsValidWithName() {
        $category = new Category;
        $category->name = "Valid Name";

        $this->assertValid($category);
    }

    public function testEmptyCategoryIdToBeStoredAsNull() {
        $category = new Category;
        $category->category_id = '';

        $this->assertNull($category->category_id);
    }

}