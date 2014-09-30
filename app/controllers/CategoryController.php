<?php

class CategoryController extends BaseController {

    protected $category;

    public function __construct(Category $category) {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $allCategories = $this->category->all();

        return View::make('categories.index')
                ->with('categories', $allCategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $categoryOptions = $this->category->optionsForSelectList();

        return View::make('categories.create')
                ->with('category_options', $categoryOptions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {

        if ($this->category->validate(Input::all())) {
            $this->category->create(Input::all());
            return Redirect::route('categories.index')
                    ->with('message', 'Category successfully created!');
        }

        return Redirect::route('categories.create')
			->withInput()
			->withErrors($this->category->errors)
			->with('message', 'There were validation errors.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        $category = $this->category->findOrFail($id);

        return View::make('categories.show')
                ->with('category', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $category = $this->category->findOrFail($id);
        $categoryOptions = $category->optionsForSelectList();

        return View::make('categories.edit')
                ->with('category', $category)
                ->with('category_options', $categoryOptions);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        $category = $this->category->find($id);

        if ($category->validate(Input::all())) {
            $category->update(Input::all());
            return Redirect::route('categories.show', $id)
                    ->with('message', 'Category successfully updated!');
        }

        return Redirect::route('categories.edit', $id)
			->withInput()
			->withErrors($category->errors)
			->with('message', 'There were validation errors.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        $this->category->find($id)->delete();

		return Redirect::route('categories.index')
                ->with('message', 'Category successfully deleted!');
    }

    public function delete($id) {
        return $this->destroy($id);
    }
}
