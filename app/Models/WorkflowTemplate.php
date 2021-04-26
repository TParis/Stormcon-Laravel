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

    public function sub_items() {
        return $this->email_items->concat($this->todo_items)->sortBy("order");
    }
}
