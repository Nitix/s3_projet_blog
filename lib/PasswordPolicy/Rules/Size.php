<?php

namespace PasswordPolicy\Rules;

class Size extends Base {

    public function getMessage() {
        $constraint = parent::getMessage();
        return "Neccessite un mot de passe d'$constraint caractères";
    }

    public function test($password) {
        return $this->testConstraint(strlen($password), $password);
    }

    public function toJavaScript() {
        $ret = "{
            message: " . json_encode($this->getMessage()) . ",
            check: function(p) {
                return (" . $this->constraint->toJavaScript() . ")(p.length);
            }
        }";
        return $ret;
    }

}