<?php

declare(strict_types=1);

namespace Api\Job\InputFilter;

use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type ReplaceJobTypeDataType array{}
 * @extends AbstractInputFilter<ReplaceJobTypeDataType>
 */
class ReplaceJobTypeInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        // chain inputs here
    }
}
