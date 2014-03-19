<?php

/**
 * This file is part of the Open Performance Monitor Client package
 *
 * The Open Performance Monitor collects data to measure the performance of websites
 *
 * @package OPMCLient
 */

namespace Whm\Opm\Client\Console;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Console\Helper\DialogHelper;

/**
 * ValidatingDialog
 *
 * Validation of user input from the console
 *
 * @category Console
 * @package  OPMClient
 * @license  https://raw.github.com/thewebhatesme/opm_server/master/LICENSE
 * @version  GIT: $Id$
 * @since    2014-03-14
 * @author   Nils Langner <nils.langner@phmlabs.com>
 */
class ValidatingDialog
{

    /**
     * @var \Symfony\Component\Console\Helper\DialogHelper 
     */
    private $dialogHelper;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    private $output;

    /**
     * Constructor
     * 
     * @param \Symfony\Component\Console\Helper\DialogHelper    $dialogHelper
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(DialogHelper $dialogHelper, OutputInterface $output) {
        $this->dialogHelper = $dialogHelper;
        $this->output = $output;
    }

    /**
     * Ask method for user interaction
     * 
     * @param string    $question Question to be provided to the user
     * @param \Symfony\Component\Validator\Constraint $constraint
     * @param boolean   $notNull
     * @param string    $defaultValue
     * 
     * @return string entered answer
     * 
     * @throws \RuntimeException 
     */
    public function ask($question, Constraint $constraint, $notNull = true, $defaultValue = '') {
        $validator = Validation::createValidator();

        $validationCallback = function ($answer) use( $constraint, $validator, $notNull) {
            $results = $validator->validateValue($answer, $constraint);
            if ($notNull && empty($answer)) {
                throw new \RuntimeException('This field must not be empty');
            }
            if ($results->count() > 0) {
                throw new \RuntimeException($results->get(0)->getMessage());
            }
            return $answer;
        };

        $answer = $this->dialogHelper->askAndValidate(
                $this->output, $question, $validationCallback, false, $defaultValue
        );

        return $answer;
    }

}
