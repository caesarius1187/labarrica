<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductosTable Test Case
 */
class ProductosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductosTable
     */
    public $Productos;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.productos',
        'app.rubros',
        'app.detallecompras',
        'app.detalleventas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Productos') ? [] : ['className' => ProductosTable::class];
        $this->Productos = TableRegistry::getTableLocator()->get('Productos', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Productos);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
