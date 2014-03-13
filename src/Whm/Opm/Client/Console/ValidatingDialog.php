<?php
namespace Whm\Opm\Client\Console;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Console\Helper\DialogHelper;

class ValidatingDialog
{

    private $dialogHelper;

    private $output;

    public function __construct (DialogHelper $dialogHelper, OutputInterface $output)
    {
        $this->dialogHelper = $dialogHelper;
        $this->output = $output;
    }

    public function ask ($question, Constraint $constraint, $notNull = true, $defaultValue = "")
    {
        $validator = Validation::createValidator();

        $validationCallback = function  ($answer) use( $constraint, $validator, $notNull)
        {
            $results = $validator->validateValue($answer, $constraint);
            if ($notNull && empty($answer)) {
                throw new \RuntimeException("This field must not be empty");
            }
            if ($results->count() > 0) {
                throw new \RuntimeException($results->get(0)->getMessage());
            }
            return $answer;
        };

        $answer = $this->dialogHelper->askAndValidate($this->output, $question, $validationCallback, false, $defaultValue);
        return $answer;
    }
}