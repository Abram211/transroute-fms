<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('shipments', function (Blueprint $t) {
            $t->id();
            $t->string('shipment_no')->unique(); // e.g. SHP-492
            $t->foreignId('flight_id')->constrained()->onDelete('cascade');
            $t->foreignId('ticket_id')->nullable()->constrained()->onDelete('set null'); // optional link to a passenger's ticket
            $t->string('sender_name');
            $t->string('sender_phone')->nullable();
            $t->string('receiver_name');
            $t->string('receiver_phone')->nullable();
            $t->text('description')->nullable();
            $t->decimal('weight', 8, 2)->default(0);
            $t->decimal('fee', 10, 2)->default(0);
            $t->enum('status', ['loaded','in_transit','delivered','cancelled'])->default('loaded');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('shipments'); }
};
