<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('tickets', function (Blueprint $t) {
            $t->id();
            $t->string('ticket_no')->unique(); // e.g. TK-4412-A
            $t->foreignId('user_id')->constrained()->onDelete('cascade'); // passenger
            $t->foreignId('flight_id')->constrained()->onDelete('cascade');
            $t->string('seat_no')->nullable();
            $t->decimal('fare', 10, 2)->default(0);
            $t->enum('status', ['pending','confirmed','cancelled','no_show','completed'])->default('pending');
            $t->timestamp('checked_in_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tickets'); }
};
