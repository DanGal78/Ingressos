<?php
return [
    "required" => "O campo :attribute é obrigatorio",
    "date" => "O campo : attribute precisa ser uma data válida",
    "string" => "O campo :attribute precias ser um texto",
    "exists" => "O campo :attribute nao existe no sistema",
    "after" => "O campo :attribute precisa ser uma data válida",
    "integer" => "O campo :attribute precisa ser um número inteiro",
    "unique" => "O campo :attribute precisa ser único",
    "decimal" => "O campo :attribute precisa ter entre :mim e :max casas decimais",
    "required_without" => "O campo :attribute precisa ser informado quando :values nao estiver presente",
    "required_without_all" => "O campo :attribute precisa ser informado quando :values estiver presente",
    "email" => "O campo :attribute precisa ser um email válido",
    "confirmed" => "O campo :attribute de confirmacao no confere",
    "min" => [
        "numeric" => "O campo :attribute precisa ser no minimo :min",
        "string" => "O campo :attribute precisa ter no minimo :min caracteres",
    ],

    "max" => [
        "numeric" => "O campo :attribute precisa ser no maximo :max",
        "string" => "O campo :attribute precisa ter no maximo :max caracteres",
    ],

];