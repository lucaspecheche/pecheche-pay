<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

abstract class Event
{
    use InteractsWithSockets, SerializesModels;
}
