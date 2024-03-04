<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Manager;

use App\Repository\SerieRepository;
use App\Service\UxPackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ManagerController extends AbstractController
{
    #[Route('/manager', name: 'manager')]
    public function __invoke(UxPackageRepository $packageRepository, ChartBuilderInterface $chartBuilder, SerieRepository $serieRepository): Response
    {
        $package = $packageRepository->find('chartjs');

        // TODO: Obtener datos de la BBDD:
        $array_generos = $serieRepository->countGeneros();

        // ver: https://dev.to/mis0u/symfony-ux-and-chartjs-ff4
        // ver: https://dev.to/qferrer/creating-a-covid-19-data-visualization-with-symfony-ux-chart-js-2khj#render-chart
        $labels = [];
        $data = [];

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Géneros Más Comunes',
                    'barPercentage' => 0.5,
                    'barThickness' => 40,
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(153, 102, 255, 0.2)',
                      ],
                      'borderColor' => [
                        'rgb(153, 102, 255)',
                      ],
                    'borderWidth' => 1,
                ]
            ],
        ]);
        $chart->setOptions([
            'maintainAspectRatio' => false,
        ]);

        return $this->render('manager/manager.html.twig', [
            'package' => $package,
            'chart' => $chart,
        ]);
    }

    #[Route('/manager_prueba', name: 'manager_prueba')]
    public function prueba(SerieRepository $serieRepository): Response {
        $array_generos = $serieRepository->countGeneros();

        return $this->render('manager/manager_prueba.html.twig', [
            'array_generos' => $array_generos 
        ]);
    }
}
