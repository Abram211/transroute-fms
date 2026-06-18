<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('luggages', function (Blueprint $t) {
            $t->id();
            $t->string('luggage_code')->unique(); // e.g. LUG-9021
            $t->foreignId('ticket_id')->constrained()->onDelete('cascade');
            $t->string('item_type'); // Suitcase, Backpack, Duffel...
            $t->string('description')->nullable();
            $t->decimal('weight', 6, 2)->default(0);
            $t->decimal('fee', 10, 2)->default(0);
            $t->enum('status', ['pending','checked_in','in_transit','picked','cancelled'])->default('pending');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('luggages'); }
};
