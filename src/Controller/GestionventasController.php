<?php
App::uses('AppController', 'Controller');
/**
 * Gestionventas Controller
 *
 * @property Gestionventa $Gestionventa
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class GestionventasController extends AppController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator', 'Session');
    public function beforeFilter() {
        parent::beforeFilter();
        $this->layout = 'default_gestion';
    }
    public $condicionesiva = array("monotributista" => 'Monotributista',"responsableinscripto" => 'Responsable Inscripto','consf/exento/noalcanza'=>"Cons. F/Exento/No Alcanza",);

/**
 * index method
 *
 * @return void
 */
    public function index() {
		$this->Gestionventa->recursive = 0;
		$this->set('gestionventas', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function view($id = null) {
        $this->loadModel('Cliente');
        if (!$this->Gestionventa->exists($id)) {
            throw new NotFoundException(__('Invalid gestionventa'));
        }
        $options = array(
            'contain'=>[
              'Cliente'=>[],
                'Puntosdeventa'=>[
                    'Domicilio'=>[
                        'Localidade'=>['Partido']
                    ]
                ]
            ],
            'conditions' => array(
                'Gestionventa.' . $this->Gestionventa->primaryKey => $id
                )
            );
        $this->set('gestionventa', $this->Gestionventa->find('first', $options));
        $periodo = date('m')."-".date('Y');
        $impclisactivados = $this->Cliente->impuestosActivados($id,$periodo);
        $this->set('impclisactivados', $impclisactivados);
    }

/**
 * add method
 *
 * @return void
 */
    public function add() {
        $this->loadModel('Puntosdeventa');
        App::import('Vendor', 'Afip/Afip');
        $cliente_id = $this->Session->read('Auth.User.cliente_id');
        //Servicio de testing NO BORRAR
        $afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);             
        //Debugger::dump($afip->ElectronicBilling->GetServerStatus());
//        $cuitcontribuyente = 20330462478;
//        $taxpayer_details = $afip->RegisterScopeFive->GetTaxpayerDetails((float)$cuitcontribuyente);//fede
//        Debugger::dump("taxpayer details");
//        Debugger::dump($taxpayer_details);
        //$puntosdeventa = $afip->ElectronicBilling->GetPointOfSales();
        //Debugger::dump($puntosdeventa);

        //$last_voucher = $afip->ElectronicBilling->GetLastVoucher(2,11);
        //Debugger::dump($last_voucher);                
        $conditionspuntosdeventa = array('Puntosdeventa.cliente_id' => $cliente_id,);
        $puntosdeventas = $this->Puntosdeventa->find('list',array('conditions' =>$conditionspuntosdeventa));
        
        $optionsListaVentas=array(
            'contain'=>[],
            'fields'=>[
                'nombre','documento'
            ],
            'conditions' =>array(
                'Gestionventa.cliente_id' => $cliente_id,
            )
        );
        $conditionsclientes = 
        $listaventas = $this->Gestionventa->find('all',$optionsListaVentas);
        $tiposcomprobantes = $afip->ElectronicBilling->GetVoucherTypes();
        $tiposdocumentos = $afip->ElectronicBilling->GetDocumentTypes();
        $tiposmonedas = $afip->ElectronicBilling->GetCurrenciesTypes();
        $tipostributos = $afip->ElectronicBilling->GetTaxTypes();
        $tiposalicuotas = $afip->ElectronicBilling->GetAliquotTypes();
        $tiposopcionales = $afip->ElectronicBilling->GetOptionsTypes();
        $condicionesiva = $this->condicionesiva;
        $this->set(compact('puntosdeventas','tiposcomprobantes',
                'tiposdocumentos','tiposmonedas','tipostributos','tiposalicuotas',
                'tiposopcionales','condicionesiva','listaventas','cliente_id'));
    }

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function edit($id = null) {
		if (!$this->Gestionventa->exists($id)) {
			throw new NotFoundException(__('Invalid gestionventa'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Gestionventa->save($this->request->data)) {
				$this->Session->setFlash(__('The gestionventa has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The gestionventa could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Gestionventa.' . $this->Gestionventa->primaryKey => $id));
			$this->request->data = $this->Gestionventa->find('first', $options);
		}
		$clientes = $this->Gestionventa->Cliente->find('list');
		$puntosdeventas = $this->Gestionventa->Puntosdeventum->find('list');
		$this->set(compact('clientes', 'puntosdeventas'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
    public function delete($id = null) {
        $this->Gestionventa->id = $id;
        if (!$this->Gestionventa->exists()) {
                throw new NotFoundException(__('Invalid gestionventa'));
        }
        $this->request->allowMethod('post', 'delete');
        if ($this->Gestionventa->delete()) {
                $this->Session->setFlash(__('The gestionventa has been deleted.'));
        } else {
                $this->Session->setFlash(__('The gestionventa could not be deleted. Please, try again.'));
        }
        return $this->redirect(array('action' => 'index'));
    }    
    public function guardarVenta(){
        $this->loadModel('Gestionventa');
        $this->loadModel('Gestiondetalleventa');
        $this->loadModel('Gestiontributo');
        $this->loadModel('Gestionalicuota');
        $this->loadModel('Gestioncamposopcionale');
        $this->loadModel('Gestioncomprobantesasociado');
        $this->loadModel('Gestioncomprobantesasociado');
        $respuesta = "";
        if($this->request->is('post')) {
            $this->Gestionventa->create();
            Debugger::dump($this->request->data);
            $this->request->data['Gestionventa'][0]['fecha'] = date('Y-m-d', strtotime($this->request->data['Gestionventa'][0]['fecha']));
            $this->request->data['Gestionventa'][0]['servdesde'] = date('Y-m-d', strtotime($this->request->data['Gestionventa'][0]['servdesde']));
            $this->request->data['Gestionventa'][0]['servhasta'] = date('Y-m-d', strtotime($this->request->data['Gestionventa'][0]['servhasta']));
            if($this->Gestionventa->save($this->request->data['Gestionventa'][0])){
                $idVenta = $this->Gestionventa->getLastInsertID();
                $miVenta = $this->request->data['Gestionventa'][0];
                
                //Detalle Venta
                foreach ($miVenta['Gestiondetalleventa'] as $kvd => $vd) {
                    $miVenta['Gestiondetalleventa'][$kvd]['gestionventa_id']=$idVenta;
                }
                if($this->Gestiondetalleventa->saveAll($miVenta['Gestiondetalleventa'])){
                    $respuesta.= "Detalle de Ventas guardados con exito .</br>";
                }else{
                    $respuesta.= "Error 2 .</br>";
                }
                //Tributos
                foreach ($miVenta['Gestiontributo'] as $kvd => $vd) {
                    $miVenta['Gestiontributo'][$kvd]['gestionventa_id']=$idVenta;
                }
                Debugger::dump($miVenta['Gestiontributo']);
                if($this->Gestiontributo->saveAll($miVenta['Gestiontributo'])){
                    $respuesta.= "Tributos guardados con exito .</br>";
                }else{
                    $respuesta.= "Error 3 .</br>";
                }
                //Alicuotas
                foreach ($miVenta['Gestionalicuota'] as $kvd => $vd) {
                    $miVenta['Gestionalicuota'][$kvd]['gestionventa_id']=$idVenta;
                }
                if($this->Gestionalicuota->saveAll($miVenta['Gestionalicuota'])){
                    $respuesta.= "Detalle de Ventas guardados con exito .</br>";
                }else{
                    $respuesta.= "Error 4 .</br>";
                }
                //Campos opcionales
                foreach ($miVenta['Gestioncamposopcionale'] as $kvd => $vd) {
                    $miVenta['Gestioncamposopcionale'][$kvd]['gestionventa_id']=$idVenta;
                }
                if($this->Gestioncamposopcionale->saveAll($miVenta['Gestioncamposopcionale'])){
                    $respuesta.= "Campos opcionales guardados con exito .</br>";
                }else{
                    $respuesta.= "Error 5 .</br>";
                }
                //Comprobantes asociados
                foreach ($miVenta['Gestioncomprobantesasociado'] as $kvd => $vd) {
                    $miVenta['Gestioncomprobantesasociado'][$kvd]['gestionventa_id']=$idVenta;
                }
                if($this->Gestioncomprobantesasociado->saveAll($miVenta['Gestioncomprobantesasociado'])){
                    $respuesta.= "Comprobantes asociados guardados con exito .</br>";
                }else{
                    $respuesta.= "Error 6 .</br>";
                }
            }else{
               $respuesta.= "Error 1 .</br>"; 
            }
        }
        $this->layout = 'ajax';
        $this->set('data', $respuesta);
        $this->render('serializejson');
    }
    public function declararVenta(){

    }
    public function GetLastVoucher($PtoVta,$CbteTipo){
        App::import('Vendor', 'Afip/Afip');
        $afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);    

        $ultimoComprobanteUsado = $this->Gestionventa->afipget($afip,'GetLastVoucher',$PtoVta,$CbteTipo,0);

        $response['respuesta'] = $ultimoComprobanteUsado['respuesta'][0];
        $this->layout = 'ajax';
        $this->set('data', $response);
        $this->render('serializejson');
    }
    public function GetPointOfSales(){
        App::import('Vendor', 'Afip/Afip');
        $afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);    

        $puntosdeventas = $this->Gestionventa->afipget($afip,'GetPointOfSales',0,0,0);

        $response['respuesta'] = $puntosdeventas;
        $this->layout = 'ajax';
        $this->set('data', $response);
        $this->render('serializejson');
    }
    public function enviarVentaAAFIP(){
        App::import('Vendor', 'Afip/Afip');
        $afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);    
        $CantReg=1;// Cantidad de comprobantes a registrar
        $PtoVta=1;// Punto de venta
        $CbteTipo=6;// Tipo de comprobante (ver tipos disponibles) 
        $Concepto=1;// Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
        $DocTipo=80;// Tipo de documento del comprador (ver tipos disponibles)
        $DocNro=20315483760;// Numero de documento del comprador

        //vamos a obtener el ultimo comprobante usado;
        $ultimoComprobanteUsado = $this->Gestionventa->afipget($afip,'GetLastVoucher',$PtoVta,$CbteTipo,0);
        $CbteDesde=$ultimoComprobanteUsado['respuesta'][0]+1;// Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
        $CbteHasta=$ultimoComprobanteUsado['respuesta'][0]+1;// Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
        $CbteFch= intval(date('Ymd'));// (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
        $ImpTotal=131; // Importe total del comprobante
        // ImpTotConc + ImpNeto + ImpOpEx + ImpTrib + ImpIVA.
        $ImpTotConc=0;// Importe neto no gravado
        $ImpNeto=100;// Importe neto gravado
        $ImpOpEx=0;// Importe exento de IVA
        $ImpIVA=21;//Importe total de IVA
        $ImpTrib=10; //Importe total de tributos
        $FchServDesde=1;// (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para 
        $FchServHasta=1;// (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        $FchVtoPago=1;// (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
        $oncepto=1;//Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
        $MonId=1; // Cotización de la moneda usada (1 para pesos argentinos)  
        $MonCotiz=1;          
        $Iva=array( // (Opcional) Alícuotas asociadas al comprobante
                        array(
                                'Id'        => 5, // Id del tipo de IVA (ver tipos disponibles) 
                                'BaseImp'   => 100, // Base imponible
                                'Importe'   => 21 // Importe 
                        )
                );
        $Tributos=array( // (Opcional) Tributos asociados al comprobante
                        array(
                                'Id'        =>  99, // Id del tipo de tributo (ver tipos disponibles) 
                                'Desc'      => 'Ingresos Brutos', // (Opcional) Descripcion
                                'BaseImp'   => 100, // Base imponible para el tributo
                                'Alic'      => 10, // Alícuota
                                'Importe'   => 10 // Importe del tributo
                        )
                );
        if($this->request->is('post')) {

        }
        $data = array(
                'CantReg' 		=> $CantReg, // Cantidad de comprobantes a registrar
                'PtoVta' 		=> $PtoVta, // Punto de venta
                'CbteTipo' 		=> $CbteTipo, // Tipo de comprobante (ver tipos disponibles) 
                'Concepto' 		=> $Concepto, // Concepto del Comprobante: (1)Productos, (2)Servicios, (3)Productos y Servicios
                'DocTipo' 		=> $DocTipo, // Tipo de documento del comprador (ver tipos disponibles)
                'DocNro' 		=> $DocNro, // Numero de documento del comprador
                'CbteDesde' 	=> $CbteDesde, // Numero de comprobante o numero del primer comprobante en caso de ser mas de uno
                'CbteHasta' 	=> $CbteHasta, // Numero de comprobante o numero del ultimo comprobante en caso de ser mas de uno
                'CbteFch' 		=> intval(date('Ymd')), // (Opcional) Fecha del comprobante (yyyymmdd) o fecha actual si es nulo
                'ImpTotal' 		=> $ImpTotal, // Importe total del comprobante
                'ImpTotConc' 	=> $ImpTotConc, // Importe neto no gravado
                'ImpNeto' 		=> $ImpNeto, // Importe neto gravado
                'ImpOpEx' 		=> $ImpOpEx, // Importe exento de IVA
                'ImpIVA' 		=> $ImpIVA, //Importe total de IVA
                'ImpTrib' 		=> $ImpTrib , //Importe total de tributos
                'FchServDesde' 	=> NULL, // (Opcional) Fecha de inicio del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'FchServHasta' 	=> NULL, // (Opcional) Fecha de fin del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'FchVtoPago' 	=> NULL, // (Opcional) Fecha de vencimiento del servicio (yyyymmdd), obligatorio para Concepto 2 y 3
                'MonId' 		=> 'PES', //Tipo de moneda usada en el comprobante (ver tipos disponibles)('PES' para pesos argentinos) 
                'MonCotiz' 		=> 1, // Cotización de la moneda usada (1 para pesos argentinos)  
               /*'CbtesAsoc' 	=> array( // (Opcional) Comprobantes asociados
                        array(
                                'Tipo' 		=> 991, // Tipo de comprobante (ver tipos disponibles) 
                                'PtoVta' 	=> 1, // Punto de venta
                                'Nro' 		=> 1, // Numero de comprobante
                                'Cuit' 		=> 20111111112 // (Opcional) Cuit del emisor del comprobante
                                )
                        ),*/
                'Tributos'      => $Tributos, 
                'Iva'           => $Iva
                , 
                /*'Opcionales' 	=> array( // (Opcional) Campos auxiliares
                        array(
                                'Id' 		=> 17, // Codigo de tipo de opcion (ver tipos disponibles) 
                                'Valor' 	=> 2 // Valor 
                        )
                ),   */              
    //                'Compradores' 	=> array( // (Opcional) Detalles de los clientes del comprobante 
    //                        array(
    //                                'DocTipo' 		=> 80, // Tipo de documento (ver tipos disponibles) 
    //                                'DocNro' 		=> 20111111112, // Numero de documento
    //                                'Porcentaje' 	=> 100 // Porcentaje de titularidad del comprador
    //                        )
    //                )
            );
        $result = $afip->ElectronicBilling->CreateVoucher($data);
        Debugger::dump($result);
        $response['respuesta'] = $result;
        $this->layout = 'ajax';
        $this->set('data', $response);
        $this->render('serializejson');
    }
    public function afipgetserverstatus(){
        $this->loadModel('Puntosdeventa');
        App::import('Vendor', 'Afip/Afip');
        $cliente_id = $this->Session->read('Auth.User.cliente_id');
        $response = [];
        //Servicio de testing NO BORRAR
        $afip = new Afip([
            'CUIT' => 20330462478,
            'cert' => 'certHomo.crt',
            'key' => 'private',
            'passphrase'=>'private',
            'production'=>false
        ]);             
        $serverStatus = $afip->ElectronicBilling->GetServerStatus();
        $response['respuesta'] = [$serverStatus];
        $this->layout = 'ajax';
        $this->set('data', $response);
        $this->render('serializejson');
    }

   
}
