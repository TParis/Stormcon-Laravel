<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workflow extends Model
{
    use HasFactory;

    public function email_items() {
        return $this->hasMany(WorkflowEmailItem::class);
    }

    public function todo_items() {
        return $this->hasMany(WorkflowToDoItem::class);
    }

    public function sub_items() {

        $email_items = $this->email_items->map(function($item) {
            $item->template = 'workflow.email.';
        });

        $todo_items = $this->todo_items->map(function($item) {
            $item->template = 'workflow.todo.';
        });

        return $email_items->merge($todo_items);
    }
}
