<?php

namespace Model\User;

class Validator
{
    public function validateSignupEmail(string $email1, string $email2) : string
    {
        if ($email1 !== $email2) {
            return 'The two emails are not the same!';
        }
        return '';
    }

    public function validateSignupPassword(string $pw1, string $pw2) : string
    {
        if ($pw1 !== $pw2) {
            return 'The two passwords does not match!';
        }
        return '';
    }
}