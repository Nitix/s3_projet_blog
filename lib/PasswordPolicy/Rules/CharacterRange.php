<?php

namespace PasswordPolicy\Rules;

class CharacterRange extends Regex {

    public function __construct($range, $textDescription) {
        $this->description = "Neccessite %s $textDescription caractères";
        $this->regex = '/[' . $range . ']/';
    }

}