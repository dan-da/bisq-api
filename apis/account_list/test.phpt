<?php

namespace bitsquare_api\account_list;

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../lib/api_testcase_base.php');

class test extends \bitsquare_api\api_testcase_base {

    public function test_1() {
        $this->apicall_validate_response( '/api/account_list', null, __DIR__ . '/schema.json' );
    }

}

$t = new test();
$t->test_1();

exit(0);