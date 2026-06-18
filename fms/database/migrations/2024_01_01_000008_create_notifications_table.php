<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('flight_notifications', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->onDelete('cascade');
            $t->foreignId('ticket_id')->nullable()->constrained()->onDelete('cascade');
            $t->enum('type', ['pre_takeoff','arrival','booking_confirmed','flight_delayed','booking_cancelled','general'])->default('general');
            $t->string('title');
            $t->text('message');
            $t->boolean('is_read')->default(false);
            $t->timestamp('sent_at')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('flight_notifications'); }
};
