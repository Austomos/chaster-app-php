<?php

namespace ChasterApp\Parameters;

use JetBrains\PhpStorm\Pure;

final class Parameters
{
    #[Pure] public function criteria(): Criteria
    {
        return new Criteria();
    }
}