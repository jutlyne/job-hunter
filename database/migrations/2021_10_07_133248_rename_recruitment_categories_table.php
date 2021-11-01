<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameRecruitmentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recruitment_categories', function (Blueprint $table) {
            $table->renameColumn('recruitment', 'name')->after('seo_title');
            $table->dropColumn('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recruitment_categories', function (Blueprint $table) {
            $table->renameColumn('recruitment', 'name')->after('seo_title');
        });
    }
}
