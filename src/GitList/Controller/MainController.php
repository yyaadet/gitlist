<?php

namespace GitList\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
<<<<<<< HEAD
use Silex\ControllerCollection;
=======
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
use Symfony\Component\HttpFoundation\Response;

class MainController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $route = $app['controllers_factory'];

        $route->get('/', function() use ($app) {
<<<<<<< HEAD
            $repositories = $app['git']->getRepositories($app['git.repos']);
            
            foreach ($repositories as &$repository) { 
                $repo = $app['git']->getRepository($app['git.repos'] . $repository["name"]);
                $branch = "master";
                $file = null;
                $type = $file ? "$branch -- $file" : $branch;
                $commits = $repo->getPaginatedCommits($type);
                $categorized = array();
    
                foreach ($commits as $commit) {
                    $date = $commit->getDate();
                    $date = $date->format('m/d/Y');
                    $categorized[$date][] = $commit;
                    if (count($categorized[$date]) > 3) break; 
                }
                
                $repository["commits"] = $categorized;
            }
            
=======
            $repositories = array_map(
                function ($repo) use ($app) {
                    $repo['relativePath'] = $app['util.routing']->getRelativePath($repo['path']);
                    return $repo;
                },
                $app['git']->getRepositories($app['git.repos'])
            );
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4

            return $app['twig']->render('index.twig', array(
                'repositories'   => $repositories,
            ));
        })->bind('homepage');

        $route->get('{repo}/stats/{branch}', function($repo, $branch) use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
            $stats = $repository->getStatistics($branch);
            $authors = $repository->getAuthorStatistics();

            return $app['twig']->render('stats.twig', array(
                'repo'           => $repo,
                'branch'         => $branch,
                'branches'       => $repository->getBranches(),
                'tags'           => $repository->getTags(),
                'stats'          => $stats,
                'authors'         => $authors,
            ));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('branch', '[\w-._\/]+')
>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
          ->value('branch', 'master')
          ->bind('stats');

        $route->get('{repo}/{branch}/rss/', function($repo, $branch) use ($app) {
            $repository = $app['git']->getRepository($app['git.repos'] . $repo);
            $commits = $repository->getPaginatedCommits($branch);

            $html = $app['twig']->render('rss.twig', array(
                'repo'           => $repo,
                'branch'         => $branch,
                'commits'        => $commits,
            ));

            return new Response($html, 200, array('Content-Type' => 'application/rss+xml'));
<<<<<<< HEAD
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
          ->bind('rss');


=======
        })->assert('repo', $app['util.routing']->getRepositoryRegex())
          ->assert('branch', '[\w-._\/]+')
          ->bind('rss');

>>>>>>> 44ed193402c5a25cddbc80ef0c87183111f348b4
        return $route;
    }
}
