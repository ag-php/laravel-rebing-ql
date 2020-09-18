<?php

declare(strict_types=1);

namespace App\Base\Logic\DateFormat;

use Carbon\Carbon;

class DateFormat
{
    private Carbon $date;

    private string $fullTime = 'M d, Y h:m A';

    private string $day = 'M d, Y';

    private string $hour = 'hh:mm A';

    public function __construct(Carbon $date)
    {
        $this->date = $date;
    }

    public function getFullTime(): string
    {
        return (string) $this->date->format($this->fullTime);
    }
}
