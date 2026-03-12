<?php

declare(strict_types=1);

namespace Api\Job\InputFilter\Input;

use Core\App\Message;
use Laminas\Filter\StringTrim;
use Laminas\Filter\StripTags;
use Laminas\InputFilter\Input;
use Laminas\Validator\NotEmpty;
use Laminas\Validator\StringLength;

class StringInput extends Input
{
    public function __construct(
        ?string $name = null,
        bool $isRequired = true,
    ) {
        parent::__construct($name);

        $this->setRequired($isRequired);
        $this->getFilterChain()
            ->attachByName(StringTrim::class)
            ->attachByName(StripTags::class);

        // chain more validators below

        $this->getValidatorChain()
            ->attachByName(NotEmpty::class, [
                'message' => Message::VALIDATOR_REQUIRED_FIELD,
            ], true)
            ->attachByName(StringLength::class, [
                'min' => 1,
                'max' => 100,
            ]);
    }
}
