<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DetalleventasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DetalleventasTable Test Case
 */
class DetalleventasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\DetalleventasTable
     */
    public $Detalleventas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.detalleventas',
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
        $config = TableRegistry::getTableLocator()->exists('Detalleventas') ? [] : ['className' => DetalleventasTable::class];
        $this->Detalleventas = TableRegistry::getTableLocator()->get('Detalleventas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Detalleventas);

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
