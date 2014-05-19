<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext,
    OrangeDigital\BusinessSelectorExtension\Context\BusinessSelectorContext;


/**
 * Features context.
 */
class FeatureContext extends BehatContext
{


    private $output;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('mink', new MinkContext($parameters));
        $this->useContext('BusinessSelectors', new BusinessSelectorContext($parameters));
    }

    /**
     * @Given /^I am in a directory "([^"]*)"$/
     */
    public function iAmInADirectory($dir)
    {
        if (!file_exists($dir)) {
            mkdir($dir);
        }
        chdir($dir);
    }

    /**
     * @Given /^I have a file named "([^"]*)"$/
     */
    public function iHaveAFileNamed($arg1)
    {
        touch($arg1);
    }

    /**
     * @When /^I run "([^"]*)"$/
     */
    public function iRun($command)
    {
        exec($command, $output);
        $this->output = trim(implode("\n", $output));
    }

    /**
     * @Then /^I should get:$/
     */
    public function iShouldGet(PyStringNode $string)
    {
        if ((string) $string !== $this->output) {
            throw new Exception(
                "Actual output is:\n" . $this->output
            );
        }
    }

    /**
     * @when /^I wait$/
     */
    public function iWait()
    {
        sleep(4);
    }


    /**
     * @When /^I press the xpath "([^"]*)"$/
     */
    public function iPressTheXpath($arg)
    {
        $node = $this->getSession()->getPage()->find('xpath', $arg);
        if($node) {
            $this->getSession()->getPage()->find('xpath', $arg)->press();
        } else {
            throw new Exception('Element not found');
        }
    }


    /**
     * @When /^I click the xpath "([^"]*)"$/
     */
    public function iClickTheXpath($arg)
    {
        $node = $this->getSession()->getPage()->find('xpath', $arg);
        if($node) {
            $this->getSession()->getPage()->find('xpath', $arg)->click();
        } else {
            throw new Exception('Element not found');
        }
    }


    /**
     * @hidden
     *
     * @When /^I press the element "([^"]*)"$/
     */
    public function iPressTheElement($arg)
    {
        $node = $this->getSession()->getPage()->find('css', $arg);
        if($node) {
            $this->getSession()->getPage()->find('css', $arg)->press();
        } else {
            throw new Exception('Element not found');
        }
    }

    /**
     * @Given /^I reset the session$/
     */
    public function iResetTheSession() {
        $this->getSession()->reset();
    }

    /**
     * @Then /^I fill in wysiwyg on field "([^"]*)" with "([^"]*)"$/
     */
    public function iFillInWysiwygOnFieldWith($arg, $arg2)
    {
        $js = <<<HEREDOC
        jQuery("textarea[name='$arg']").css('visibility', 'visible');
        jQuery("textarea[name='$arg']").show();
HEREDOC;
        $this->getSession()->executeScript($js);
        $this->fillField($arg, $arg2);
    }
}
