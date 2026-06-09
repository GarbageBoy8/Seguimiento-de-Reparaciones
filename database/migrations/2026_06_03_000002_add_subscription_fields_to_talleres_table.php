<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('talleres', function (Blueprint $table) {
            $table->foreignId('plan_id')->nullable()->constrained('subscription_plans')->nullOnDelete();
            $table->string('codigo_publico', 20)->nullable()->unique();
            $table->timestamp('trial_ends_at')->nullable();
            $table->string('subscription_status', 30)->default('trial')->index();
            $table->timestamp('subscription_ends_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('talleres', function (Blueprint $table) {
            $table->dropForeign(['plan_id']);
            $table->dropColumn([
                'plan_id',
                'codigo_publico',
                'trial_ends_at',
                'subscription_status',
                'subscription_ends_at',
            ]);
        });
    }
};
