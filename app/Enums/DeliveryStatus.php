<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

/**
 * @method static static REJECTED()
 * @method static static PENDING()
 * @method static static APPROVED()
 */
final class DeliveryStatus extends Enum implements LocalizedEnum
{
    const REJECTED = -1;

    const PENDING = 0;

    const APPROVED = 1;
}
