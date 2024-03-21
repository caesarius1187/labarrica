<?php
return [
        'Users.SimpleRbac.permissions' => [           
             /*
            //admin role allowed to all the things
	        [
	            'role' => 'admin',
	            'prefix' => '*',
	            'extension' => '*',
	            'plugin' => '*',
	            'controller' => '*',
	            'action' => '*',
	        ],
	        //specific actions allowed for the all roles in Users plugin
	        [
	            'role' => '*',
	            'plugin' => 'CakeDC/Users',
	            'controller' => 'Users',
	            'action' => ['profile', 'logout', 'linkSocial', 'callbackLinkSocial'],
	        ],
	       
	        [
	            'role' => '*',
	            'plugin' => 'CakeDC/Users',
	            'controller' => 'Users',
	            'action' => 'resetGoogleAuthenticator',
	            'allowed' => function (array $user, $role, \Cake\Http\ServerRequest $request) {
	                $userId = \Cake\Utility\Hash::get($request->getAttribute('params'), 'pass.0');
	                if (!empty($userId) && !empty($user)) {
	                    return $userId === $user['id'];
	                }
	                return false;
	            }
	        ],*/
	        //all roles allowed to Pages/display
	        [
	            'role' => 'administrador',
	            'prefix' => '*',
	            'extension' => '*',
	            'plugin' => '*',
	            'controller' => '*',
	            'action' => '*',
	        ],
	        [
	            'role' => 'operador',
	            'prefix' => '*',
	            'extension' => '*',
	            'plugin' => '*',
	            'controller' => '*',
	            'action' => ['view','index','add','addventa','edit','display','searchdata','profile', 'logout', 'login', 'linkSocial', 'callbackLinkSocial','search','cerrar','declararventa','getlastvoucher','listado','delete','ticketb']
	            /*Falta ['resumen']*/
	        ],
	        [
	            'role' => 'fiscal',
	            'prefix' => '*',
	            'extension' => '*',
	            'plugin' => '*',
	            'controller' => '*',
	            'action' => ['view','index','add','addventa','edit','display','searchdata','profile', 'logout', 'login', 'linkSocial', 'callbackLinkSocial','search','cerrar','declararventa','getlastvoucher','listado','ticketb']
	            /*Falta ['resumen']*/
	        ],
	        [
	            'role' => '*',
	            'controller' => [
                	'Pages'
                ],
                'action' => ['display']
	        ],
	        [
	            'role' => 'user',
	            'controller' => [
                	'Cajas','Users','Compras','Extracciones',
                	'Productos','Puntodeventas','Rubros','Ventas','Pages'
                ],
            	'action' => ['view','index','add','edit','display','searchdata']
	        ],
	        [
	            'role' => '*',
	            'plugin' => 'CakeDC/Users',
	            'controller' => 'Users',
	            'action' => ['profile', 'logout', 'linkSocial', 'callbackLinkSocial'],
	        ]
            
        ]
    ];
?>