<?php
/******************************************************************************
 * An implementation of dicto (scg.unibe.ch/dicto) in and for PHP.
 * 
 * Copyright (c) 2016, 2015 Richard Klees <richard.klees@rwth-aachen.de>
 *
 * This software is licensed under The MIT License. You should have received 
 * a copy of the licence along with the code.
 */

use Lechimp\Dicto\App\Config;

class ConfigClassTest extends PHPUnit_Framework_TestCase {
    public function test_smoke() {
        $config = new Config(array
            ( "project" => array
                ( "root" => "/root/dir"
                )
            , "sqlite" => array
                ( "memory" => true
                , "path" => "/sqlite/path"
                )
            , "analysis" => array
                ( "ignore" => array
                    ( ".*\\.omit_me"
                    )
                )
            )
        );
        $this->assertEquals("/root/dir", $config->project_root());
        $this->assertEquals(true, $config->sqlite_memory());
        $this->assertEquals("/sqlite/path", $config->sqlite_path());
        $this->assertEquals(array(".*\\.omit_me"), $config->analysis_ignore());
    }
}
