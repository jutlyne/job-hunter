<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnUrlZoomToApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->string('zoom_id')->after('apply_text')->nullable();
            $table->string('zoom_password')->after('zoom_id')->nullable();
            $table->string('zoom_url')->after('zoom_password')->nullable();
            $table->dateTime('due_at')->after('zoom_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['zoom_url', 'due_at', 'zoom_id', 'zoom_password']);
        });
    }
}
