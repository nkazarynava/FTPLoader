<?php

/**
 * Created by PhpStorm.
 * User: Natalia
 * Date: 6/25/2016
 * Time: 18:23
 */
namespace Blogger\BlogBundle\Validator;

interface RuleChecker {

    public function check();
    public function getRuleName();

}