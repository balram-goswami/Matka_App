<?php

namespace App\Services;

class CommunicationService
{
    public function mail($emailTo = '', $emailSubject = '', $emailBody = '', array $attachments = [], $emailFromName = '', $emailFromEmail = '', $email_cc = '', $email_bcc = '')
    { 
        ini_set('max_execution_time', 600);
    
        $emailFromEmail = config('mail.from.address');
        $emailFromName = config('mail.from.name');
        try{
            \Mail::send(
                'Email.Index', 
                ['html' => $emailBody], 
                function($message) 
                use($emailTo, $emailSubject, $attachments, $emailFromName, $emailFromEmail, $email_cc, $email_bcc) 
                {
                    $message->from($emailFromEmail, $emailFromName);
                    $message->subject($emailSubject);
    
                    $message->to($emailTo);
    
                    if ($email_cc) {
                        $message->cc(explode(',', $email_cc));
                    }
                    if ($email_bcc) {
                        $message->cc(explode(',', $email_bcc));
                    }
                    if (!empty($attachments) &&  is_array($attachments)) {
                        foreach ($attachments as $attachment) {
                            $message->attach($attachment);
                        }
                    }        
                }
            );
        } catch (Exception $e) {
            return;
        }   
    }

    public function sms($phone, $otp)
    {
        try {
            $message = $otp . ' is your verification code. Matka will love to receive a call at 9813216000 during working hours 10 am to 6 pm Monday to Saturday.';
            $message = urlencode($message);
            $url = 'https://sms.innuvissolutions.com/api/mt/SendSMS?APIKey=HPDqkrByf06ds0yx0fAJ3g&senderid=MatkaPL&channel=Trans&DCS=0&flashsms=0&number=91' . $phone . '&text=' . $message . '&route=2&peid=1401438080000031179';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            // SSL important
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
