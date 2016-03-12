<?php
/******************************************************************************
 * An implementation of dicto (scg.unibe.ch/dicto) in and for PHP.
 * 
 * Copyright (c) 2016 Richard Klees <richard.klees@rwth-aachen.de>
 *
 * This software is licensed under The MIT License. You should have received 
 * a copy of the along with the code.
 */

namespace Lechimp\Dicto\Definition;

/**
 * Provides fluid interface to cannot.
 */
class Only {
    /**
     * @var Variable
     */
    private $var;

    public function __construct(Variable $var) {
        $this->var = $var;
    }

    public function can() {
        return new Can($this->var);
    }
}

