<?php

namespace Codtail\AdminSuit\Tests\Feature;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

use Codtail\AdminSuit\Tests\TestCase;

class FilterMakeCommandTest extends TestCase
{
    /** @test */
    function it_creates_a_new_filter_class()
    {
        // destination path of the filter class
        $filterClass = app_path('AdminSuit/Filters/MyFilterClass.php');

        // make sure we're starting from a clean state
        if (File::exists($filterClass)) {
            unlink($filterClass);
        }

        $this->assertFalse(File::exists($filterClass));

        // Run the make command
        Artisan::call('adsu-make:filter MyFilterClass');

        // Assert a new file is created
        $this->assertTrue(File::exists($filterClass));

        $builder = '$builder';
        // Assert the file contains the right contents
        $expectedContents = <<<CLASS
<?php

namespace App\AdminSuit\Filters;

use Codtail\AdminSuit\Support\Filters\FilterAbstract;

class MyFilterClass extends FilterAbstract
{
    protected function apply($builder)
    {
        // TODO apply filter here
        return $builder;
    }
}
CLASS;

        $this->assertEquals($expectedContents, file_get_contents($filterClass));
    }
}