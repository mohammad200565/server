<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('size');
            $table->string('location');
            $table->decimal('rentFee', 10, 2);
            $table->boolean('isAvailable')->default(true);
            $table->enum('status', ['furnished', 'unfurnished', 'partially furnished']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
