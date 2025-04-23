<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


 public function up(): void
 {
     Schema::create('lists', function (Blueprint $table) {
         $table->id();
         $table->string('title');
         $table->text('description')->nullable();
         $table->string('images')->nullable(); // Ensure this column exists
         $table->string('name')->nullable(); // Add name column
         $table->decimal('price', 10, 2)->nullable(); // Add price column
         $table->string('size')->nullable(); // Add size column
         $table->string('color')->nullable(); // Add color column
         $table->integer('quantity')->nullable(); // Add quantity column
         $table->foreignId('user_id')->constrained()->onDelete('cascade');
         $table->timestamps();
     });
 }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lists');
    }
};
