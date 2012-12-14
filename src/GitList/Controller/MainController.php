<?php

namespace GitList\Controller;

use Silex\Application;
use Silex\ControllerProviderInterface;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Response;

class MainController implements ControllerProviderInterface
{
    public function connect(Application $app)
    {
        $route = $app['controllers_factory'];

        $route->get('/', function() use ($app) {
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
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
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
        })->assert('repo', '[\w-._]+')
          ->assert('branch', '[\w-._]+')
          ->bind('rss');


        return $route;
    }
}
