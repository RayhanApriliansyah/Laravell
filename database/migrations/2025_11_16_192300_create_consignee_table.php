    <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        public function up()
        {
            Schema::create('consignee', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('npwp')->nullable()->unique();
                $table->string('address')->nullable();
                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('consignee');
        }
    };
