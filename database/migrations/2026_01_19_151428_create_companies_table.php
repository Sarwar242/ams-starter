<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();

            // ======================
            // 基本情報
            // ======================
            $table->string('company_name', 100)->comment('会社名');
            $table->string('company_furigana', 100)->nullable()->comment('会社名ふりがな');
            $table->string('postal_code', 10)->nullable()->comment('郵便番号');
            $table->string('address', 255)->nullable()->comment('住所');
            $table->string('telephone_number', 20)->nullable()->comment('電話番号');
            $table->string('email', 100)->nullable()->comment('代表メール');
            $table->string('address_line1')->nullable()->comment('Address line 1');
            $table->string('address_line2')->nullable()->comment('Address line 2 ');
    
            $table->string('logo_path', 255)->nullable()->comment('会社ロゴ（印刷用）');

            // ======================
            // 勤務ルール
            // ======================
            $table->unsignedSmallInteger('standard_daily_minutes')
                  ->default(480)
                  ->comment('所定労働時間（分）');

            $table->unsignedSmallInteger('standard_monthly_minutes')
                  ->nullable()
                  ->comment('所定労働時間（月・分）');

            $table->unsignedSmallInteger('overtime_start_minutes')
                  ->default(480)
                  ->comment('残業開始時間（分）');

            // ======================
            // 打刻制御フラグ
            // 10 = ON, 20 = OFF
            // ======================
            $table->unsignedTinyInteger('manual_stamp_flag')
                  ->default(10)
                  ->comment('手動打刻許可フラグ');

            $table->unsignedTinyInteger('gps_required_flag')
                  ->default(10)
                  ->comment('手動打刻時GPS必須');

            $table->unsignedTinyInteger('qr_stamp_only_flag')
                  ->default(20)
                  ->comment('QR打刻専用フラグ');

            // ======================
            // 環境・状態
            // ======================
            $table->string('timezone', 50)
                  ->default('Asia/Tokyo')
                  ->comment('タイムゾーン');

            $table->unsignedTinyInteger('is_active')
                  ->default(10)
                  ->comment('有効フラグ');

            // ======================
            // 監査項目（日本案件必須）
            // ======================
            $table->unsignedBigInteger('created')->nullable()->comment('作成者');
            $table->unsignedBigInteger('modified')->nullable()->comment('更新者');
            $table->timestamp('deleted_at')->nullable()->comment('論理削除日時');
            $table->unsignedBigInteger('deleted')->nullable()->comment('削除者');

            $table->timestamps();

            $table->index('company_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
