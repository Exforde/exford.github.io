<?php 

    function GetBindParamType($val) {

        switch(gettype($val)) {
            case "string": return "s";
            case "integer": return "i";
            default: return null;
        }
    }

?>