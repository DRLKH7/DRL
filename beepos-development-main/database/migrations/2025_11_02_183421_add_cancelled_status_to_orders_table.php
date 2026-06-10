<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing status column to allow 'cancelled' value
        // Note: This is a documentation update as Laravel doesn't enforce enum at DB level by default
        // The validation is handled in the controller

        // Add comment to document allowed values
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` VARCHAR(255) DEFAULT 'pending' COMMENT 'Allowed values: draft, pending, paid, cancelled'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert the comment
        DB::statement("ALTER TABLE `orders` MODIFY COLUMN `status` VARCHAR(255) DEFAULT 'pending' COMMENT 'Allowed values: draft, pending, paid'");
    }
};
