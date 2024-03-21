<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Security');

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        $this->loadComponent('CakeDC/Users.UsersAuth');
       

        // Important: add the 'enableBeforeRedirect' config or or disable deprecation warnings
       

    }
    public function beforeRender(Event $event)
    {

        $this->viewBuilder()->setTheme('AdminLTE');
        $this->viewBuilder()->setLayout('adminlte');
        $this->viewBuilder()->setClassName('AdminLTE.AdminLTE');
        // For CakePHP before 3.5
        //s$this->viewBuilder()->theme('AdminLTE');
        
    }
    public function beforeFilter(Event $event)
    {
        $this->loadModel('Cajas');
        $session = $this->request->getSession(); // less than 3.5
        // $session = $this->request->getSession(); // 3.5 or more
        $user_data = $session->read('Auth.User');
        //debug($user_data);
        $cajasabiertas = [];
        if(!empty($user_data)){
            //vamos a buscar si no hay una Caja Abierta para este usuario
            $cajasabiertas = $this->Cajas->find('all', [
                'contain'=>['Puntodeventas'],
                'conditions' => [
                    'Cajas.user_id'=>$user_data['id'],
                    "Cajas.cierre IS NULL"
                ]
            ]);
           
        }
        $userfiscal = false;
        if($user_data['role']=='fiscal'){
             $userfiscal = true;
        }
        $this->set('userfiscal', $userfiscal);
        $this->set('cajasabiertas', $cajasabiertas);
    }
}
