# Implementasi Fitur Lupa Password

## Ringkasan
Fitur lupa password telah berhasil diimplementasikan dengan menggunakan Laravel mail dan token-based authentication.

## Fitur yang Diimplementasikan

### 1. Database Migration
**File**: `database/migrations/2025_11_08_091840_create_password_reset_tokens_table.php`
- Membuat tabel `password_reset_tokens` dengan kolom:
  - `email` (string, indexed)
  - `token` (string, hashed)
  - `created_at` (timestamp)

### 2. Mail Class
**File**: `app/Mail/ResetPasswordMail.php`
- Class untuk mengirim email reset password
- Menerima token dan email sebagai parameter
- Menggunakan view `emails.reset-password`

### 3. Email Template
**File**: `resources/views/emails/reset-password.blade.php`
- Template email yang dikirim ke user
- Berisi link reset password dengan token
- Informasi bahwa link akan kadaluarsa dalam 60 menit

### 4. Controller Methods
**File**: `app/Http/Controllers/Auth/AuthController.php`

#### a. `forgotPasswordProcess()`
- Validasi email user
- Menghapus token lama (jika ada)
- Generate token baru (64 karakter random)
- Simpan token di database (dalam bentuk hash)
- Kirim email dengan link reset password

#### b. `resetPasswordProcess()`
- Validasi email, password, dan konfirmasi password
- Verifikasi token valid
- Cek apakah token sudah kadaluarsa (60 menit)
- Update password user
- Hapus token dari database
- Redirect ke halaman login

### 5. View Updates

#### Forgot Password View
**File**: `resources/views/pages/auth/forgot-password.blade.php`
- Form untuk input email
- Submit ke route `forgot.password.process`
- Validasi error handling
- Link kembali ke login

#### Reset Password View
**File**: `resources/views/pages/auth/reset-password.blade.php`
- Form untuk input password baru dan konfirmasi
- Hidden field untuk email (dari query string)
- Password strength meter
- Submit ke route `reset.password.process`

### 6. Routes
**File**: `routes/web.php`
Routes sudah dikonfigurasi:
```php
Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'forgotPasswordProcess'])->name('forgot.password.process');
Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset.password');
Route::post('reset-password/{token}', [AuthController::class, 'resetPasswordProcess'])->name('reset.password.process');
```

## Cara Penggunaan

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Konfigurasi Email (di file .env)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

**Catatan**: Untuk Gmail, gunakan App Password, bukan password akun biasa.

### 3. Flow Penggunaan
1. User klik "Lupa Password" di halaman login
2. User input email di halaman forgot password
3. Sistem mengirim email dengan link reset password
4. User klik link di email (link berisi token)
5. User input password baru dan konfirmasi
6. Password berhasil direset, user bisa login dengan password baru

## Keamanan
- Token disimpan dalam bentuk hash di database
- Token kadaluarsa setelah 60 menit
- Validasi email harus terdaftar di sistem
- Password minimal 8 karakter
- Password harus dikonfirmasi
- Token lama dihapus saat generate token baru
- Token dihapus setelah berhasil reset password

## Testing
Untuk testing di local development tanpa setup email:
- Email akan tercatat di `storage/logs/laravel.log` (jika menggunakan mail driver 'log')
- Atau gunakan service seperti Mailtrap atau MailHog untuk testing

## Troubleshooting
1. **Email tidak terkirim**: Cek konfigurasi MAIL di .env
2. **Token tidak valid**: Pastikan link tidak dipotong dan token lengkap
3. **Token kadaluarsa**: Token hanya valid 60 menit, minta link baru

## Dependencies yang Digunakan
- Laravel Mail
- Carbon (untuk handling timestamp)
- SweetAlert (untuk notifikasi)
- Hash facade (untuk hashing token)
