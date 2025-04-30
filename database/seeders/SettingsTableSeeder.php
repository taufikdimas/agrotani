<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    public function run()
    {
        // Company Settings
        Setting::setValue('company_name', 'Nama Perusahaan Anda', 'company', 'Nama resmi perusahaan');
        Setting::setValue('company_address', 'Alamat perusahaan', 'company', 'Alamat lengkap perusahaan');
        Setting::setValue('company_city', 'Kota', 'company', 'Kota lokasi perusahaan');
        Setting::setValue('company_phone', '021-1234567', 'company', 'Nomor telepon perusahaan');
        Setting::setValue('company_email', 'info@perusahaan.com', 'company', 'Email perusahaan');
        Setting::setValue('company_logo', 'logo.png', 'company', 'Logo perusahaan');

        // Invoice Settings
        Setting::setValue('invoice_prefix', 'INV-', 'invoice', 'Prefix nomor invoice');
        Setting::setValue('invoice_footer', 'Terima kasih telah berbelanja', 'invoice', 'Catatan footer invoice');
        Setting::setValue('invoice_terms', 'Pembayaran jatuh tempo dalam 30 hari', 'invoice', 'Syarat dan ketentuan');
        Setting::setValue('bank_name', 'Bank ABC', 'invoice', 'Nama bank untuk pembayaran');
        Setting::setValue('bank_account', '123.456.789', 'invoice', 'Nomor rekening bank');
        Setting::setValue('bank_holder', 'Nama Perusahaan Anda', 'invoice', 'Pemilik rekening bank');
    }
}