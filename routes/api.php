<?php

//INCLUI AS ROTAS DE AUTENTICAÇÃO DA API
include __DIR__.'/api/v1/auth.php';

//INCLUI AS ROTAS DEFAULT (V1)
include __DIR__.'/api/v1/default.php';

//INCLUI AS ROTAS DE DEPOIMENTOS (V1)
include __DIR__.'/api/v1/testimonies.php';

//INCLUI AS ROTAS DE USUÁRIOs (V1)
include __DIR__.'/api/v1/users.php';