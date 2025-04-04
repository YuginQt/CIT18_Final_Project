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
        Schema::table('users', function (Blueprint $table) {
            // Skip role if it already exists
            if (!Schema::hasColumn('users', 'role')) {
                $table->enum('role', ['patient', 'doctor'])->default('patient')->after('password');
            }
            
            // Add new columns
            if (!Schema::hasColumn('users', 'age')) {
                $table->integer('age')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('age');
            }
            if (!Schema::hasColumn('users', 'contact')) {
                $table->string('contact')->nullable()->after('gender');
            }
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('contact');
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'specialization')) {
                $table->string('specialization')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('users', 'license_number')) {
                $table->string('license_number')->nullable()->after('specialization');
            }
            if (!Schema::hasColumn('users', 'is_available')) {
                $table->boolean('is_available')->default(true)->after('license_number');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'age',
                'gender',
                'contact',
                'address',
                'date_of_birth',
                'specialization',
                'license_number',
                'is_available'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
