<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('mails', function (Blueprint $table) {

            $table->increments('id');
            $table->string('mail_from')->nullable();
            $table->string('mail_to')->nullable();
            $table->string('subject')->nullable();
            $table->json('attachements')->nullable();
            $table->string('uuid')->nullable();
            $table->enum('status', ['queue', 'sent', 'fail', 'open'])->default('queue');
            $table->timestamp('created_date')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('opened_at')->nullable();
            $table->longText('template')->nullable();

            $table->unsignedInteger('created_by')->comment('created by user id')->nullable();
            $table->unsignedInteger('updated_by')->comment('updated by user id')->nullable();
            $table->unsignedInteger('deleted_by')->comment('deleted by user id')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('id');
            $table->index('mail_from');
            $table->index('mail_to');
            $table->index('subject');
            $table->index('status');
            $table->index('created_date');
            $table->index('sent_at');
            $table->index('opened_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::dropIfExists('mails');
    }
}
