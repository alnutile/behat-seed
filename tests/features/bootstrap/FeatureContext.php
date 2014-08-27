<?php

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext,
    OrangeDigital\BusinessSelectorExtension\Context\BusinessSelectorContext;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{

    /**
     * The Guzzle HTTP Client.
     */
    protected $client;

    /**
     * The current resource
     */
    protected $resource;

    /**
     * The request payload
     */
    protected $requestPayload;

    /**
     * The Guzzle HTTP Response.
     */
    protected $response;

    /**
     * The decoded response object.
     */
    protected $responsePayload;

    /**
     * The current scope within the response payload
     * which conditions are asserted against.
     */
    protected $scope;


    private $output;

    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct(array $parameters)
    {
        $this->useContext('BusinessSelectors', new BusinessSelectorContext($parameters));
    }

    /**
     * Check if the port is 443 or 80 eg secure or not.
     *
     * @Then /^the page is secure$/
     */
    public function thePageIsSecure()
    {
        $current_url = $this->getSession()->getCurrentUrl();
        if(strpos($current_url, 'https') === false) {
            throw new Exception('Page is not using SSL and is not Secure');
        }
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
        sleep(2);
    }

    /**
     * @when /^I wait for "([^"]*)" seconds$/
     */
    public function iWaitForSeconds($arg)
    {
        sleep($arg);
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
