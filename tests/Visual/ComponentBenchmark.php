<?php

namespace Tito10047\UX\TwigComponentSdc\Tests\Visual;

use Symfony\Component\Filesystem\Filesystem;
use Tito10047\UX\TwigComponentSdc\Tests\Visual\ComponentGenerator\ComponentGenerator;
use PhpBench\Benchmark\Metadata\Annotations\BeforeMethods;

/**
 * @BeforeMethods({"prepare"})
 */
class ComponentBenchmark
{
    private string $generatedDir;
    private Filesystem $fs;

    public function __construct()
    {
        $this->generatedDir = __DIR__ . '/Generated';
        $this->fs = new Filesystem();
    }

    public function prepare(): void
    {
        $generator = new ComponentGenerator();

        // Vymažeme staré generované súbory
        if (is_dir($this->generatedDir)) {
            $this->fs->remove($this->generatedDir);
        }

        // 1. Generovanie 1000 komponentov
        $generator->generate($this->generatedDir . '/Classic', 1000, false);
        $generator->generate($this->generatedDir . '/Sdc', 1000, true);

        // 2. Vytvorenie stress-test šablóny pre Twig (aby sme nemerali Twig compilation)
        $this->createStressTestTemplate('classic', 1000);
        $this->createStressTestTemplate('sdc', 1000);
    }

    private function createStressTestTemplate(string $type, int $count): void
    {
        $content = '';
        $prefix = $type === 'sdc' ? 'SdcComp' : 'ClassicComp';
        for ($i = 1; $i <= $count; $i++) {
            $content .= "<twig:$prefix$i />\n";
        }

        $path = $this->generatedDir . "/" . ucfirst($type) . "/stress_test_$type.html.twig";
        file_put_contents($path, $content);
    }

    private function clearCache(string $env): void
    {
        $cacheDir = __DIR__ . '/../../var/cache/' . $env;
        if (is_dir($cacheDir)) {
            $this->fs->remove($cacheDir);
        }
    }

    // --- WARMUP BENCHMARKS (Cold Boot) ---

    /**
     * Meria čas kompilácie kontajnera pre Classic prístup.
     * @Revs(1)
     * @Iterations(5)
     */
    public function benchWarmupClassic(): void
    {
        $this->clearCache('classic');
        $kernel = new BenchmarkKernel('classic', 'test', true);
        $kernel->boot();
    }

    /**
     * Meria čas kompilácie kontajnera pre tvoj SDC bundle.
     * @Revs(1)
     * @Iterations(5)
     */
    public function benchWarmupSdc(): void
    {
        $this->clearCache('sdc');
        $kernel = new BenchmarkKernel('sdc', 'test', true);
        $kernel->boot();
    }

    // --- RENDER BENCHMARKS (Hot Runtime) ---

    /**
     * @Revs(10)
     * @Iterations(5)
     */
    public function benchRenderClassic(): void
    {
        $kernel = new BenchmarkKernel('classic', 'test', false);
        $kernel->boot();

        $twig = $kernel->getContainer()->get('twig');
        $twig->render('stress_test_classic.html.twig');
    }

    /**
     * @Revs(10)
     * @Iterations(5)
     */
    public function benchRenderSdc(): void
    {
        $kernel = new BenchmarkKernel('sdc', 'test', false);
        $kernel->boot();

        $twig = $kernel->getContainer()->get('twig');
        $twig->render('stress_test_sdc.html.twig');
    }
}
