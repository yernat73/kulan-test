<?php
declare(strict_types=1);

return [
    \App\Enums\DeliveryStatus::class => [
        \App\Enums\DeliveryStatus::REJECTED => 'Отклонено',
        \App\Enums\DeliveryStatus::PENDING => 'Ожидание ответа',
        \App\Enums\DeliveryStatus::APPROVED => 'Подтверждено',

    ]
];