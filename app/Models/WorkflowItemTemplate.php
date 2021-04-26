<?php

namespace App\Models;

use App\Http\Controllers\WorkflowEmailItemTemplateController;
use App\Http\Controllers\WorkflowToDoItemTemplateController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class WorkflowItemTemplate extends Model
{
    use HasFactory;

    const acceptedTypes = [
        'todo' => WorkflowToDoItemTemplate::class,
        'email' => WorkflowEmailItemTemplate::class,
        'todo_controller' => WorkflowToDoItemTemplateController::class,
        'email_controller' => WorkflowEmailItemTemplateController::class,
    ];

    /**
     * WorkflowItemTemplate constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        if ( ! array_key_exists($attributes["type"], $this->acceptedTypes) ) throw new InvalidArgumentException("Invalid type");

        $type  = self::acceptedTypes[$attributes["type"]];
        return new $type($attributes);

    }
}
