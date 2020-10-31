<?php


namespace App;


class ContactDetails
{
    public string $phone;
    public string $email;

    public function __construct($info)
    {
        $this->phone = $info['phone'] ?? '';
        $this->email = $info['email'] ?? '';
    }

    public function emailOr($default): string
    {
        return $this->email === '' ? $default : $this->email;
    }

    public static function fake()
    {
        return new self([
            'email' => 'test@test.test',
            'phone' => '0123456789',
        ]);
    }

    public function toArray(): array
    {
        return [
            'email' => $this->email,
            'phone' => $this->phone,
        ];
    }
}
