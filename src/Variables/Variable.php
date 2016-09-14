<?php
/******************************************************************************
 * An implementation of dicto (scg.unibe.ch/dicto) in and for PHP.
 * 
 * Copyright (c) 2016 Richard Klees <richard.klees@rwth-aachen.de>
 *
 * This software is licensed under The MIT License. You should have received 
 * a copy of the license along with the code.
 */

namespace Lechimp\Dicto\Variables;

use Lechimp\Dicto\Definition as Def;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;
use Doctrine\DBAL\Query\Expression\CompositeExpression;

abstract class Variable extends Def\Definition {
    const CLASS_TYPE = "classes";
    const FILE_TYPE = "files";
    const GLOBAL_TYPE = "globals";
    const FUNCTION_TYPE = "functions";
    const METHOD_TYPE = "methods";
    const LANGUAGE_CONSTRUCT_TYPE = "language_construct";

    static public function is_type($t) {
        static $types = array
            ( "classes"
            , "files"
            , "globals"
            , "functions"
            , "methods"
            , "language_construct"
            );
        return in_array($t, $types);
    }

    /**
     * @var string|null
     */
    private $name;

    public function __construct($name = null) {
        assert('is_string($name) || ($name === null)');
        $this->name = $name;
    }

    /**
     * @return  string|null
     */
    public function name() {
        return $this->name;
    }

    /**
     * @param   string  $name
     * @return  self
     */
    public function withName($name) {
        assert('is_string($name)');
        $clone = clone $this;
        $clone->name = $name;
        return $clone;
    }

    /**
     * Get the meaning of the variable.
     *
     * In opposite to name, this gives insight in the structure of this variable.
     *
     * @return  string
     */
    abstract public function meaning();

    /**
     * Compile the variable to an sql expression.
     *
     * @param   ExpressionBuilder   $builder
     * @param   string              $name_table_name
     * @param   string              $method_info_table_name
     * @param   bool                $negate
     * @return  string|CompositeExpression
     */
    abstract public function compile(ExpressionBuilder $builder, $name_table_name, $method_info_table, $negate = false);
}

