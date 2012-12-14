<?php

namespace GitList\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
<<<<<<< HEAD
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;
=======
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Request;

class TreeController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $route = $app['controllers_factory'];

        $route->get('{repo}/tree/{branch}/{tree}/', $treeController = function($repo, $branch = '', $tree = '') use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
            if (!$branch) {
                $branch = $repository->getHead();
            }
<<<<<<< HEAD
=======

            list($branch, $tree) = $app['util.repository']->extractRef($repository, $branch, $tree);
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
            $files = $repository->getTree($tree ? "$branch:\"$tree\"/" : $branch);
            $breadcrumbs = $app['util.view']->getBreadcrumbs($tree);

            $parent = null;
            if (($slash = strrpos($tree, '/')) !== false) {
                $parent = substr($tree, 0, $slash);
            } elseif (!empty($tree)) {
                $parent = '';
            }

            return $app['twig']->render('tree.twig', array(
                'files'          => $files->output(),
                'repo'           => $repo,
                'branch'         => $branch,
                'path'           => $tree ? $tree . '/' : $tree,
                'parent'         => $parent,
                'breadcrumbs'    => $breadcrumbs,
                'branches'       => $repository->getBranches(),
                'tags'           => $repository->getTags(),
                'readme'         => $app['util.repository']->getReadme($repo, $branch),
            ));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('branch', '[\w-._\/]+')
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->assert('tree', '.+')
          ->bind('tree');

        $route->post('{repo}/tree/{branch}/search', function(Request $request, $repo, $branch = '', $tree = '') use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);

            if (!$branch) {
                $branch = $repository->getHead();
            }

            $breadcrumbs = $app['util.view']->getBreadcrumbs($tree);
            $results = $repository->searchTree($request->get('query'), $branch);

            return $app['twig']->render('search.twig', array(
                'results'        => $results,
                'repo'           => $repo,
                'branch'         => $branch,
                'path'           => $tree,
                'breadcrumbs'    => $breadcrumbs,
                'branches'       => $repository->getBranches(),
                'tags'           => $repository->getTags(),
            ));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('branch', '[\w-._\/]+')
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->bind('search');

        $route->get('{repo}/{branch}/', function($repo, $branch) use ($app, $treeController) {
            return $treeController($repo, $branch);
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('branch', '[\w-._\/]+')
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->bind('branch');

        $route->get('{repo}/', function($repo) use ($app, $treeController) {
            return $treeController($repo);
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->bind('repository');

        $route->get('{repo}/{format}ball/{branch}', function($repo, $format, $branch) use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
            $tree = $repository->getBranchTree($branch);

            if (false === $tree) {
                return $app->abort(404, 'Invalid commit or tree reference: ' . $branch);
            }

            $file = $app['cache.archives'] . DIRECTORY_SEPARATOR
                    . $repo . DIRECTORY_SEPARATOR
                    . substr($tree, 0, 2) . DIRECTORY_SEPARATOR
                    . substr($tree, 2)
                    . '.'
                    . $format;

            if (!file_exists($file)) {
                $repository->createArchive($tree, $file, $format);
            }

            return new StreamedResponse(function () use ($file) {
                readfile($file);
            }, 200, array(
                'Content-type' => ('zip' === $format) ? 'application/zip' : 'application/x-tar',
                'Content-Description' => 'File Transfer',
                'Content-Disposition' => 'attachment; filename="'.$repo.'-'.substr($tree, 0, 6).'.'.$format.'"',
                'Content-Transfer-Encoding' => 'binary',
            ));
        })->assert('format', '(zip|tar)')
<<<<<<< HEAD
          ->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
=======
          ->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('branch', '[\w-._\/]+')
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->bind('archive');

        return $route;
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
