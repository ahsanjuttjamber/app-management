<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $name;

    public function __construct($otp, $name)
    {
        $this->otp  = $otp;
        $this->name = $name;
    }

    public function build()
    {
        return $this->subject('Your OTP - Installment Lock System')
                    ->html("
                        <div style='font-family:Arial,sans-serif;max-width:500px;margin:0 auto;padding:30px;'>
                            <h2 style='color:#667eea;'>Email Verification</h2>
                            <p>Hello <strong>{$this->name}</strong>,</p>
                            <p>Your OTP verification code is:</p>
                            <div style='background:#f5f5f5;padding:20px;text-align:center;border-radius:8px;margin:20px 0;'>
                                <h1 style='color:#333;letter-spacing:10px;font-size:36px;'>{$this->otp}</h1>
                            </div>
                            <p style='color:#999;font-size:13px;'>This OTP expires in 10 minutes.</p>
                            <p style='color:#999;font-size:13px;'>If you did not request this, please ignore this email.</p>
                        </div>
                    ");
    }
}
