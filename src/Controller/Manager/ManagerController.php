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
    #[Route('/manager', name: 'manager')]
    public function __invoke(UxPackageRepository $packageRepository, ChartBuilderInterface $chartBuilder): Response
    {
        $package = $packageRepository->find('chartjs');
        $labels = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        // TODO: obtener data de la base de datos:
        $data = [12, 20, 32, 45, 62, 50, 15, 26, 40, 38, 22, 65, 70];

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Series Vistas',
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
}
