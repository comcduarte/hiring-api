<?php

declare(strict_types=1);

namespace Api\Job\InputFilter;

use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type ReplaceJobDataType array{}
 * @extends AbstractInputFilter<ReplaceJobDataType>
 */
class ReplaceJobInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        // chain inputs here
    }
}
