<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInspectionView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW inspections_view AS
            SELECT id, [name], workflow_id, [order], created_at, updated_at
            FROM workflow_inspection_items
            UNION ALL
            SELECT id, [name], workflow_id, [order], created_at, updated_at
            FROM workflow_to_do_items WHERE inspectable = 1;
            ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW inspections_view;");
    }
}
