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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerController extends AbstractController
{
    #[Route('/manager', name: 'manager')]
    public function manager(SerieRepository $serieRepository): Response
    {
        // TODO: Obtener datos de la BBDD:
        $generos = $serieRepository->countGeneros();

        //? dump($generos);

        $data = [];
        foreach ($generos as $genero) {
            if (isset($genero['nombre']) && isset($genero['num'])) {
                $data[] = [
                    'nombre' => $genero['nombre'],
                    'num' => $genero['num']
                ];
            }
        }

        return $this->render('manager/manager.html.twig', [
            'data' => $data         
        ]);
    }
}
