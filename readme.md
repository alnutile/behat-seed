## Behat Seed Repo

The aim of this repo is to make it super easy to get going with behat. All you will need to get outside of this repo is

  * Selenium Jar file download
  * Composer
  * Saucelabs Account (Optional)
  
After you install and setup those items you will be able to run tests locally or via Saucelabs and have a base setup to add new/custom steps as needed.

### Selenium Easy

This is the one jar file you need

https://code.google.com/p/selenium/downloads/detail?name=selenium-server-standalone-2.39.0.jar&can=2&q=

The trick though is getting Java for your OS. For me, a Mac, I had to go here http://support.apple.com/kb/DL1572 ie avoid Oracles horrible download process at all costs. Linux is easy and Windows I am not sure about.

Once you have Java and Selenium open a terminal and go to the folder you will be keeping selenium and type

~~~
java -jar selenium-server-standalone-2.39.0.jar
~~~

This will output a lot of info to the screen and will remain running as you work. This line shows it is running

~~~
14:21:08.171 INFO - Started SocketListener on 0.0.0.0:4444
~~~

So now we can connect to that port later on.


### Composer

This is a great way to manage PHP dependencies and just enjoy the numerous libraries out there.

The install is pretty easy just type 

~~~
$ php composer.phar install
~~~

And then move that into /use/bin on your machine so you can now run it from anywhere. (this may take sudo powers)

### Behat Install

Finally download the repo https://github.com/alnutile/behat-seed
to a folder that you will store tests for a site or many sites.

For example

~~~
cd /opt
git clone https://github.com/alnutile/behat-seed
~~~

Then cd into behat-seed and lets start the composer install

~~~
cd behat-seed
composer install --prefer-dist
~~~

Comeback in 20 minutes (or less hopefully)

After that you should be able to run 

~~~
bin/behat --help
~~~

#### Layout of files and folders

This download and build of composer will leave you with this layout. 

****

~~~
/opt/behat-seed
|-tests
|--behat.yml
|--features
|  --bootstrap
|      FeatureContext.php
|    wikipedia.feature
|    wikipedia_tokens.feature
|-files
|-vendor
|-composer.json
|-composer.lock
|-bin
|  behat
|-dummy-site
~~~

Tests will be where we store the behat.yml file and tests files. We will explore that more in a moment.

Tests has a folder called features. In here we store our actual tests called *.feature. Example wikipedia.feature. 

Files is for storing files for a vanilla behat example.

Vendor is for composer as well as composer.lock and composer.json

Bin which stores behat only for now (really a symlink to the right area).

Finally dummy-site to run a php server for use to quickly test against.


#### Exploring our configuration

To start we are going to look at behat.yml so open up that file and you should see this in your editor. Keep in mind it is YAML format. So if you get errors then look for tabs and other formats that break YAML. Stick to spaces. 

Looking at the file

~~~
default:
  paths:
    features:  /opt/behat-seed/tests/features
    bootstrap: /opt/behat-seed/tests/features/bootstrap
  formatter:
    name: pretty
  extensions:
    OrangeDigital\BusinessSelectorExtension\Extension:
              urlFilePath: tests/urls.yml
              selectorFilePath: tests/selectors.yml
              assetPath: path
              timeout: 30
              contexts:
                UIBusinessSelector: ~
    Behat\MinkExtension\Extension:
      default_session: selenium2
      goutte: null
      selenium2: ~
      base_url: 'http://localhost:8080'
      browser_name: safari

saucelabs:
  extensions:
    Behat\MinkExtension\Extension:
      default_session: selenium2
      base_url: 'http://en.wikipedia.org/wiki/'
      selenium2:
        browser: chrome
        wd_host: 'behat-seed:fc5b688a-f27c-4c73-a914-eb5d7e2cdf1e@ondemand.saucelabs.com/wd/hub'
        capabilities:
          platform: 'Windows 2012'
          browser: chrome
          version: '26'
          name: 'Behat See'
          command-timeout: '600'
          max-duration: '600'

~~~

We will cover the details shortly. 

#### Running the local server

I included a simple php server and some test pages to try this out against
To get it going

~~~
cd dummy-site
php -S 127.0.0.1:8080
~~~

And you now can visit that url to see a site with numerous things to click and move.

## Now What

With all of this setup, selenium running then you can just run, for example, this command

~~~
bin/behat --config tests/behat.yml --profile saucelabs tests/features/local_tokens.feature
~~~

To see tokens in action. Or

~~~
bin/behat --config tests/behat.yml --profile saucelabs tests/features/local.feature
~~~

To see basic behat/mink Or to see it run but where? On Saucelabs.

~~~
bin/behat --config tests/behat.yml --profile saucelabs tests/features/wikipedia.feature
~~~

Even just testing linux/Mac so you can see that level of work.

~~~
bin/behat --config tests/behat.yml tests/features/pure_behat.feature
~~~

## RoadMap

  * Some more steps included. 
  * Test file upload and other form subissions
  * Base Vagrant install file

## Links

 * OrangeDigital https://github.com/orangedigital/business-selector-extension

 * Saucelabs https://saucelabs.com/

 * Some Code From 
   * [build apis you wont hate](https://github.com/philsturgeon/build-apis-you-wont-hate/blob/master/chapter8/app/tests/behat/features/bootstrap/FeatureContext.php)
 
 * Slim PHP http://www.slimframework.com/
  

 


