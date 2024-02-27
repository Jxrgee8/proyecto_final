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

use App\Service\UxPackageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ManagerController extends AbstractController
{
    #[Route('/manager', name: 'app_manager')]
    public function __invoke(UxPackageRepository $packageRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $package = $packageRepository->find('chartjs');

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            'datasets' => [
                [
                    'label' => 'Nº Series',
                    'barPercentage' => 0.5,
                    'barThickness' => 40,
                    'data' => [12, 20, 32, 45, 62, 50, 15, 26, 40, 38, 22, 65, 70],
                    'backgroundColor' => [
                        'rgba(153, 102, 255, 0.2)',
                      ],
                      'borderColor' => [
                        'rgb(153, 102, 255)',
                      ],
                    'borderWidth' => 1,
                    'tension' => 0.4,
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
}
