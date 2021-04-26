<?php

namespace App\Models;

use \InvalidArgumentException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowItem extends Model
{
    use HasFactory;

    private $acceptedTypes = [
        'todo' => WorkflowToDoItem::class,
        'email' => WorkflowEmailItem::class,
        ];

    public function __construct(array $attributes = [])
    {
        if ( ! in_array($attributes["type"], $this->acceptedTypes) ) throw new InvalidArgumentException("Invalid type");

        return new $this->acceptedTypes[$attributes["type"]]($attributes);
    }
}
