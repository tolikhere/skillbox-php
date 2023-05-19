<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class IsBot extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'You shall not pass!';

    public function __construct(
        string $message = null,
        array $groups = null,
        mixed $payload = null
    ) {
        $this->message = $message ?? $this->message;
        parent::__construct([], $groups, $payload);
    }
}
