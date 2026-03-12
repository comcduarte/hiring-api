<?php

declare(strict_types=1);

namespace Api\Job\InputFilter;

use Api\Job\InputFilter\Input\StringInput;
use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type CreateJobTypeDataType array{}
 * @extends AbstractInputFilter<CreateJobTypeDataType>
 */
class CreateJobTypeInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        $this->add(new StringInput('type'));
    }
}
