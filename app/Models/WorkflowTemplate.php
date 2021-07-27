<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkflowTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'priority'];

    public function email_items() {
        return $this->hasMany(WorkflowEmailItemTemplate::class);
    }

    public function todo_items() {
        return $this->hasMany(WorkflowToDoItemTemplate::class);
    }

    public function initial_items() {
        return $this->hasMany(WorkflowInitialEmailItemTemplate::class);
    }

    public function inspection_items() {
        return $this->hasMany(WorkflowInspectionItemTemplate::class);
    }

    public function sub_items() {
        return $this->email_items
            ->concat($this->todo_items)
            ->concat($this->initial_items)
            ->concat($this->inspection_items)
            ->sortBy("order");
    }
}
