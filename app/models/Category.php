<?php

class Category extends Eloquent {
	protected $guarded = array('id', 'created_at');
    protected $fillable = array('name', 'category_id');
    public $errors;

	public static $rules = array('name' => 'required|min:2');

    /**
     * All Base Categories
     * Base Categories are categories without superior Category
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function baseCategories () {
        return Category::whereNull('category_id')->get();
    }

    /**
     * Returns all direct subordinate Categories of the superior Category
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function subordinateCategories() {
        return $this->hasMany('Category', 'category_id');
    }

    /**
     * Returns the superior Category of a subordinate Category
     *
     * @return Category
     */
    public function superiorCategory() {
        return $this->belongsTo('Category', 'category_id');
    }

    /**
     * Checks, if the category is a subordinate Category,
     * that has a superior Category
     *
     * @return boolean
     */
    public function hasSuperiorCategory() {
        return is_null($this->superiorCategory) ? false : true;
    }

    /**
     * Validates the input values with the given rules of the Category model
     * If invalid, errors class variable holds error messages
     *
     * @return boolean
     */
    public function validate($input = null) {
        $input = is_null($input) ? $this->attributes : $input;
        $v = Validator::make($input, static::$rules);

        if ($v->passes()) return true;

        $this->errors = $v->messages();
        return false;
    }

    /**
     * creates options for a select list with leading empty option
     * where the value is name and the id is id
     * @param type $ignoreSelf if true, returns all categories without itself, default is true
     * @return array
     */
    public function optionsForSelectList($ignoreSelf = true) {
        $options = array('' => null) + Category::lists('name', 'id');
        
        if ($ignoreSelf) {
            $options = array_except($options, $this->id);
        }
        
        return $options;
    }

    /**
     * Because the Dropdown list of forms offers empty values
     * and because of the database constraint
     * empty values get nulled
     *
     * @param int $categoryId
     */
    public function setCategoryIdAttribute($categoryId) {
        $this->attributes['category_id'] = empty($categoryId) ? null : $categoryId;
    }
}
