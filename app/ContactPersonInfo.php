<?php


namespace App;

class ContactPersonInfo
{
    public string $name;
    public string $email;
    public string $phone;

    public function __construct($info)
    {
        $this->name = $info['contact_name'] ?? 'not provided';
        $this->email = $info['email'] ?? 'not provided';
        $this->phone = $info['phone'] ?? 'not provided';
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
