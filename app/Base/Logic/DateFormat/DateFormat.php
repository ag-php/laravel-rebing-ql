<?php

declare(strict_types=1);
// phpcs:disable PEAR.Commenting

namespace App\Base\Logic\DateFormat;

class DateFormat
{
    private $date;

    private $fullTime = 'M d, Y h:m A';

    private $day = 'M d, Y';

    private $hour = 'hh:mm A';

    public function __construct(\Carbon\Carbon $date)
    {
        $this->date = $date;
    }

    public function getFullTime(): string
    {
        return (string) $this->date->format($this->fullTime);
    }
}
