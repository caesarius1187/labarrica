<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CajasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CajasTable Test Case
 */
class CajasTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CajasTable
     */
    public $Cajas;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.cajas',
        'app.users',
        'app.puntodeventas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Cajas') ? [] : ['className' => CajasTable::class];
        $this->Cajas = TableRegistry::getTableLocator()->get('Cajas', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Cajas);

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
