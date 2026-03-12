<?php

declare(strict_types=1);

namespace Api\Job\InputFilter;

use Core\App\InputFilter\AbstractInputFilter;

/**
 * @phpstan-type EditJobTypeDataType array{}
 * @extends AbstractInputFilter<EditJobTypeDataType>
 */
class EditJobTypeInputFilter extends AbstractInputFilter
{
    public function __construct()
    {
        // chain inputs here
    }
}
