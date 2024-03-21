<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ExtraccionesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ExtraccionesTable Test Case
 */
class ExtraccionesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ExtraccionesTable
     */
    public $Extracciones;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.extracciones'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Extracciones') ? [] : ['className' => ExtraccionesTable::class];
        $this->Extracciones = TableRegistry::getTableLocator()->get('Extracciones', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Extracciones);

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
