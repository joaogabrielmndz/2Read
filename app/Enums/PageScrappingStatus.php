<?php

namespace App\Enums;

enum PageScrappingStatus: string
{
    case Done = "done";
    case InProgress = "in_progress";
    case Failed = 'failed';
    case Cancelled = 'cancelled';
}
