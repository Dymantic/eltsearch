<?php


namespace App\Placements;


class RecruitmentMessage
{
    public string $message;
    public string $contact_person;
    public string $email;
    public string $phone;

    public function __construct($info)
    {
        $this->message = $info['message'] ?? '';
        $this->contact_person = $info['contact_person'] ?? '';
        $this->email = $info['email'] ?? '';
        $this->phone = $info['phone'] ?? '';
    }

    public function toArray(): array
    {
        return [
            'message'        => $this->message,
            'contact_person' => $this->contact_person,
            'email'          => $this->email,
            'phone'          => $this->phone,
        ];
    }
}
