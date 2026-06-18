<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('crew_members', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('role'); // Pilot, Logistics Lead, etc.
            $t->string('phone')->nullable();
            $t->string('email')->nullable();
            $t->decimal('salary', 12, 2)->nullable();
            $t->enum('status', ['active','inactive'])->default('active');
            $t->timestamps();
        });
        Schema::create('flight_crew_member', function (Blueprint $t) {
            $t->id();
            $t->foreignId('flight_id')->constrained()->onDelete('cascade');
            $t->foreignId('crew_member_id')->constrained()->onDelete('cascade');
            $t->timestamps();
            $t->unique(['flight_id','crew_member_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('flight_crew_member');
        Schema::dropIfExists('crew_members');
    }
};
