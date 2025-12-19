<?php

use App\Models\Department;
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
            $table->string('headDescription')->nullable();
            $table->string('description')->nullable();
            $table->integer('area');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->integer('floor');
            $table->integer('rentCounter')->default(0);
            $table->double('rentFee');
            $table->boolean('isAvailable')->default(true);
            $table->integer('favoritesCount')->default(0);
            $table->enum('status', ['furnished', 'unfurnished', 'partially furnished']);
            $table->enum('verification_state', ['verified', 'pending', 'rejected'])->default('pending');
            $table->timestamps();
            $table->json('location');
        });

        Schema::create('favorits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Department::class)->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
