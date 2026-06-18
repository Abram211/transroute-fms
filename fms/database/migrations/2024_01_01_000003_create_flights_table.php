<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('flights', function (Blueprint $t) {
            $t->id();
            $t->string('flight_number')->unique(); // e.g. TR-4921
            $t->string('airline')->default('TransRoute Airways');
            $t->foreignId('departure_airport_id')->constrained('airports')->onDelete('cascade');
            $t->foreignId('arrival_airport_id')->constrained('airports')->onDelete('cascade');
            $t->dateTime('departure_time');
            $t->dateTime('arrival_time');
            $t->string('gate')->nullable();
            $t->integer('capacity')->default(150);
            $t->decimal('base_fare', 10, 2)->default(100);
            $t->enum('status', ['scheduled','boarding','delayed','departed','arrived','cancelled'])->default('scheduled');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('flights'); }
};
