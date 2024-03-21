<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PuntodeventasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PuntodeventasTable Test Case
 */
class PuntodeventasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PuntodeventasTable
     */
    public $Puntodeventas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.puntodeventas',
        'app.ventas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Puntodeventas') ? [] : ['className' => PuntodeventasTable::class];
        $this->Puntodeventas = TableRegistry::getTableLocator()->get('Puntodeventas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Puntodeventas);

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
}
