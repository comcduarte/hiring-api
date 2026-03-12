<?php

declare(strict_types=1);

namespace Api\Job\InputFilter;

use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type CreateJobDataType array{}
 * @extends AbstractInputFilter<CreateJobDataType>
 */
class CreateJobInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        // chain inputs here
    }
}
