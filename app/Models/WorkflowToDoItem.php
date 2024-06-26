<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class WorkflowToDoItem extends WorkflowItem
{
    use HasFactory;

    protected $fillable = ['user_id', 'workflow_id', 'name', 'checklist', 'days', 'role', 'order', 'inspectable'];
    public $type = "todo";
    protected $casts = [
        'checklist' => 'array'
    ];

    public function assigned() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }


}
