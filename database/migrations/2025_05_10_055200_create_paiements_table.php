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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('police_id');
            $table->date('date_paiement');
            $table->decimal('montant', 10, 2);
            $table->string('methode_paiement');
            $table->string('reference_transaction')->nullable();
            $table->timestamps();
            
            $table->foreign('police_id')->references('id')->on('polices')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paiements');
    }
};
