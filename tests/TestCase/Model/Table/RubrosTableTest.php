<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\RubrosTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\RubrosTable Test Case
 */
class RubrosTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\RubrosTable
     */
    public $Rubros;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.rubros',
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
        $config = TableRegistry::getTableLocator()->exists('Rubros') ? [] : ['className' => RubrosTable::class];
        $this->Rubros = TableRegistry::getTableLocator()->get('Rubros', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Rubros);

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
