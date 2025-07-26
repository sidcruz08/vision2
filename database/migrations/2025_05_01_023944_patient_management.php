<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('patient_code', 20)->unique();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('middle_name')->nullable();
            $table->date('birthdate');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained('patients');
            $table->date('visit_date');
            $table->enum('visit_type', ['Outpatient', 'Inpatient', 'Emergency']);
            $table->text('reason')->nullable();
            $table->string('doctor_name')->nullable();
            $table->enum('status', ['Ongoing', 'Completed', 'Cancelled']);
            $table->timestamps();
        });

        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits');
            $table->string('diagnosis_code');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('diagnosis_id');
            $table->string('treatment_type', 50);
            $table->text('notes')->nullable();
            $table->timestamps();
        
            $table->foreign('diagnosis_id')->references('id')->on('diagnoses')->onDelete('cascade');
        });

        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('visit_id')->constrained('visits');
            $table->foreignId('patient_id')->constrained('patients');
            $table->string('claim_number', 30)->unique();
            $table->date('claim_date');
            $table->decimal('claim_amount', 10, 2);
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Partially Approved', 'Paid']);
            $table->text('remarks')->nullable();
            $table->timestamps();
        });

        Schema::create('claim_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrained('claims');
            $table->string('item_description');
            $table->enum('item_type', ['Treatment', 'Medication', 'Lab', 'Room', 'Others']);
            $table->decimal('amount', 10, 2);
            $table->decimal('approved_amount', 10, 2)->nullable();
            $table->timestamps();
        });

        Schema::create('claim_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->constrained('claims')->onDelete('cascade');
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claim_approvals');
        Schema::dropIfExists('patient_insurances');
        Schema::dropIfExists('insurance_providers');
        Schema::dropIfExists('claim_items');
        Schema::dropIfExists('claims');
        Schema::dropIfExists('treatments');
        Schema::dropIfExists('diagnoses');
        Schema::dropIfExists('visits');
        Schema::dropIfExists('patients');
    }
};
