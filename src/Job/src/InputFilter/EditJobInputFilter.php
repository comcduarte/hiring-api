<?php

declare(strict_types=1);

namespace Api\Job\InputFilter;

use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type EditJobDataType array{}
 * @extends AbstractInputFilter<EditJobDataType>
 */
class EditJobInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        // chain inputs here
    }
}
