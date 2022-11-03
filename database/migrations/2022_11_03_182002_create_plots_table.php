<?php use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
 class CreatePlotsTable extends Migration {
    /** * Run the migrations. * * @return void */
    public function up() {
        Schema::create('plots', function (Blueprint $table) {
            $table->id(); $table->string('name');
            $table->double('size');
            $table->decimal('latitude',5,3);
            $table->decimal('longitude',5,3);
            $table->foreignId('farm_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->foreignId('crop_id')->nullable()->constrained()->onDelete('CASCADE');
            $table->softDeletes(); $table->timestamps(); });

        }
        /** * Reverse the migrations. * * @return void */
         public function down() {
            Schema::dropIfExists('plots');
        } }

