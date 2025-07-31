<?php
// app/Events/JobCompleted.php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

class JobCompleted
{
    use SerializesModels;

    public $status;
    public $productId;
    public $progress;  // Νέα μεταβλητή για την πρόοδο

    public function __construct($status, $productId, $progress = 0)
    {
        $this->status = $status;
        $this->productId = $productId;
        $this->progress = $progress;  // Καθορίζουμε την πρόοδο
    }
}
