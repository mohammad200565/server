<?php

use App\Models\Department;
use App\Models\Rent;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('edited_rents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rent::class);
            $table->foreignIdFor(User::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(Department::class)->constrained()->onDelete('cascade');
            $table->date('startRent');
            $table->date('endRent');
            $table->enum('status', ['cancelled', 'pending', 'completed', 'onRent'])->default('pending');
            $table->decimal('rentFee', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('edited_rents');
    }
};
