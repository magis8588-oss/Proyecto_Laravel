<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
<<<<<<< HEAD:database/migrations/2025_12_01_040609_add_slug_to_appointments_table.php
        Schema::table('appointments', function (Blueprint $table) {
            //
=======
        // Safeguard: if the events table doesn't exist yet (fresh deploy), skip.
        if (!Schema::hasTable('events')) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            // Only add the column/constraint if it's not already present
            if (!Schema::hasColumn('events', 'fk_venue_event')) {
                $table->foreignId('fk_venue_event')->nullable()->constrained('venues', 'id');
            }
>>>>>>> dae037d809216cfd5c7ba73c1d9f36556e918e3d:database/migrations/2025_09_30_002852_add_new_column_to_events_table.php
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<< HEAD:database/migrations/2025_12_01_040609_add_slug_to_appointments_table.php
        Schema::table('appointments', function (Blueprint $table) {
            //
=======
        if (!Schema::hasTable('events')) {
            return;
        }

        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'fk_venue_event')) {
                $table->dropForeign(['fk_venue_event']);
                $table->dropColumn('fk_venue_event');
            }
>>>>>>> dae037d809216cfd5c7ba73c1d9f36556e918e3d:database/migrations/2025_09_30_002852_add_new_column_to_events_table.php
        });
    }
};
