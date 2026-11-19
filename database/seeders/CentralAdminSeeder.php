<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\CentralAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * اولین مدیر مرکزی. مقدارها از .env خوانده می‌شود:
 *   ADMIN_NAME=...
 *   ADMIN_MOBILE=09120000000
 *   ADMIN_EMAIL=admin@example.com   (اختیاری)
 *   ADMIN_PASSWORD=...              (اختیاری؛ اگر خالی باشد رمز تصادفی ساخته و یک‌بار چاپ می‌شود)
 * اگر کاربر با این موبایل وجود داشته باشد، چیزی بازنویسی نمی‌شود.
 */
class CentralAdminSeeder extends Seeder
{
    public function run(): void
    {
        $mobile = env('ADMIN_MOBILE');

        if (! $mobile) {
            $this->command?->warn('ADMIN_MOBILE در .env تنظیم نشده است؛ مدیر مرکزی ساخته نشد.');
            return;
        }

        $user = User::where('mobile', $mobile)->first();

        if (! $user) {
            $password = env('ADMIN_PASSWORD') ?: Str::password(16);

            $user = User::create([
                'name' => env('ADMIN_NAME', 'مدیر مرکزی'),
                'mobile' => $mobile,
                'email' => env('ADMIN_EMAIL'),
                'role' => UserRole::CentralAdmin,
                'status' => UserStatus::Active,
                'password' => $password,
            ]);

            if (! env('ADMIN_PASSWORD')) {
                $this->command?->info("رمز موقت مدیر مرکزی: {$password} (بعد از اولین ورود تغییر دهید)");
            }
        }

        CentralAdmin::firstOrCreate(
            ['user_id' => $user->id],
            ['title' => 'مدیر مرکزی', 'is_active' => true],
        );
    }
}
