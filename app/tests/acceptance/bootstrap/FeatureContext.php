<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        // Initialize your context here
    }

    /**
     * @static
     * @beforeSuite
     */
    public static function bootstrapLaravel()
    {
        //$unitTesting = true;
        //$testEnvironment = 'testing';

        require_once __DIR__ .'/../../../../bootstrap/start.php';
        Artisan::call('migrate:refresh');
    }
    
    /**
     * @Given /^a category "([^"]*)" exists$/
     */
    public function aCategoryExists($name)
    {
        Artisan::call('migrate:refresh');
        Log::info($name);
        $category = new Category;
        $category->name = ($name);
        $category->save();
    }
}
