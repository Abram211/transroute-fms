<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('airports', function (Blueprint $t) {
            $t->id();
            $t->string('code', 5)->unique(); // IATA code e.g. JUB
            $t->string('name');
            $t->string('city');
            $t->string('country')->default('South Sudan');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('airports'); }
};
