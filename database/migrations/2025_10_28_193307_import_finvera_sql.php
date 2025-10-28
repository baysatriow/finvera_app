<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        $path = database_path('schema/finvera_db.sql');

        if (file_exists($path)) {
            DB::unprepared(file_get_contents($path));
            echo "✅ Finvera database imported successfully.\n";
        } else {
            echo "⚠️ SQL file not found at: $path\n";
        }
    }

    public function down(): void
    {
        // DB::unprepared('DROP DATABASE finvera_db;');
    }
};
