<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up()
{
    if (!Schema::hasTable('sinistres')) {
        Schema::create('sinistres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('police_id');
            $table->date('date_sinistre');
            $table->text('description');
            $table->decimal('montant_estime', 10, 2);
            $table->decimal('montant_rembourse', 10, 2)->nullable();
            $table->string('statut')->default('en_attente');
            $table->timestamps();
            
            $table->foreign('police_id')->references('id')->on('polices')->onDelete('cascade');
        });
    }
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sinistres');
    }
};
