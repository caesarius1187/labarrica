<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DetallecomprasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DetallecomprasTable Test Case
 */
class DetallecomprasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DetallecomprasTable
     */
    public $Detallecompras;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.detallecompras',
        'app.compras',
        'app.productos'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Detallecompras') ? [] : ['className' => DetallecomprasTable::class];
        $this->Detallecompras = TableRegistry::getTableLocator()->get('Detallecompras', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Detallecompras);

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
