<?php namespace Tests\Repositories;

use App\Models\Plot;
use App\Repositories\PlotRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PlotRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PlotRepository
     */
    protected $plotRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->plotRepo = \App::make(PlotRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_plot()
    {
        $plot = Plot::factory()->make()->toArray();

        $createdPlot = $this->plotRepo->create($plot);

        $createdPlot = $createdPlot->toArray();
        $this->assertArrayHasKey('id', $createdPlot);
        $this->assertNotNull($createdPlot['id'], 'Created Plot must have id specified');
        $this->assertNotNull(Plot::find($createdPlot['id']), 'Plot with given id must be in DB');
        $this->assertModelData($plot, $createdPlot);
    }

    /**
     * @test read
     */
    public function test_read_plot()
    {
        $plot = Plot::factory()->create();

        $dbPlot = $this->plotRepo->find($plot->id);

        $dbPlot = $dbPlot->toArray();
        $this->assertModelData($plot->toArray(), $dbPlot);
    }

    /**
     * @test update
     */
    public function test_update_plot()
    {
        $plot = Plot::factory()->create();
        $fakePlot = Plot::factory()->make()->toArray();

        $updatedPlot = $this->plotRepo->update($fakePlot, $plot->id);

        $this->assertModelData($fakePlot, $updatedPlot->toArray());
        $dbPlot = $this->plotRepo->find($plot->id);
        $this->assertModelData($fakePlot, $dbPlot->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_plot()
    {
        $plot = Plot::factory()->create();

        $resp = $this->plotRepo->delete($plot->id);

        $this->assertTrue($resp);
        $this->assertNull(Plot::find($plot->id), 'Plot should not exist in DB');
    }
}
