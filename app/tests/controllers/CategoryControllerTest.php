<?php

use Way\Tests\Factory;
use Way\Tests\Should;

class CategoryControllerTest extends TestCase {

    public function __construct() {
        $this->categoryId = 1;
        $this->validCategoryInput = ['name' => 'Category'];
        $this->invalidCategoryInput = ['name' => 'C'];
    }

    public function setUp() {
        parent::setUp();

        $this->categoryMock = Mockery::mock('Eloquent', 'Category');
        $this->categoryMock->shouldReceive('setAttribute')->passthru();
        $this->categoryMock->shouldReceive('getAttribute')->passthru();
        $this->categoryMock->shouldReceive('hasSetMutator')->passthru();
        $this->categoryMock->shouldReceive('hasGetMutator')->passthru();
        $this->categoryMock->shouldReceive('getDates')->passthru();
        $this->collectionMock = Mockery::mock('Illuminate\Database\Eloquent\Collection')->shouldDeferMissing();

        // Tell IoC Container, when need of Category, then inject this Category mock
        $this->app->instance('Category', $this->categoryMock);
    }

    public function tearDown() {
        Mockery::close();
    }

    public function testIndexProvidesListOfAvailableCategories() {
        $this->categoryMock
            ->shouldReceive('all')
            ->once()
            ->andReturn($this->collectionMock);

        $response = $this->get('categories');
        $categories = $response->original->getData()['categories'];

        $this->assertResponseOk();
        $this->assertViewHas('categories');
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $categories, 
            'CategoryController should give collection of categories to the view.');
    }

    public function testCreateProvidesOptionsForCategorySelect() {
        $expectedOptions = ['listOptionsId' => 'listOptionsValue'];
        $this->categoryMock
            ->shouldReceive('optionsForSelectList')
            ->once()
            ->andReturn($expectedOptions);

        $response = $this->get('categories/create');
        $categoryOptions = $response->original->getData()['category_options'];

        $this->assertResponseOk();
        $this->assertViewHas('category_options');
        Should::equal($expectedOptions, $categoryOptions, 
            'CategoryController should give category options with an empty option for base categories to the create view');
    }

    public function testStoreSavesWithValidInput() {
        $this->validateCategory($this->validCategoryInput, true);
        $this->categoryMock
            ->shouldReceive('create')
            ->with($this->validCategoryInput)
            ->once();

        $this->call('POST', 'categories', $this->validCategoryInput);

        $this->assertRedirectedToRoute('categories.index');
    }

    public function testStoreFailsWithInvalidInput() {
        $this->validateCategory($this->invalidCategoryInput, false);

        $this->call('POST', 'categories', $this->invalidCategoryInput);

        $this->assertRedirectedToRoute('categories.create');
        $this->assertSessionHasErrors();
        $this->assertSessionHas('message');
    }

    public function testShowProvidesRequestedCategory() {
        $this->categoryMock->id = $this->categoryId;
        $this->categoryMock->shouldReceive('findOrFail')
            ->with($this->categoryId)
            ->once()
            ->andReturn($this->categoryMock);

        $viewMock = View::shouldReceive('make')
            ->with('categories.show')
            ->once()
            ->andReturn(Mockery::self());
        $viewMock->shouldReceive('with')
            ->with('category', $this->categoryMock)
            ->once();

        $this->call('GET', 'categories/' . $this->categoryId);

        $this->assertResponseOk();
    }

    public function testEditProvidesRequestedCategory() {
        $expectedOptions = ['listOptionsId' => 'listOptionsValue'];
        
        $this->categoryMock->id = $this->categoryId;
        $this->categoryMock
            ->shouldReceive('optionsForSelectList')
            ->once()
            ->andReturn($expectedOptions);
        $this->categoryMock
            ->shouldReceive('findOrFail')
            ->with($this->categoryId)
            ->once()
            ->andReturn($this->categoryMock);

        $this->call('GET', 'categories/' . $this->categoryId . '/edit');

        $this->assertResponseOk();
        $this->assertViewHas('category');
        $this->assertViewHas('category_options');
    }

    public function testUpdateSavesWithValidInput() {
        $this->categoryMock
            ->shouldReceive('find')
            ->with($this->categoryId)
            ->andReturn($this->categoryMock);
        $this->validateCategory($this->validCategoryInput, true);
        $this->categoryMock
            ->shouldReceive('update')
            ->with($this->validCategoryInput)
            ->once();

        $this->call('PATCH', 'categories/' . $this->categoryId, $this->validCategoryInput);

        $this->assertRedirectedTo('categories/' . $this->categoryId);
    }

    public function testUpdateFailsWithInvalidInput() {
        $this->categoryMock
            ->shouldReceive('find')
            ->with($this->categoryId)
            ->andReturn($this->categoryMock);
        $this->validateCategory($this->invalidCategoryInput, false);

        $this->call('PATCH', 'categories/' . $this->categoryId, $this->invalidCategoryInput);

        $this->assertRedirectedTo('categories/' . $this->categoryId . '/edit');
        $this->assertSessionHasErrors();
        $this->assertSessionHas('message');
    }

    public function testDestroyDeletesCategory() {
        $this->deleteCategory($this->categoryId);

        $this->call('DELETE', 'categories/' . $this->categoryId);

        $this->assertRedirectedTo('categories');
        $this->assertSessionHas('message');
    }

    public function testDeleteDeletesCategory() {
        $this->deleteCategory($this->categoryId);

        $this->call('GET', 'categories/' . $this->categoryId . '/delete');

        $this->assertRedirectedTo('categories');
        $this->assertSessionHas('message');
    }

    private function deleteCategory($id) {
        $this->categoryMock
            ->shouldReceive('find')
            ->with($id)
            ->once()
            ->andReturn($this->categoryMock);
        $this->categoryMock
            ->shouldReceive('delete')
            ->once();
    }

    private function validateCategory($input, $returnValue) {
        $this->categoryMock
            ->shouldReceive('validate')
            ->with($input)
            ->once()
            ->andReturn($returnValue);
    }

}