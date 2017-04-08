bisq-api
========

This repository contains files pertaining to bisq APIs.

In particular the areas of:
* specification
* documentation
* schema validation
* unit testing

## Installation

### composer is required.

On Ubuntu 16.04:

    sudo apt install composer
 
On Ubuntu 14.04

    curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer
 
Anything else, visit http://getcomposer.com.

### now let's get to it! 

    $ git clone https://github.com/dan-da/bisq-api.git
    $ cd bisq-api
    $ composer install
 
## Building Docs

```
$ ./build-api-docs.sh 
API Docs are in apis/index.html and apis/README.md
```

Also, docs are viewable online at:
https://rawgit.com/dan-da/bisq-api/master/apis/index.html


## Running unit tests

The tests run against a running bisq (bitsquare) instance.

At the time of this writing, API support is only available in bisq on
development branch issue544-api.  So it is necessary to checkout and
build that branch first.  When you have done this, then you need to
start bitsquare and ensure that it is listening on port 8080.

You can verify that bitsquare API support is working by loading this url in a
browser:
 http://localhost:8080/apis/currency_list

Once that is working, proceed to run unit tests as follows:

```
$ ./run-api-tests.sh 
 _____ ___  ___ _____ ___  ___
|_   _/ __)( __/_   _/ __)| _ )
  |_| \___ /___) |_| \___ |_|_\  v1.7.1

PHP 7.0.15-0ubuntu0.16.04.4 | '/usr/bin/php' -c '/tmp/.php.ini' | 8 threads

...


OK (3 tests, 0.1 seconds)
```

## Directory layout

/                       project root.  contains shell scripts to perform actions.
    apis/               api root
        lib/            some common files
        <api>           each api has its own directory with apidoc, schema, and unit test files.
    vendor/             built automatically by composer.
        

## Docs build system

Documentation for each api is contained in /apis/\<api>/apidoc.php in a
structured data format without any display markup.

The build-api-docs.sh script processes each API directory and generates documentation
in both HTML and markdown formats. In the future it could be extended to
generated PDF or anything else.

## JSON Schema for API responses

API responses contain complex structured data that is difficult to validate
manually.

As such, a json schema is created for each API response, located in
/apis/\<api>/schema.json.

Initially, these schemas are created automagically by providing a sample JSON
response to this tool:

https://jsonschema.net/#/editor
 
Further manual editing of the schemas may be desirable as we go forward.

The unit tests for each API perform an API call and then validate the response
against the schema. Any validation error will cause the test to fail and the
errors are reported.

## API Versioning.

The API will be versioned according to the bitsquare release version.

There is no separate versioning.
